<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('class_teacher', function (Blueprint $table) {
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
            $table->primary(['class_id', 'teacher_id']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('class_teacher');
    }
};
