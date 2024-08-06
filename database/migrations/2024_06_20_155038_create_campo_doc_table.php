<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campo_doc', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('alineacion');
            $table->text('text');
            $table->foreignId('id_fuente')->constrained('fuente');
            $table->integer('size');
            $table->boolean('isBold');
            $table->boolean('isUnderline');
            $table->boolean('nombreVisible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campo_doc');
    }
};
