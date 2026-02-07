<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'employee_no',
        'first_name',
        'last_name',
        'dob',
        'gender',
        'phone',
        'hire_date',
        'specialization',
        'address',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
        'hire_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_teacher', 'teacher_id', 'class_id')->withTimestamps();
    }
}
