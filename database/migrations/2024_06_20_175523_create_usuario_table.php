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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('usuario');
            $table->string('password');
            $table->string('acronimo');
            $table->bigInteger('id_departamento');
            $table->string('permisos');
            $table->string('token');
            $table->foreign('id_departamento')->references('id')->on('departamento');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
