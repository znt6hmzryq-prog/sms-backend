
import React from 'react';
import { 
  Smartphone, 
  Globe, 
  Cpu, 
  Server, 
  Database, 
  Shield, 
  ArrowRight,
  MessageSquare,
  Mic,
  Languages,
  Search
} from 'lucide-react';

const ArchitectureFlow: React.FC = () => {
  return (
    <div className="p-8 h-full bg-slate-50 overflow-y-auto custom-scrollbar">
      <div className="max-w-5xl mx-auto space-y-12 pb-20">
        <div className="text-center space-y-4">
          <h1 className="text-3xl font-bold text-slate-800">The AI-SOS Event Pipeline</h1>
          <p className="text-slate-500 max-w-2xl mx-auto">
            Prioritizing low-latency reasoning and multi-lingual accuracy for emerging markets using Gemini 3 Flash.
          </p>
        </div>

        {/* Visual Diagram */}
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
          {/* Path Lines - Mobile: Vertical, Desktop: Horizontal (Visualized with simple layout) */}
          
          {/* Step 1: User Input */}
          <div className="flex flex-col items-center gap-6 group">
            <div className="w-full bg-white p-6 rounded-2xl shadow-sm border-2 border-slate-100 group-hover:border-teal-500 transition-all flex flex-col items-center text-center">
              <div className="w-16 h-16 bg-teal-100 text-teal-600 rounded-full flex items-center justify-center mb-4 ring-8 ring-teal-50">
                <Smartphone size={32} />
              </div>
              <h3 className="font-bold text-slate-800">Ingestion Layer</h3>
              <p className="text-xs text-slate-500 mt-2">WhatsApp Webhooks triggered by Voice Note / Text.</p>
              <div className="mt-4 flex gap-2">
                <span className="px-2 py-1 bg-teal-50 text-[10px] font-bold text-teal-700 rounded border border-teal-100 uppercase">FastAPI</span>
                <span className="px-2 py-1 bg-teal-50 text-[10px] font-bold text-teal-700 rounded border border-teal-100 uppercase">Docker</span>
              </div>
            </div>
            <ArrowRight size={24} className="text-slate-300 transform md:rotate-0 rotate-90" />
          </div>

          {/* Step 2: The AI Brain */}
          <div className="flex flex-col items-center gap-6 group">
            <div className="w-full bg-slate-900 p-6 rounded-2xl shadow-xl border-2 border-slate-800 group-hover:border-teal-400 transition-all flex flex-col items-center text-center text-white relative">
              <div className="absolute -top-3 right-4 bg-teal-500 text-[10px] font-bold px-2 py-1 rounded text-white shadow-lg">GEMINI POWERED</div>
              <div className="w-16 h-16 bg-teal-600/30 text-teal-400 rounded-full flex items-center justify-center mb-4 ring-8 ring-slate-800">
                <Cpu size={32} />
              </div>
              <h3 className="font-bold">Neural Engine</h3>
              <p className="text-xs text-slate-400 mt-2">Whisper v3 ASR + Gemini 3 Pro Reasoning + RAG Search.</p>
              <div className="mt-4 flex flex-wrap justify-center gap-2">
                <div className="flex items-center gap-1 px-2 py-1 bg-slate-800 text-[10px] text-teal-400 rounded">
                  <Mic size={10} /> Whisper
                </div>
                <div className="flex items-center gap-1 px-2 py-1 bg-slate-800 text-[10px] text-teal-400 rounded">
                  <Languages size={10} /> Pashto/Farsi
                </div>
                <div className="flex items-center gap-1 px-2 py-1 bg-slate-800 text-[10px] text-teal-400 rounded">
                  <Search size={10} /> pgvector
                </div>
              </div>
            </div>
            <ArrowRight size={24} className="text-slate-300 transform md:rotate-0 rotate-90" />
          </div>

          {/* Step 3: School ERP */}
          <div className="flex flex-col items-center group">
            <div className="w-full bg-white p-6 rounded-2xl shadow-sm border-2 border-slate-100 group-hover:border-teal-500 transition-all flex flex-col items-center text-center">
              <div className="w-16 h-16 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center mb-4 ring-8 ring-slate-50">
                <Database size={32} />
              </div>
              <h3 className="font-bold text-slate-800">Data & ERP Action</h3>
              <p className="text-xs text-slate-500 mt-2">Marking attendance, Checking Ledger, or SMS Dispatch.</p>
              <div className="mt-4 flex gap-2">
                <span className="px-2 py-1 bg-slate-50 text-[10px] font-bold text-slate-700 rounded border border-slate-100 uppercase">PostgreSQL</span>
                <span className="px-2 py-1 bg-slate-50 text-[10px] font-bold text-slate-700 rounded border border-slate-100 uppercase">Twilio/Meta</span>
              </div>
            </div>
          </div>
        </div>

        {/* Feature Highlights */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
          <div className="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <h4 className="font-bold text-slate-800 mb-4 flex items-center gap-2">
              <Globe className="text-teal-600" size={20} />
              Language Strategy
            </h4>
            <div className="space-y-4 text-sm text-slate-600">
              <div className="p-3 bg-slate-50 rounded-lg">
                <p className="font-bold text-[10px] uppercase text-slate-400 mb-1">Pashto ASR Optimization</p>
                <p>Whisper v3 handles the dialect while Gemini extracts English intents to minimize logic errors across mixed-mode speech.</p>
              </div>
              <div className="p-3 bg-slate-50 rounded-lg">
                <p className="font-bold text-[10px] uppercase text-slate-400 mb-1">Romanized Input Handling</p>
                <p>Advanced system prompting allows the LLM to understand 'Pinglish' (Pashto in English script) used widely by younger staff.</p>
              </div>
            </div>
          </div>

          <div className="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <h4 className="font-bold text-slate-800 mb-4 flex items-center gap-2">
              <Shield className="text-teal-600" size={20} />
              Reliability & Connectivity
            </h4>
            <div className="space-y-4 text-sm text-slate-600">
              <div className="p-3 bg-slate-50 rounded-lg">
                <p className="font-bold text-[10px] uppercase text-slate-400 mb-1">Timestamp Correction</p>
                <p>When messages are sent in offline bursts, the backend uses message metadata to mark attendance for the <strong>time of recording</strong>, not the time of receipt.</p>
              </div>
              <div className="p-3 bg-slate-50 rounded-lg">
                <p className="font-bold text-[10px] uppercase text-slate-400 mb-1">Disambiguation Logic</p>
                <p>Fuzzy-name matching in the SQL layer allows for identification even with common names like 'Ahmed Khan'.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default ArchitectureFlow;
