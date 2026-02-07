
import React, { useState, useEffect } from 'react';
import { 
  MessageSquare, 
  Database, 
  Activity, 
  Settings, 
  Smartphone, 
  ShieldCheck, 
  Zap,
  Globe,
  Menu,
  X,
  ChevronRight,
  Mic,
  BarChart3,
  CreditCard,
  CloudOff,
  BookOpen,
  Languages
} from 'lucide-react';
import WhatsAppSimulator from './components/WhatsAppSimulator';
import DatabaseManager from './components/DatabaseManager';
import ArchitectureFlow from './components/ArchitectureFlow';
import LiveVoiceAssistant from './components/LiveVoiceAssistant';
import AnalyticsDashboard from './components/AnalyticsDashboard';
import FinancialLedger from './components/FinancialLedger';
import OfflineSyncQueue from './components/OfflineSyncQueue';
import KnowledgeBase from './components/KnowledgeBase';
import { Language, UI_LABELS } from './types';

type TabId = 'simulator' | 'database' | 'architecture' | 'live' | 'analytics' | 'financials' | 'sync' | 'knowledge';

const App: React.FC = () => {
  const [activeTab, setActiveTab] = useState<TabId>('simulator');
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const [currentLang, setCurrentLang] = useState<Language>(Language.ENGLISH);

  const t = UI_LABELS[currentLang];
  const isRTL = currentLang === Language.PASHTO || currentLang === Language.PERSIAN;

  useEffect(() => {
    document.documentElement.dir = isRTL ? 'rtl' : 'ltr';
    document.documentElement.lang = currentLang;
  }, [currentLang, isRTL]);

  const tabs = [
    { id: 'analytics', name: t.dashboard, icon: BarChart3 },
    { id: 'simulator', name: t.whatsapp, icon: MessageSquare },
    { id: 'live', name: t.voice, icon: Mic },
    { id: 'financials', name: t.fees, icon: CreditCard },
    { id: 'sync', name: t.sync, icon: CloudOff },
    { id: 'knowledge', name: t.knowledge, icon: BookOpen },
    { id: 'database', name: t.database, icon: Database },
    { id: 'architecture', name: t.blueprint, icon: Zap },
  ];

  return (
    <div className={`min-h-screen flex flex-col md:flex-row bg-slate-50 ${isRTL ? 'font-arabic' : 'font-inter'}`}>
      {/* Mobile Header */}
      <header className="md:hidden bg-teal-600 text-white p-4 flex justify-between items-center shadow-lg sticky top-0 z-50">
        <div className="flex items-center gap-2">
          <Smartphone size={24} />
          <h1 className="font-bold text-lg">{t.appTitle}</h1>
        </div>
        <div className="flex items-center gap-4">
          <button onClick={() => setCurrentLang(prev => prev === Language.ENGLISH ? Language.PASHTO : prev === Language.PASHTO ? Language.PERSIAN : Language.ENGLISH)}>
            <Languages size={20} />
          </button>
          <button onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}>
            {isMobileMenuOpen ? <X size={24} /> : <Menu size={24} />}
          </button>
        </div>
      </header>

      {/* Sidebar */}
      <nav className={`
        ${isMobileMenuOpen ? 'translate-x-0 overflow-y-auto' : isRTL ? 'translate-x-full' : '-translate-x-full'}
        fixed inset-0 z-40 md:relative md:translate-x-0
        transition-transform duration-300 ease-in-out
        w-full md:w-64 bg-slate-900 text-slate-300 flex flex-col h-screen
      `}>
        <div className="p-6 hidden md:flex items-center gap-3 border-b border-slate-800 shrink-0">
          <div className="bg-teal-500 p-2 rounded-lg">
            <Zap className="text-white" size={24} />
          </div>
          <div className={isRTL ? 'text-right' : 'text-left'}>
            <h1 className="font-bold text-xl text-white">{t.appTitle}</h1>
            <p className="text-xs text-slate-500 uppercase tracking-widest font-semibold">{t.schoolOS}</p>
          </div>
        </div>

        <div className="flex-1 py-4 px-3 space-y-1 overflow-y-auto custom-scrollbar">
          {tabs.map((tab) => (
            <button
              key={tab.id}
              onClick={() => {
                setActiveTab(tab.id as TabId);
                setIsMobileMenuOpen(false);
              }}
              className={`
                w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all
                ${activeTab === tab.id 
                  ? 'bg-teal-600/20 text-teal-400 border-l-4 border-teal-500' 
                  : 'hover:bg-slate-800 hover:text-white'}
                ${isRTL ? 'flex-row-reverse text-right' : 'text-left'}
              `}
            >
              <tab.icon size={18} />
              <span className="font-medium text-sm">{tab.name}</span>
            </button>
          ))}
        </div>

        <div className="p-4 border-t border-slate-800 space-y-2 shrink-0">
          <div className="flex gap-2">
            {[Language.ENGLISH, Language.PASHTO, Language.PERSIAN].map(lang => (
              <button 
                key={lang}
                onClick={() => setCurrentLang(lang)}
                className={`flex-1 py-1 text-[10px] font-bold rounded border uppercase ${currentLang === lang ? 'bg-teal-600 text-white border-teal-600' : 'bg-slate-800 border-slate-700 text-slate-500'}`}
              >
                {lang}
              </button>
            ))}
          </div>
          <div className="flex items-center gap-3 text-xs opacity-70">
            <ShieldCheck size={14} className="text-teal-500" />
            <span>{t.sovereignty}</span>
          </div>
          <div className="flex items-center gap-3 text-xs opacity-70">
            <Globe size={14} className="text-teal-500" />
            <span>{t.native}</span>
          </div>
        </div>
      </nav>

      {/* Main Content */}
      <main className="flex-1 h-screen overflow-hidden flex flex-col bg-white">
        {activeTab === 'analytics' && <AnalyticsDashboard currentLang={currentLang} />}
        {activeTab === 'simulator' && <WhatsAppSimulator currentLang={currentLang} />}
        {activeTab === 'live' && <LiveVoiceAssistant currentLang={currentLang} />}
        {activeTab === 'financials' && <FinancialLedger currentLang={currentLang} />}
        {activeTab === 'sync' && <OfflineSyncQueue currentLang={currentLang} />}
        {activeTab === 'knowledge' && <KnowledgeBase currentLang={currentLang} />}
        {activeTab === 'database' && <DatabaseManager currentLang={currentLang} />}
        {activeTab === 'architecture' && <ArchitectureFlow currentLang={currentLang} />}
      </main>
    </div>
  );
};

export default App;
