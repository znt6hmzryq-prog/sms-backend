
import React from 'react';
import { TrendingUp, Users, Wallet, Clock, ArrowUpRight, ArrowDownRight, Activity } from 'lucide-react';
import { Language, UI_LABELS } from '../types';

interface Props {
  currentLang: Language;
}

const AnalyticsDashboard: React.FC<Props> = ({ currentLang }) => {
  const isRTL = currentLang === Language.PASHTO || currentLang === Language.PERSIAN;
  const t = UI_LABELS[currentLang];

  const stats = [
    { label: t.totalStudents, value: '432', change: '+5%', positive: true, icon: Users, color: 'text-blue-600', bg: 'bg-blue-100' },
    { label: t.attendanceRate, value: '94.2%', change: '-0.4%', positive: false, icon: Clock, color: 'text-teal-600', bg: 'bg-teal-100' },
    { label: t.feeCollection, value: '82%', change: '+12%', positive: true, icon: Wallet, color: 'text-orange-600', bg: 'bg-orange-100' },
    { label: t.avgPerformance, value: '78/100', change: '+2.1%', positive: true, icon: TrendingUp, color: 'text-purple-600', bg: 'bg-purple-100' },
  ];

  return (
    <div className={`p-6 md:p-8 overflow-y-auto h-full space-y-8 bg-slate-50 ${isRTL ? 'text-right' : 'text-left'}`}>
      <div className={`flex flex-col md:flex-row md:items-center justify-between gap-4 ${isRTL ? 'flex-row-reverse' : ''}`}>
        <div>
          <h1 className="text-2xl font-bold text-slate-800">{t.overview}</h1>
          <p className="text-sm text-slate-500">{t.subtitle}</p>
        </div>
      </div>

      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {stats.map((stat, i) => (
          <div key={i} className="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div className={`flex justify-between items-start mb-4 ${isRTL ? 'flex-row-reverse' : ''}`}>
              <div className={`${stat.bg} ${stat.color} p-3 rounded-xl`}>
                <stat.icon size={24} />
              </div>
              <div className={`flex items-center gap-1 text-xs font-bold px-2 py-1 rounded-full ${stat.positive ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600'}`}>
                {stat.positive ? <ArrowUpRight size={12} /> : <ArrowDownRight size={12} />}
                {stat.change}
              </div>
            </div>
            <p className="text-sm font-medium text-slate-500 uppercase tracking-wider">{stat.label}</p>
            <p className="text-2xl font-bold text-slate-900 mt-1">{stat.value}</p>
          </div>
        ))}
      </div>

      <div className={`grid grid-cols-1 lg:grid-cols-2 gap-8`}>
        <div className="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
          <h3 className={`font-bold text-slate-800 mb-6 flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
            <Clock className="text-teal-600" size={18} /> {isRTL ? 'د حاضري بهیر' : 'Attendance Trends'}
          </h3>
          <div className={`flex items-end gap-2 h-48 ${isRTL ? 'flex-row-reverse' : ''}`}>
            {[65, 80, 75, 92, 85, 95, 88, 70, 90, 85, 94, 82].map((h, i) => (
              <div key={i} className="flex-1 flex flex-col items-center gap-2 group">
                <div className="w-full bg-slate-100 rounded-t-md relative h-full overflow-hidden">
                  <div 
                    className={`absolute bottom-0 left-0 right-0 rounded-t-md transition-all duration-1000 group-hover:opacity-80
                      ${h > 90 ? 'bg-teal-500' : h > 80 ? 'bg-blue-500' : 'bg-orange-400'}`}
                    style={{ height: `${h}%` }}
                  />
                </div>
                <span className="text-[10px] font-bold text-slate-400 uppercase">W{i+1}</span>
              </div>
            ))}
          </div>
        </div>

        <div className="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
          <h3 className={`font-bold text-slate-800 mb-6 flex items-center gap-2 ${isRTL ? 'flex-row-reverse' : ''}`}>
            <Activity className="text-teal-600" size={18} /> {t.recentActions}
          </h3>
          <div className="space-y-4">
            {[
              { type: 'Attendance', name: 'Ahmed Khan', status: isRTL ? 'غیر حاضر' : 'Marked Absent', time: '12m' },
              { type: 'Fees', name: 'Sara Jan', status: isRTL ? 'تادیه شوه' : 'Payment Verified', time: '45m' },
              { type: 'Sync', name: 'Batch-402', status: isRTL ? 'بشپړ شو' : 'Burst Completed', time: '1h' },
            ].map((op, i) => (
              <div key={i} className={`flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100 ${isRTL ? 'flex-row-reverse' : ''}`}>
                <div className={`flex items-center gap-3 ${isRTL ? 'flex-row-reverse' : ''}`}>
                  <div className={`w-2 h-2 rounded-full ${i === 0 ? 'bg-green-500 animate-pulse' : 'bg-slate-300'}`} />
                  <div className={isRTL ? 'text-right' : ''}>
                    <p className="text-sm font-bold text-slate-800">{op.name}</p>
                    <p className="text-xs text-slate-500">{op.type} • {op.status}</p>
                  </div>
                </div>
                <span className="text-[10px] font-medium text-slate-400">{op.time}</span>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
};

export default AnalyticsDashboard;
