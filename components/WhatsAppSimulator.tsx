
import React, { useState, useRef, useEffect } from 'react';
import { 
  Send, 
  Mic, 
  MoreVertical, 
  CheckCheck, 
  Play, 
  ArrowLeft,
  ChevronDown,
  Info,
  Database,
  Cpu,
  RefreshCcw,
  Languages,
  Zap,
  Globe
} from 'lucide-react';
import { ChatMessage, PipelineStep, Language, UI_LABELS } from '../types';
import { orchestrateAI } from '../services/geminiService';

interface Props {
  currentLang: Language;
}

const WhatsAppSimulator: React.FC<Props> = ({ currentLang }) => {
  const t = UI_LABELS[currentLang];
  const isRTL = currentLang === Language.PASHTO || currentLang === Language.PERSIAN;

  const [messages, setMessages] = useState<ChatMessage[]>([
    {
      id: '1',
      role: 'ai',
      type: 'text',
      content: currentLang === Language.ENGLISH ? 'Salam! How can I help you today? I can mark attendance or check fees for your students.' : currentLang === Language.PASHTO ? 'سلام! زه ستاسو سره نن څنګه مرسته کولی شم؟ زه کولی شم د شاګردانو حاضري ولیکم یا د هغوی فیسونه وګورم.' : 'سلام! چطور می‌توانم امروز به شما کمک کنم؟ من می‌توانم حضور و غیاب دانش‌آموزان را ثبت کنم یا شهریه آن‌ها را بررسی کنم.',
      timestamp: Date.now() - 3600000,
    }
  ]);
  const [inputValue, setInputValue] = useState('');
  const [isRecording, setIsRecording] = useState(false);
  const [activePipeline, setActivePipeline] = useState<PipelineStep[]>([]);
  const [lastDetectedLang, setLastDetectedLang] = useState<string | null>(null);
  const scrollRef = useRef<HTMLDivElement>(null);

  useEffect(() => {
    if (scrollRef.current) {
      scrollRef.current.scrollTop = scrollRef.current.scrollHeight;
    }
  }, [messages, activePipeline]);

  const runPipeline = async (input: string, isAudio: boolean) => {
    const steps: PipelineStep[] = [
      { id: 'asr', name: 'ASR: Whisper v3', status: 'processing', details: isAudio ? 'Processing audio stream...' : 'Skipping (Text Input)' },
      { id: 'lang', name: isRTL ? 'د ژبې تشخیص' : 'Language Detection', status: 'idle' },
      { id: 'llm', name: 'LLM Orchestrator', status: 'idle' },
      { id: 'rag', name: 'RAG Context', status: 'idle' },
      { id: 'sql', name: 'SQL/ERP Action', status: 'idle' }
    ];
    setActivePipeline(steps);

    try {
      await new Promise(r => setTimeout(r, 800));
      steps[0].status = 'completed';
      steps[1].status = 'processing';
      steps[1].details = 'Identifying dialect/script...';
      setActivePipeline([...steps]);

      const aiResponse = await orchestrateAI(input);
      
      await new Promise(r => setTimeout(r, 600));
      steps[1].status = 'completed';
      steps[1].details = `Detected: ${aiResponse.detectedLanguage} (${Math.round(parseFloat(aiResponse.confidence) * 100)}%)`;
      setLastDetectedLang(aiResponse.detectedLanguage);
      
      steps[2].status = 'processing';
      steps[2].details = 'Gemini 3 Flash reasoning...';
      setActivePipeline([...steps]);

      await new Promise(r => setTimeout(r, 800));
      steps[2].status = 'completed';
      steps[3].status = 'completed';
      steps[3].details = 'Fetched: Students(Ahmed, Sara, Mustafa)';
      setActivePipeline([...steps]);

      steps[4].status = 'processing';
      steps[4].details = aiResponse.functionCalls ? 'Updating Database...' : 'Reading Database...';
      await new Promise(r => setTimeout(r, 600));
      steps[4].status = 'completed';
      setActivePipeline([...steps]);

      const responseText = aiResponse.text || "I have processed your request.";
      setMessages(prev => [...prev, {
        id: Date.now().toString(),
        role: 'ai',
        type: 'text',
        content: responseText,
        timestamp: Date.now(),
        pipeline: steps
      }]);
    } catch (error) {
      console.error(error);
    } finally {
      setTimeout(() => setActivePipeline([]), 2000);
    }
  };

  const handleSend = () => {
    if (!inputValue.trim()) return;
    const userMsg: ChatMessage = {
      id: Date.now().toString(),
      role: 'user',
      type: 'text',
      content: inputValue,
      timestamp: Date.now(),
    };
    setMessages(prev => [...prev, userMsg]);
    const input = inputValue;
    setInputValue('');
    runPipeline(input, false);
  };

  const toggleRecording = () => {
    if (isRecording) {
      const simulatedInput = currentLang === Language.PASHTO 
        ? "سلام، احمد نن رخصت دی، ځکه چې د حاصلاتو وخت دی."
        : currentLang === Language.PERSIAN 
          ? "سلام، احمد امروز غایب است به دلیل فصل برداشت."
          : "Ahmed is absent today due to harvest.";
      setMessages(prev => [...prev, {
        id: Date.now().toString(),
        role: 'user',
        type: 'audio',
        content: simulatedInput,
        timestamp: Date.now(),
      }]);
      runPipeline(simulatedInput, true);
    }
    setIsRecording(!isRecording);
  };

  return (
    <div className={`flex flex-col lg:flex-row h-full ${isRTL ? 'font-arabic' : 'font-inter'}`}>
      {/* WhatsApp Chat Area */}
      <div className="flex-1 flex flex-col bg-[#e5ddd5] h-full overflow-hidden relative">
        {/* Chat Header */}
        <div className="bg-[#075e54] text-white p-3 flex items-center justify-between shadow-md z-10">
          <div className={`flex items-center gap-3 ${isRTL ? 'flex-row-reverse' : 'flex-row'}`}>
            <ArrowLeft className="md:hidden" size={20} />
            <div className="w-10 h-10 rounded-full bg-slate-300 overflow-hidden border-2 border-teal-400">
              <img src="https://picsum.photos/seed/admin/100" alt="Bot" />
            </div>
            <div className={isRTL ? 'text-right' : 'text-left'}>
              <p className="font-bold text-sm">AI School Admin</p>
              <p className="text-[10px] text-teal-100 flex items-center gap-1 justify-end">
                <span className="w-2 h-2 rounded-full bg-green-400 inline-block animate-pulse" />
                {t.online}
              </p>
            </div>
          </div>
          <div className="flex items-center gap-4">
            {lastDetectedLang && (
              <div className="hidden sm:flex items-center gap-1.5 px-2 py-1 bg-black/20 rounded text-[10px] border border-white/10">
                <Globe size={10} className="text-teal-400" />
                <span className="font-bold uppercase tracking-widest">{lastDetectedLang}</span>
              </div>
            )}
            <MoreVertical size={20} />
          </div>
        </div>

        {/* Messages */}
        <div 
          ref={scrollRef}
          className="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar"
          style={{ backgroundImage: 'url("https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png")', backgroundRepeat: 'repeat' }}
        >
          {messages.map((msg) => (
            <div 
              key={msg.id} 
              className={`flex ${msg.role === 'user' ? 'justify-end' : 'justify-start'}`}
            >
              <div 
                className={`
                  max-w-[85%] px-3 py-2 rounded-lg shadow-sm relative group
                  ${msg.role === 'user' ? 'bg-[#dcf8c6] rounded-tr-none' : 'bg-white rounded-tl-none'}
                `}
              >
                {msg.type === 'audio' && (
                  <div className={`flex items-center gap-3 mb-1 pr-8 ${isRTL ? 'flex-row-reverse text-right' : ''}`}>
                    <div className="w-10 h-10 rounded-full bg-teal-600 flex items-center justify-center text-white shrink-0">
                      <Play size={18} />
                    </div>
                    <div className="flex-1 min-w-[100px]">
                      <div className="h-1 bg-gray-300 rounded-full overflow-hidden">
                        <div className="h-full bg-teal-600 w-1/3" />
                      </div>
                      <p className="text-[10px] text-gray-500 mt-1 uppercase font-bold tracking-tighter">Voice Note (0:12)</p>
                    </div>
                  </div>
                )}
                <p className={`text-sm ${msg.role === 'user' ? (isRTL ? 'text-right' : 'text-left') : (isRTL ? 'text-right font-arabic' : 'text-left')} ${msg.type === 'audio' ? 'italic text-gray-600 font-arabic' : 'text-slate-800'}`}>
                  {msg.content}
                </p>
                <div className={`flex items-center justify-end gap-1 mt-1 ${isRTL ? 'flex-row-reverse' : ''}`}>
                  <span className="text-[10px] text-gray-500">
                    {new Date(msg.timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}
                  </span>
                  {msg.role === 'user' && <CheckCheck size={14} className="text-blue-500" />}
                </div>
              </div>
            </div>
          ))}
        </div>

        {/* Input Area */}
        <div className="p-2 bg-[#f0f2f5] flex items-center gap-2">
          <button className="p-2 text-gray-500">
            <MoreVertical size={20} />
          </button>
          <div className={`flex-1 bg-white rounded-full px-4 py-2 flex items-center gap-2 border border-slate-200 shadow-inner ${isRTL ? 'flex-row-reverse' : ''}`}>
            <input 
              type="text" 
              placeholder={t.typeMessage} 
              className={`flex-1 text-sm outline-none bg-transparent ${isRTL ? 'text-right' : 'text-left'}`}
              value={inputValue}
              onChange={(e) => setInputValue(e.target.value)}
              onKeyDown={(e) => e.key === 'Enter' && handleSend()}
            />
          </div>
          <button 
            onClick={inputValue ? handleSend : toggleRecording}
            className={`p-3 rounded-full text-white transition-all transform active:scale-95 shadow-lg ${isRecording ? 'bg-red-500 animate-pulse' : 'bg-[#00a884] hover:bg-[#008f6f]'}`}
          >
            {inputValue ? <Send size={20} /> : <Mic size={20} />}
          </button>
        </div>
      </div>

      {/* Backend Visualizer (Desktop Only) */}
      <div className={`w-full lg:w-[400px] bg-white border-l border-gray-200 flex flex-col h-full overflow-hidden ${isRTL ? 'order-first border-r border-l-0' : 'order-last'}`}>
        <div className={`p-4 border-b border-gray-100 bg-slate-50 flex items-center justify-between ${isRTL ? 'flex-row-reverse' : ''}`}>
          <div className={`flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
            <Cpu size={20} className="text-teal-600" />
            <h2 className="font-bold text-slate-800">{t.pipelineTitle}</h2>
          </div>
          <span className="text-[10px] font-bold bg-green-100 text-green-700 px-2 py-0.5 rounded-full uppercase tracking-widest">Live</span>
        </div>

        <div className="flex-1 overflow-y-auto p-4 space-y-6">
          <div className="space-y-4">
            {(activePipeline.length > 0 ? activePipeline : messages[messages.length-1].pipeline || []).map((step, i) => (
              <div key={step.id} className={`relative ${isRTL ? 'pr-8' : 'pl-8'}`}>
                {/* Vertical Line */}
                <div className={`absolute ${isRTL ? 'right-3' : 'left-3'} top-6 bottom-[-10px] w-0.5 ${step.status === 'completed' ? 'bg-teal-500' : 'bg-gray-200'}`} />
                {/* Step Dot */}
                <div className={`
                  absolute ${isRTL ? 'right-0' : 'left-0'} top-1 w-6 h-6 rounded-full flex items-center justify-center border-2 transition-colors z-10
                  ${step.status === 'completed' ? 'bg-teal-500 border-teal-500 text-white shadow-sm' : 
                    step.status === 'processing' ? 'bg-white border-teal-500 text-teal-600 animate-pulse' : 
                    'bg-white border-gray-200 text-gray-300'}
                `}>
                  {step.status === 'completed' ? <CheckCheck size={12} /> : 
                   step.status === 'processing' ? <RefreshCcw size={12} className="animate-spin" /> : 
                   <div className="w-1.5 h-1.5 rounded-full bg-current" />}
                </div>
                
                <div className={`flex flex-col ${isRTL ? 'text-right' : 'text-left'}`}>
                  <span className={`text-xs font-bold uppercase tracking-tight ${step.status === 'idle' ? 'text-gray-400' : 'text-slate-700'}`}>
                    {step.name}
                  </span>
                  <span className="text-[11px] text-gray-500 leading-relaxed">
                    {step.details || (step.status === 'completed' ? 'Done' : '...')}
                  </span>
                </div>
              </div>
            ))}
          </div>

          {/* Database Insight */}
          <div className="mt-8 pt-6 border-t border-gray-100">
            <h3 className={`text-xs font-bold text-gray-400 uppercase mb-4 flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
              <Database size={12} />
              Queries
            </h3>
            <div className="p-3 bg-slate-900 rounded-lg font-mono text-[10px] text-teal-400 shadow-inner">
              <span className="text-pink-400">SELECT</span> * <span className="text-pink-400">FROM</span> students <br/>
              <span className="text-pink-400">WHERE</span> name <span className="text-pink-400">ILIKE</span> <span className="text-yellow-200">'%Ahmed%'</span>;
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default WhatsAppSimulator;
