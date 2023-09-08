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
        Schema::create('excusas', function (Blueprint $table) {
            $table->id();
            $table->integer('aprendiz_id');
            $table->foreign('aprendiz_id')->references('code')->on('users');
            $table->integer('instructor_id');
            $table->foreign('instructor_id')->references('code')->on('users');
            $table->dateTime('date');
            $table->string('motivo');
            $table->enum('estado', ['Aprobado', 'Rechazado', 'Pendiente'])->default('pendiente');
            $table->string('file_path'); // Campo para guardar la ruta del archivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excusas');
    }
};
