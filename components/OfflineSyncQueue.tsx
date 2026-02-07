
import React, { useState } from 'react';
import { CloudOff, RefreshCcw, CheckCircle2, Clock, Smartphone, AlertTriangle, ShieldCheck } from 'lucide-react';
import { Language, UI_LABELS } from '../types';

interface Props {
  currentLang: Language;
}

const OfflineSyncQueue: React.FC<Props> = ({ currentLang }) => {
  const isRTL = currentLang === Language.PASHTO || currentLang === Language.PERSIAN;
  const t = UI_LABELS[currentLang];
  const [isSyncing, setIsSyncing] = useState(false);
  
  const pendingMessages = [
    { id: 'm1', sender: isRTL ? 'ښوونکې مریم' : 'Teacher Maryam', timestamp: '09:12 AM', content: isRTL ? 'احمد خان غیرحاضر دی' : 'Ahmed Khan absent', type: 'Voice Note', size: '1.2MB' },
    { id: 'm2', sender: isRTL ? 'مدیر صیب' : 'Principal Zai', timestamp: '10:05 AM', content: isRTL ? 'تاریخ تایید کړئ' : 'Confirm date', type: 'Text', size: '2KB' },
  ];

  const triggerSync = () => {
    setIsSyncing(true);
    setTimeout(() => setIsSyncing(false), 3000);
  };

  return (
    <div className={`p-6 md:p-8 flex flex-col h-full bg-slate-50 space-y-8 overflow-y-auto custom-scrollbar ${isRTL ? 'text-right' : 'text-left'}`}>
      <div className={`flex flex-col md:flex-row md:items-center justify-between gap-6 ${isRTL ? 'flex-row-reverse' : ''}`}>
        <div className="space-y-1">
          <div className={`flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
            <h1 className="text-2xl font-bold text-slate-800">{t.sync}</h1>
            <div className="bg-orange-100 text-orange-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase flex items-center gap-1">
              <CloudOff size={10} /> {isRTL ? 'آفلاین' : 'Offline'}
            </div>
          </div>
          <p className="text-sm text-slate-500">{isRTL ? 'هغه پیغامونه چې لا همغږي شوي نه دي.' : 'Messages waiting for sync.'}</p>
        </div>
        <button 
          onClick={triggerSync}
          disabled={isSyncing}
          className={`
            flex items-center gap-2 px-6 py-3 rounded-2xl font-bold text-white shadow-lg transition-all
            ${isSyncing ? 'bg-slate-400 cursor-not-allowed' : 'bg-teal-600 hover:bg-teal-700 active:scale-95 shadow-teal-600/20'}
            ${isRTL ? 'flex-row-reverse' : ''}
          `}
        >
          {isSyncing ? <RefreshCcw size={18} className="animate-spin" /> : <RefreshCcw size={18} />}
          {isSyncing ? (isRTL ? 'همغږي کېږي...' : 'Syncing...') : t.syncButton}
        </button>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div className="lg:col-span-2 space-y-4">
          {pendingMessages.map((msg) => (
            <div key={msg.id} className={`bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between group hover:border-teal-500/50 transition-all ${isRTL ? 'flex-row-reverse' : ''}`}>
              <div className={`flex items-center gap-4 ${isRTL ? 'flex-row-reverse text-right' : ''}`}>
                <div className="w-12 h-12 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center group-hover:bg-teal-50 group-hover:text-teal-600 transition-colors">
                  <Smartphone size={24} />
                </div>
                <div>
                  <div className={`flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
                    <span className="font-bold text-slate-800">{msg.sender}</span>
                    <span className="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded uppercase">{msg.type}</span>
                  </div>
                  <p className="text-sm text-slate-500 truncate max-w-md italic">"{msg.content}"</p>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default OfflineSyncQueue;
