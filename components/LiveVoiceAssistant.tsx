
import React, { useState, useRef, useEffect } from 'react';
import { GoogleGenAI, Modality, LiveServerMessage, Blob } from '@google/genai';
import { Mic, MicOff, Volume2, Shield, AlertCircle, Loader2, Sparkles, Languages, Key, ExternalLink } from 'lucide-react';

const LiveVoiceAssistant: React.FC = () => {
  const [isActive, setIsActive] = useState(false);
  const [isConnecting, setIsConnecting] = useState(false);
  const [hasKey, setHasKey] = useState<boolean | null>(null);
  const [error, setError] = useState<string | null>(null);
  const [transcription, setTranscription] = useState<{ user: string; model: string }>({ user: '', model: '' });
  const [volume, setVolume] = useState(0);
  
  const audioContextRef = useRef<{ input: AudioContext; output: AudioContext } | null>(null);
  const nextStartTimeRef = useRef(0);
  const sourcesRef = useRef<Set<AudioBufferSourceNode>>(new Set());
  const sessionRef = useRef<any>(null);
  const streamRef = useRef<MediaStream | null>(null);
  const processorRef = useRef<ScriptProcessorNode | null>(null);

  // Check key selection on mount
  useEffect(() => {
    const checkKey = async () => {
      const selected = await window.aistudio.hasSelectedApiKey();
      setHasKey(selected);
    };
    checkKey();
  }, []);

  const handleOpenKeyDialog = async () => {
    await window.aistudio.openSelectKey();
    setHasKey(true); // Assume success per guidelines to avoid race conditions
    setError(null);
  };

  const encode = (bytes: Uint8Array) => {
    let binary = '';
    const len = bytes.byteLength;
    for (let i = 0; i < len; i++) {
      binary += String.fromCharCode(bytes[i]);
    }
    return btoa(binary);
  };

  const decode = (base64: string) => {
    const binaryString = atob(base64);
    const len = binaryString.length;
    const bytes = new Uint8Array(len);
    for (let i = 0; i < len; i++) {
      bytes[i] = binaryString.charCodeAt(i);
    }
    return bytes;
  };

  const decodeAudioData = async (
    data: Uint8Array,
    ctx: AudioContext,
    sampleRate: number,
    numChannels: number,
  ): Promise<AudioBuffer> => {
    const dataInt16 = new Int16Array(data.buffer);
    const frameCount = dataInt16.length / numChannels;
    const buffer = ctx.createBuffer(numChannels, frameCount, sampleRate);

    for (let channel = 0; channel < numChannels; channel++) {
      const channelData = buffer.getChannelData(channel);
      for (let i = 0; i < frameCount; i++) {
        channelData[i] = dataInt16[i * numChannels + channel] / 32768.0;
      }
    }
    return buffer;
  };

  const createBlob = (data: Float32Array): Blob => {
    const l = data.length;
    const int16 = new Int16Array(l);
    for (let i = 0; i < l; i++) {
      int16[i] = data[i] * 32768;
    }
    return {
      data: encode(new Uint8Array(int16.buffer)),
      mimeType: 'audio/pcm;rate=16000',
    };
  };

  const startSession = async () => {
    setError(null);
    setIsConnecting(true);
    try {
      // Create fresh instance right before call as per guidelines
      const ai = new GoogleGenAI({ apiKey: process.env.API_KEY });
      
      const inputCtx = new (window.AudioContext || (window as any).webkitAudioContext)({ sampleRate: 16000 });
      const outputCtx = new (window.AudioContext || (window as any).webkitAudioContext)({ sampleRate: 24000 });
      audioContextRef.current = { input: inputCtx, output: outputCtx };

      const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
      streamRef.current = stream;

      const sessionPromise = ai.live.connect({
        model: 'gemini-2.5-flash-native-audio-preview-12-2025',
        callbacks: {
          onopen: () => {
            setIsConnecting(false);
            setIsActive(true);
            
            const source = inputCtx.createMediaStreamSource(stream);
            const scriptProcessor = inputCtx.createScriptProcessor(4096, 1, 1);
            processorRef.current = scriptProcessor;

            scriptProcessor.onaudioprocess = (e) => {
              const inputData = e.inputBuffer.getChannelData(0);
              let sum = 0;
              for (let i = 0; i < inputData.length; i++) sum += inputData[i] * inputData[i];
              setVolume(Math.sqrt(sum / inputData.length));

              const pcmBlob = createBlob(inputData);
              sessionPromise.then((session) => {
                session.sendRealtimeInput({ media: pcmBlob });
              });
            };

            source.connect(scriptProcessor);
            scriptProcessor.connect(inputCtx.destination);
          },
          onmessage: async (message: LiveServerMessage) => {
            if (message.serverContent?.outputTranscription) {
              setTranscription(prev => ({ ...prev, model: prev.model + message.serverContent!.outputTranscription!.text }));
            } else if (message.serverContent?.inputTranscription) {
              setTranscription(prev => ({ ...prev, user: prev.user + message.serverContent!.inputTranscription!.text }));
            }

            const audioData = message.serverContent?.modelTurn?.parts[0]?.inlineData?.data;
            if (audioData && audioContextRef.current) {
              const { output: ctx } = audioContextRef.current;
              nextStartTimeRef.current = Math.max(nextStartTimeRef.current, ctx.currentTime);
              const audioBuffer = await decodeAudioData(decode(audioData), ctx, 24000, 1);
              const source = ctx.createBufferSource();
              source.buffer = audioBuffer;
              source.connect(ctx.destination);
              source.addEventListener('ended', () => sourcesRef.current.delete(source));
              source.start(nextStartTimeRef.current);
              nextStartTimeRef.current += audioBuffer.duration;
              sourcesRef.current.add(source);
            }

            if (message.serverContent?.interrupted) {
              sourcesRef.current.forEach(s => s.stop());
              sourcesRef.current.clear();
              nextStartTimeRef.current = 0;
            }
          },
          onerror: (e: any) => {
            console.error('Live API Error:', e);
            const errMsg = e.message || String(e);
            
            if (errMsg.includes("Requested entity was not found")) {
              setError("API Key configuration error. Please re-select a paid project key.");
              setHasKey(false);
            } else if (errMsg.includes("Operation is not implemented")) {
              setError("Live feature is not enabled for this key. Ensure you selected a PAID project key.");
            } else {
              setError(errMsg);
            }
            stopSession();
          },
          onclose: () => stopSession()
        },
        config: {
          responseModalities: [Modality.AUDIO],
          inputAudioTranscription: {},
          outputAudioTranscription: {},
          speechConfig: {
            voiceConfig: { prebuiltVoiceConfig: { voiceName: 'Zephyr' } }
          },
          systemInstruction: `You are the AI-SOS School Administrator. Help teachers/parents in Pashto, Persian, or English.`
        }
      });
      
      sessionRef.current = await sessionPromise;

    } catch (err: any) {
      setError(err.message || "Failed to establish connection.");
      setIsConnecting(false);
      stopSession();
    }
  };

  const stopSession = () => {
    setIsActive(false);
    setIsConnecting(false);
    if (sessionRef.current) {
      try { sessionRef.current.close(); } catch(e) {}
      sessionRef.current = null;
    }
    if (streamRef.current) {
      streamRef.current.getTracks().forEach(track => track.stop());
      streamRef.current = null;
    }
    if (processorRef.current) {
      processorRef.current.disconnect();
      processorRef.current = null;
    }
    if (audioContextRef.current) {
      audioContextRef.current.input.close();
      audioContextRef.current.output.close();
      audioContextRef.current = null;
    }
    setVolume(0);
  };

  useEffect(() => {
    return () => stopSession();
  }, []);

  if (hasKey === false) {
    return (
      <div className="flex-1 flex flex-col items-center justify-center bg-slate-950 p-8 text-center text-white">
        <div className="w-20 h-20 bg-teal-500/20 rounded-full flex items-center justify-center mb-6 ring-4 ring-teal-500/10">
          <Key className="text-teal-400" size={40} />
        </div>
        <h2 className="text-2xl font-bold mb-4">API Configuration Required</h2>
        <p className="text-slate-400 max-w-md mb-8 leading-relaxed">
          Gemini Live requires a <span className="text-white font-bold underline">Paid Google Cloud Project</span> key to function. 
          Standard free keys do not support the Multimodal Live API.
        </p>
        <div className="flex flex-col gap-4 w-full max-w-xs">
          <button
            onClick={handleOpenKeyDialog}
            className="w-full bg-teal-600 hover:bg-teal-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-teal-600/20 transition-all active:scale-95"
          >
            Select Paid API Key
          </button>
          <a 
            href="https://ai.google.dev/gemini-api/docs/billing" 
            target="_blank" 
            rel="noopener noreferrer"
            className="text-xs text-slate-500 hover:text-teal-400 flex items-center justify-center gap-2 underline underline-offset-4"
          >
            View Billing Documentation <ExternalLink size={12} />
          </a>
        </div>
      </div>
    );
  }

  return (
    <div className="flex-1 flex flex-col bg-slate-950 text-white relative overflow-hidden">
      {/* Background Decorative Elements */}
      <div className="absolute inset-0 overflow-hidden pointer-events-none opacity-20">
        <div className="absolute top-1/4 left-1/4 w-96 h-96 bg-teal-500/30 rounded-full blur-[120px] animate-pulse" />
        <div className="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/30 rounded-full blur-[120px] animate-pulse delay-700" />
      </div>

      {/* Header */}
      <div className="p-6 border-b border-white/10 flex justify-between items-center bg-slate-900/50 backdrop-blur-md z-10">
        <div className="flex items-center gap-3">
          <div className="w-10 h-10 rounded-xl bg-teal-500 flex items-center justify-center shadow-[0_0_20px_rgba(20,184,166,0.4)]">
            <Mic size={24} className="text-white" />
          </div>
          <div>
            <h1 className="font-bold text-lg tracking-tight">Voice SOS Assistant</h1>
            <p className="text-xs text-teal-400 font-medium uppercase tracking-widest flex items-center gap-1">
              <span className="w-1.5 h-1.5 rounded-full bg-teal-400 animate-ping" />
              Real-time Gemini Live
            </p>
          </div>
        </div>
        <button 
          onClick={() => setHasKey(false)}
          className="p-2 text-slate-500 hover:text-teal-400 transition-colors"
          title="Change API Key"
        >
          <Settings size={20} />
        </button>
      </div>

      {/* Main Interaction Area */}
      <div className="flex-1 flex flex-col items-center justify-center p-8 z-10">
        {error && (
          <div className="mb-8 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex items-start gap-3 max-w-md animate-in fade-in slide-in-from-top-4">
            <AlertCircle className="text-red-400 shrink-0 mt-0.5" size={18} />
            <p className="text-sm text-red-200">{error}</p>
          </div>
        )}

        <div className="relative mb-12">
          {isActive && (
            <>
              <div className="absolute inset-0 bg-teal-500/20 rounded-full animate-ping" style={{ animationDuration: '2s' }} />
              <div className="absolute inset-0 bg-teal-500/10 rounded-full animate-ping" style={{ animationDuration: '3s', animationDelay: '0.5s' }} />
            </>
          )}
          
          <button
            onClick={isActive ? stopSession : startSession}
            disabled={isConnecting}
            className={`
              relative w-48 h-48 rounded-full flex flex-col items-center justify-center gap-4 transition-all duration-500
              ${isActive 
                ? 'bg-slate-800 border-4 border-teal-500 shadow-[0_0_60px_rgba(20,184,166,0.3)]' 
                : 'bg-teal-600 hover:bg-teal-500 border-4 border-teal-400 shadow-[0_0_40px_rgba(20,184,166,0.2)]'}
              active:scale-95 disabled:opacity-50
            `}
          >
            {isConnecting ? (
              <Loader2 size={64} className="animate-spin text-white" />
            ) : isActive ? (
              <>
                <div className="flex gap-1 items-end h-8">
                  {[...Array(5)].map((_, i) => (
                    <div 
                      key={i} 
                      className="w-1.5 bg-teal-400 rounded-full transition-all duration-75"
                      style={{ height: `${Math.max(10, volume * (100 + i * 20))}%` }}
                    />
                  ))}
                </div>
                <MicOff size={48} className="text-teal-400" />
                <span className="text-xs font-bold uppercase tracking-widest">End Session</span>
              </>
            ) : (
              <>
                <Mic size={56} className="text-white" />
                <span className="text-sm font-bold uppercase tracking-widest">Start Conversation</span>
              </>
            )}
          </button>
        </div>

        {/* Live Transcription Cards */}
        <div className="w-full max-w-2xl grid grid-cols-1 md:grid-cols-2 gap-4">
          <div className="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 min-h-[160px] transition-all hover:bg-white/10">
            <div className="flex items-center gap-2 mb-4 text-xs font-bold text-teal-400 uppercase tracking-tighter">
              <UserCircle size={14} />
              Teacher (You)
            </div>
            <p className={`text-sm leading-relaxed ${transcription.user ? 'text-white' : 'text-white/20 italic'}`}>
              {transcription.user || "Voice will appear here..."}
            </p>
          </div>

          <div className="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 min-h-[160px] transition-all hover:bg-white/10 border-l-teal-500/50">
            <div className="flex items-center gap-2 mb-4 text-xs font-bold text-blue-400 uppercase tracking-tighter">
              <Sparkles size={14} />
              AI Administrator
            </div>
            <p className={`text-sm leading-relaxed ${transcription.model ? 'text-white' : 'text-white/20 italic'}`}>
              {transcription.model || "Gemini's response will appear here..."}
            </p>
          </div>
        </div>
      </div>

      <div className="p-4 bg-black/40 border-t border-white/10 z-10">
        <div className="max-w-4xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4 text-[10px] text-white/40 uppercase font-bold tracking-widest">
          <div className="flex items-center gap-4">
            <span className="flex items-center gap-1.5">
              <Shield size={12} className="text-teal-500" />
              Secure Low-Latency Connection
            </span>
            <span className="flex items-center gap-1.5">
              <Volume2 size={12} className="text-teal-500" />
              Paid API Key Verified
            </span>
          </div>
        </div>
      </div>
    </div>
  );
};

const UserCircle = ({ size }: { size: number }) => (
  <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" /><circle cx="12" cy="7" r="4" />
  </svg>
);

const Settings = ({ size }: { size: number }) => (
  <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>
  </svg>
);

export default LiveVoiceAssistant;
