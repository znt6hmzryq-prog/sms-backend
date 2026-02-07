
export enum Language {
  ENGLISH = 'en',
  PASHTO = 'ps',
  PERSIAN = 'fa'
}

export interface Student {
  id: string;
  name: string;
  className: string;
  fatherName: string;
  feesPaid: number;
  feesTotal: number;
  attendanceRate: number;
}

export interface AttendanceRecord {
  studentId: string;
  date: string;
  status: 'Present' | 'Absent' | 'Late';
  reason?: string;
}

export interface PipelineStep {
  id: string;
  name: string;
  status: 'idle' | 'processing' | 'completed' | 'error';
  details?: string;
  timestamp?: number;
}

export interface ChatMessage {
  id: string;
  role: 'user' | 'ai';
  type: 'text' | 'audio';
  content: string;
  timestamp: number;
  pipeline?: PipelineStep[];
}

export const UI_LABELS: Record<Language, any> = {
  [Language.ENGLISH]: {
    appTitle: 'AI-SOS',
    schoolOS: 'School OS',
    dashboard: 'Dashboard',
    whatsapp: 'WhatsApp Interface',
    voice: 'Voice Assistant',
    fees: 'Fee Ledger',
    sync: 'Offline Queue',
    knowledge: 'Knowledge Base',
    database: 'School DB',
    blueprint: 'AI Blueprint',
    sovereignty: 'Data Sovereignty Ready',
    native: 'Persian/Pashto Native',
    online: 'Online',
    typeMessage: 'Type in Pashto, Persian, or English...',
    pipelineTitle: 'AI Event Pipeline',
    overview: 'School Overview',
    subtitle: 'Real-time performance metrics.',
    totalStudents: 'Total Students',
    attendanceRate: 'Attendance Rate',
    feeCollection: 'Fee Collection',
    avgPerformance: 'Avg Performance',
    recentActions: 'Recent AI Actions',
    totalOutstanding: 'Total Outstanding',
    filterPlaceholder: 'Search...',
    syncButton: 'Force Burst Sync',
    indexingButton: 'Upload & Index'
  },
  [Language.PASHTO]: {
    appTitle: 'AI-SOS',
    schoolOS: 'ښوونځي سیسټم',
    dashboard: 'ډشبورډ',
    whatsapp: 'واټساپ انټرفیس',
    voice: 'غږیز مرستیال',
    fees: 'د فیس لیجر',
    sync: 'آفلاین قطار',
    knowledge: 'پوهنغونډ',
    database: 'ډیټابیس',
    blueprint: 'AI نقشه',
    sovereignty: 'د معلوماتو خونديتوب',
    native: 'پښتو/فارسي ملاتړ',
    online: 'آنلاین',
    typeMessage: 'پښتو، فارسي یا انګلیسي کې ولیکئ...',
    pipelineTitle: 'د AI سیسټم بهیر',
    overview: 'د ښوونځي لنډیز',
    subtitle: 'د کارکردګۍ راپور په ژوندۍ بڼه.',
    totalStudents: 'ټول شاګردان',
    attendanceRate: 'د حاضري کچه',
    feeCollection: 'د فیسونو ټولول',
    avgPerformance: 'منځنۍ پایله',
    recentActions: 'وروستي AI عملیات',
    totalOutstanding: 'ټول پاتې پور',
    filterPlaceholder: 'لټون...',
    syncButton: 'آفلاین همغږه کول',
    indexingButton: 'نوی سند پورته کړئ'
  },
  [Language.PERSIAN]: {
    appTitle: 'AI-SOS',
    schoolOS: 'سیستم مدرسه',
    dashboard: 'داشبورد',
    whatsapp: 'رابط واتس‌اپ',
    voice: 'دستیار صوتی',
    fees: 'دفتر شهریه',
    sync: 'صف آفلاین',
    knowledge: 'پایگاه دانش',
    database: 'پایگاه داده',
    blueprint: 'طرح هوشمند',
    sovereignty: 'حاکمیت داده‌ها',
    native: 'پشتیبانی فارسی/پشتو',
    online: 'آنلاین',
    typeMessage: 'به فارسی، پشتو یا انگلیسی بنویسید...',
    pipelineTitle: 'خط لوله رویداد AI',
    overview: 'نمای کلی مدرسه',
    subtitle: 'گزارش عملکرد لحظه‌ای.',
    totalStudents: 'کل دانش‌آموزان',
    attendanceRate: 'نرخ حضور و غیاب',
    feeCollection: 'جمع‌آوری شهریه',
    avgPerformance: 'میانگین عملکرد',
    recentActions: 'عملیات اخیر هوش مصنوعی',
    totalOutstanding: 'کل بدهی معوقه',
    filterPlaceholder: 'جستجو...',
    syncButton: 'همگام‌سازی آفلاین',
    indexingButton: 'بارگذاری سند جدید'
  }
};
