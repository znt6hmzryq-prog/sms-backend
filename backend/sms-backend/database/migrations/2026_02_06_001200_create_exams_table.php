<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date')->nullable();
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->foreignId('subject_id')->nullable()->constrained('subjects')->onDelete('set null');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->integer('total_marks')->default(100);
            $table->text('instructions')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exams');
    }
};
