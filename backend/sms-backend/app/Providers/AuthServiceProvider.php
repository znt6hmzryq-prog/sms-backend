<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Student;
use App\Policies\StudentPolicy;
use App\Models\Teacher;
use App\Policies\TeacherPolicy;
use App\Models\Subject;
use App\Policies\SubjectPolicy;
use App\Models\Attendance;
use App\Policies\AttendancePolicy;
use App\Models\Exam;
use App\Policies\ExamPolicy;
use App\Models\Grade;
use App\Policies\GradePolicy;
use App\Models\Message;
use App\Policies\MessagePolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Student::class => StudentPolicy::class,
        Teacher::class => TeacherPolicy::class,
        Subject::class => SubjectPolicy::class,
        Attendance::class => AttendancePolicy::class,
        Exam::class => ExamPolicy::class,
        Grade::class => GradePolicy::class,
        Message::class => MessagePolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}
