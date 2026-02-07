<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('name');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->enum('shift', ['morning', 'afternoon', 'evening'])->default('morning');
            $table->integer('capacity')->default(0);
            $table->json('schedule')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sections');
    }
};
