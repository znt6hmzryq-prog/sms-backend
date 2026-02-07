<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'enrollment_no',
        'first_name',
        'last_name',
        'dob',
        'gender',
        'guardian_name',
        'guardian_contact',
        'address',
        'class_id',
        'section_id',
        'admission_date',
        'status',
        'photo',
    ];

    protected $casts = [
        'dob' => 'date',
        'admission_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
