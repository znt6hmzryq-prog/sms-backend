<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('enrollment_no')->unique();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_contact')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('set null');
            $table->date('admission_date')->nullable();
            $table->string('status')->default('active');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
