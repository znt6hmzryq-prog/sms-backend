
import React from 'react';
import { CreditCard, DollarSign, ArrowUpRight, Search, FileText, Filter } from 'lucide-react';
import { Student, Language, UI_LABELS } from '../types';

interface Props {
  currentLang: Language;
}

const FinancialLedger: React.FC<Props> = ({ currentLang }) => {
  const isRTL = currentLang === Language.PASHTO || currentLang === Language.PERSIAN;
  const t = UI_LABELS[currentLang];
  
  const students: Student[] = [
    { id: 'ST-001', name: 'Ahmed Khan', className: 'Grade 4-A', fatherName: 'Mohammad Khan', feesPaid: 12000, feesTotal: 15000, attendanceRate: 92 },
    { id: 'ST-002', name: 'Sara Jan', className: 'Grade 4-A', fatherName: 'Ahmad Jan', feesPaid: 15000, feesTotal: 15000, attendanceRate: 98 },
    { id: 'ST-003', name: 'Mustafa Omar', className: 'Grade 4-A', fatherName: 'Omar Zai', feesPaid: 8000, feesTotal: 15000, attendanceRate: 85 },
    { id: 'ST-004', name: 'Maryam Gohar', className: 'Grade 4-A', fatherName: 'Gohar Shah', feesPaid: 15000, feesTotal: 15000, attendanceRate: 95 },
  ];

  return (
    <div className={`p-6 md:p-8 flex flex-col h-full bg-slate-50 overflow-hidden ${isRTL ? 'text-right' : 'text-left'}`}>
      <div className={`flex justify-between items-start mb-8 ${isRTL ? 'flex-row-reverse' : ''}`}>
        <div>
          <h1 className="text-2xl font-bold text-slate-800">{t.fees}</h1>
          <p className="text-sm text-slate-500">{isRTL ? 'د شاګردانو د حسابونو مدیریت.' : 'Managing student accounts.'}</p>
        </div>
        <div className="bg-teal-600 text-white p-6 rounded-2xl shadow-lg shadow-teal-600/20 flex flex-col gap-1 min-w-[240px]">
          <span className="text-xs font-bold uppercase tracking-widest text-teal-100">{t.totalOutstanding}</span>
          <span className="text-3xl font-bold">128,450 AFN</span>
        </div>
      </div>

      <div className="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden flex flex-col flex-1">
        <div className={`p-4 border-b border-slate-100 flex gap-4 bg-slate-50/50 ${isRTL ? 'flex-row-reverse' : ''}`}>
          <div className="relative flex-1">
            <Search className={`absolute ${isRTL ? 'right-3' : 'left-3'} top-1/2 -translate-y-1/2 text-slate-400`} size={18} />
            <input 
              type="text" 
              placeholder={t.filterPlaceholder} 
              className={`w-full ${isRTL ? 'pr-10 pl-4 text-right' : 'pl-10 pr-4'} py-2 border border-slate-200 rounded-lg text-sm bg-white outline-none focus:ring-2 focus:ring-teal-500`}
            />
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left" dir={isRTL ? 'rtl' : 'ltr'}>
            <thead>
              <tr className="bg-slate-50">
                <th className={`px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest ${isRTL ? 'text-right' : 'text-left'}`}>{isRTL ? 'شاګرد / آیډي' : 'Student / ID'}</th>
                <th className={`px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest ${isRTL ? 'text-right' : 'text-left'}`}>{isRTL ? 'تادیه شوې' : 'Paid (AFN)'}</th>
                <th className={`px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest ${isRTL ? 'text-right' : 'text-left'}`}>{isRTL ? 'باقي' : 'Balance'}</th>
                <th className="px-6 py-4"></th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100">
              {students.map((student) => (
                <tr key={student.id} className="hover:bg-slate-50 group">
                  <td className="px-6 py-4">
                    <div className="flex flex-col">
                      <span className="font-bold text-slate-800">{student.name}</span>
                      <span className="text-xs text-slate-500 font-mono uppercase">{student.id}</span>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <span className="text-sm font-bold text-slate-900">{student.feesPaid.toLocaleString()}</span>
                  </td>
                  <td className="px-6 py-4">
                    <span className={`text-sm font-bold ${student.feesPaid === student.feesTotal ? 'text-green-600' : 'text-orange-600'}`}>
                      {(student.feesTotal - student.feesPaid).toLocaleString()}
                    </span>
                  </td>
                  <td className="px-6 py-4 text-right">
                    <button className="p-2 hover:bg-slate-100 rounded-lg text-teal-600 transition-colors">
                      <FileText size={18} />
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
};

export default FinancialLedger;
