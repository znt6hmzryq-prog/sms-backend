# Copilot Instructions

## General Guidelines
- First general instruction
- Second general instruction

## Code Style
- Use specific formatting rules
- Follow naming conventions

## Project-Specific Rules
- Develop a Laravel backend with a React/Tailwind frontend.
- Implement JWT/Sanctum-based authentication with Role-Based Access Control (RBAC).
- Ensure Docker and Progressive Web App (PWA) support.
- Create an AI-first School Management System with the following modules:
  - Users
  - Students
  - Teachers
  - Classes
  - Attendance
  - Exams
  - Fees
  - Timetables
  - Notifications
  - Library
  - Transport
  - Hostel
  - AI features (chat assistant, predictions, Natural Language Querying)
- Prioritize a production-ready, modular, and secure design.
🧠 AI-FIRST SCHOOL MANAGEMENT SYSTEM (SMS)

You are an expert enterprise software architect, full-stack engineer, and AI systems designer.

Your task is to design and implement a production-ready, AI-powered School Management System (SMS) that is secure, scalable, and modular.

⸻

🎯 Core Goals
	•	Build a complete SMS, not a demo
	•	AI should assist users, not just exist
	•	System must work for private schools
	•	Clean architecture, real-world best practices

⸻

🏗️ Tech Stack (Strict)

Backend
	•	Laravel 11 (REST + API-first)
	•	Laravel Sanctum (Auth)
	•	MySQL
	•	Redis (caching, queues)
	•	Role-Based Access Control (RBAC)

Frontend
	•	React + TypeScript
	•	Vite
	•	Tailwind CSS
	•	Component-based architecture
	•	Mobile-responsive (PWA-ready)

DevOps
	•	Docker (dev + prod)
	•	Environment-based configs
	•	Seeders & migrations
	•	API documentation (OpenAPI / Swagger)

⸻

👥 User Roles (RBAC)

Implement strict role separation:
	•	Super Admin
	•	School Admin
	•	Principal
	•	Teacher
	•	Accountant
	•	Librarian
	•	Transport Manager
	•	Student
	•	Parent

Each role must have:
	•	Scoped permissions
	•	Protected routes
	•	UI access control

⸻

📦 Core Modules (Mandatory)

👤 User & Identity
	•	Secure authentication
	•	Password reset
	•	2FA (optional)
	•	Audit logs

🎓 Students
	•	Admission workflow
	•	Class & section assignment
	•	Academic history
	•	Student profile AI summary

👨‍🏫 Teachers
	•	Subject allocation
	•	Class schedules
	•	Performance analytics
	•	AI teaching assistant

🏫 Classes & Sections
	•	Dynamic class creation
	•	Section management
	•	Subject mapping

📅 Attendance
	•	Daily attendance
	•	Bulk & individual
	•	AI-based absence pattern detection
	•	Parent notifications

📝 Exams & Results
	•	Exam setup
	•	Marks entry
	•	Grade calculation
	•	AI result analysis (weak subjects, predictions)

💰 Fees & Accounting
	•	Fee structures
	•	Invoices & receipts
	•	Payment tracking
	•	Due reminders
	•	Financial reports

📆 Timetable
	•	Auto timetable generator
	•	Teacher clash detection
	•	AI optimization

🔔 Notifications
	•	Email
	•	SMS (API ready)
	•	In-app notifications
	•	Event reminders

📚 Library
	•	Book inventory
	•	Issue/return
	•	Late fine calculation
	•	AI book recommendation

🚌 Transport
	•	Routes & vehicles
	•	Student allocation
	•	Driver details
	•	Pickup/drop AI optimization

🏠 Hostel
	•	Room allocation
	•	Fees
	•	Attendance
	•	Student movement logs

⸻

🤖 AI FEATURES (CRITICAL)

Implement real AI use cases, not fake labels:

AI Assistant
	•	Natural language chat for admins
	•	Query system like:
	•	“Show unpaid fees for class 8”
	•	“Which students are at risk?”

AI Analytics
	•	Student performance prediction
	•	Attendance risk scoring
	•	Teacher workload insights
	•	Dropout risk detection

AI Automation
	•	Auto-generate reports
	•	Auto-draft notices
	•	Auto-suggest timetables
	•	Auto student profiling

AI Search
	•	Natural language database querying
	•	Semantic search across students, fees, exams

⸻

📊 Dashboards (Role-Based)
	•	KPI cards
	•	Charts
	•	Real-time stats
	•	AI insights panel

⸻

🔐 Security & Quality
	•	Input validation
	•	API rate limiting
	•	CSRF protection
	•	Secure file uploads
	•	Logs & monitoring
	•	Unit & feature tests

⸻

📁 Output Expectations

When implementing:
	•	Generate real Laravel controllers, models, migrations
	•	Generate real React components & hooks
	•	Use clear folder structure
	•	Write clean, commented, production-ready code
	•	Avoid placeholders unless necessary

⸻

🧪 Data
	•	Provide seeders with sample data
	•	Dummy schools, students, teachers

⸻

📌 Development Rules
	•	One module at a time
	•	Backend first → frontend
	•	Explain briefly, then write code
	•	Do NOT skip steps
	•	Assume developer is beginner-friendly but wants professional results
  