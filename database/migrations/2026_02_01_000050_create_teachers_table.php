<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('employee_no')->unique();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->date('hire_date')->nullable();
            $table->string('specialization')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teachers');
    }
};
