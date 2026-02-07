<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'class_id')) {
                $table->foreignId('class_id')->nullable()->constrained('classes')->nullOnDelete();
            }

            if (! Schema::hasColumn('students', 'section_id')) {
                $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'section_id')) {
                $table->dropConstrainedForeignId('section_id');
            }
            if (Schema::hasColumn('students', 'class_id')) {
                $table->dropConstrainedForeignId('class_id');
            }
        });
    }
};
