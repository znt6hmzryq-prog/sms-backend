<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('model_has_permissions', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained('permissions')->onDelete('cascade');
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');
            $table->primary(['permission_id', 'model_id', 'model_type'], 'model_has_permissions_permission_model_type_primary');
        });
    }

    public function down()
    {
        Schema::dropIfExists('model_has_permissions');
    }
};
