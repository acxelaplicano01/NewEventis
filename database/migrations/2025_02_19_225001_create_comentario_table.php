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
        Schema::dropIfExists('comentarios'); // Eliminar la tabla si ya existe
        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->text('contenido');
            $table->string('foto')->nullable();
            $table->unsignedBigInteger('idPublicacion'); // Agregar la columna idPublicacion
            $table->unsignedBigInteger('IdUsuario');
            $table->timestamps();

            $table->foreign('idPublicacion')->references('id')->on('publicaciones')->onDelete('cascade'); // Definir la relación con publicaciones
            $table->foreign('IdUsuario')->references('id')->on('users')->onDelete('cascade'); // Definir la relación con users
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios');
    }
};
