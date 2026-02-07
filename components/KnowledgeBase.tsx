
import React from 'react';
import { BookOpen, Search, FileText, Globe, Lock, MoreHorizontal, Database } from 'lucide-react';
import { Language, UI_LABELS } from '../types';

interface Props {
  currentLang: Language;
}

const KnowledgeBase: React.FC<Props> = ({ currentLang }) => {
  const isRTL = currentLang === Language.PASHTO || currentLang === Language.PERSIAN;
  const t = UI_LABELS[currentLang];

  const documents = [
    { title: isRTL ? 'د شاګردانو لارښود ۲۰۲۴' : 'Student Handbook 2024', lang: 'English/Pashto', size: '2.4MB', chunks: 142 },
    { title: isRTL ? 'د فیسونو تګلاره' : 'Fee Policy Guidelines', lang: 'Persian', size: '1.1MB', chunks: 56 },
  ];

  return (
    <div className={`p-6 md:p-8 flex flex-col h-full bg-slate-50 space-y-8 overflow-y-auto custom-scrollbar ${isRTL ? 'text-right' : 'text-left'}`}>
      <div className={`flex flex-col md:flex-row md:items-center justify-between gap-6 ${isRTL ? 'flex-row-reverse' : ''}`}>
        <div>
          <h1 className="text-2xl font-bold text-slate-800">{t.knowledge}</h1>
          <p className="text-sm text-slate-500">{isRTL ? 'د AI لپاره د معلوماتو تنظیم.' : 'Managing indexed documents for AI.'}</p>
        </div>
        <button className="bg-teal-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-teal-600/20 hover:bg-teal-700 transition-all">
          {t.indexingButton}
        </button>
      </div>

      <div className="relative">
        <Search className={`absolute ${isRTL ? 'right-4' : 'left-4'} top-1/2 -translate-y-1/2 text-slate-400`} size={20} />
        <input 
          type="text" 
          placeholder={t.filterPlaceholder} 
          className={`w-full ${isRTL ? 'pr-12 pl-4 text-right' : 'pl-12 pr-4'} py-4 bg-white border border-slate-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-teal-500 outline-none`}
        />
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
        {documents.map((doc, i) => (
          <div key={i} className="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:border-teal-500 hover:shadow-md transition-all flex flex-col">
            <div className={`flex justify-between items-start mb-6 ${isRTL ? 'flex-row-reverse' : ''}`}>
              <div className="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                <BookOpen size={24} />
              </div>
            </div>
            <h3 className="font-bold text-slate-800 mb-2">{doc.title}</h3>
            <div className="space-y-2 mt-auto text-[10px] font-bold text-slate-400 uppercase tracking-widest">
              <div className={`flex justify-between ${isRTL ? 'flex-row-reverse' : ''}`}>
                <span>{isRTL ? 'ژبه' : 'Language'}</span>
                <span className="text-slate-600">{doc.lang}</span>
              </div>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default KnowledgeBase;
