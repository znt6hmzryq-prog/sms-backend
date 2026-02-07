
import React from 'react';
import { User, Search, Filter, Download, Plus } from 'lucide-react';
import { Student } from '../types';

const DatabaseManager: React.FC = () => {
  const students: Student[] = [
    { id: 'ST-001', name: 'Ahmed Khan', className: 'Grade 4-A', fatherName: 'Mohammad Khan', feesPaid: 12000, feesTotal: 15000, attendanceRate: 92 },
    { id: 'ST-002', name: 'Sara Jan', className: 'Grade 4-A', fatherName: 'Ahmad Jan', feesPaid: 15000, feesTotal: 15000, attendanceRate: 98 },
    { id: 'ST-003', name: 'Mustafa Omar', className: 'Grade 4-A', fatherName: 'Omar Zai', feesPaid: 8000, feesTotal: 15000, attendanceRate: 85 },
    { id: 'ST-004', name: 'Maryam Gohar', className: 'Grade 4-A', fatherName: 'Gohar Shah', feesPaid: 15000, feesTotal: 15000, attendanceRate: 95 },
  ];

  return (
    <div className="p-6 h-full flex flex-col bg-slate-50">
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
          <h1 className="text-2xl font-bold text-slate-800">School Directory</h1>
          <p className="text-sm text-slate-500">Managing students, staff, and fiscal data.</p>
        </div>
        <div className="flex gap-2">
          <button className="flex items-center gap-2 bg-white px-4 py-2 border border-slate-200 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">
            <Download size={16} /> Export CSV
          </button>
          <button className="flex items-center gap-2 bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-teal-700 transition-colors shadow-sm">
            <Plus size={16} /> Add Student
          </button>
        </div>
      </div>

      <div className="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex-1 flex flex-col">
        <div className="p-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
          <div className="flex items-center gap-4 flex-1">
            <div className="relative flex-1 max-w-md">
              <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" size={18} />
              <input 
                type="text" 
                placeholder="Search students, fathers name, or ID..." 
                className="w-full pl-10 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-teal-500 outline-none transition-all"
              />
            </div>
            <button className="p-2 border border-slate-200 rounded-lg hover:bg-slate-50">
              <Filter size={18} className="text-slate-600" />
            </button>
          </div>
          <span className="text-xs font-medium text-slate-500">Showing {students.length} Students</span>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="bg-slate-50/80">
                <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Student</th>
                <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ID</th>
                <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Class</th>
                <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Fees Status</th>
                <th className="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Attendance</th>
                <th className="px-6 py-4"></th>
              </tr>
            </thead>
            <tbody className="divide-y divide-slate-100">
              {students.map((student) => (
                <tr key={student.id} className="hover:bg-slate-50 transition-colors">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-full bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                        {student.name.charAt(0)}
                      </div>
                      <div>
                        <p className="font-semibold text-slate-800">{student.name}</p>
                        <p className="text-xs text-slate-500">S/O {student.fatherName}</p>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4 font-mono text-xs text-slate-600">{student.id}</td>
                  <td className="px-6 py-4 text-sm text-slate-700">{student.className}</td>
                  <td className="px-6 py-4">
                    <div className="flex flex-col gap-1 w-32">
                      <div className="flex justify-between text-[10px] font-bold">
                        <span className={student.feesPaid === student.feesTotal ? 'text-green-600' : 'text-orange-600'}>
                          {student.feesPaid} / {student.feesTotal}
                        </span>
                        <span className="text-slate-400">{Math.round((student.feesPaid/student.feesTotal)*100)}%</span>
                      </div>
                      <div className="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div 
                          className={`h-full rounded-full ${student.feesPaid === student.feesTotal ? 'bg-green-500' : 'bg-orange-500'}`} 
                          style={{ width: `${(student.feesPaid/student.feesTotal)*100}%` }}
                        />
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4 text-sm font-medium">
                    <span className={`px-2 py-1 rounded-full text-xs ${student.attendanceRate > 90 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'}`}>
                      {student.attendanceRate}%
                    </span>
                  </td>
                  <td className="px-6 py-4 text-right">
                    <button className="text-teal-600 hover:text-teal-800 text-sm font-semibold">View Record</button>
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

export default DatabaseManager;
