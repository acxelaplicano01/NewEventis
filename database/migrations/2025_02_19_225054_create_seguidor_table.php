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
        Schema::create('seguidor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Usuario que está siguiendo
            $table->unsignedBigInteger('seguido_id'); // Usuario que está siendo seguido
            $table->timestamps();

            // Claves foráneas con eliminación en cascada
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seguido_id')->references('id')->on('users')->onDelete('cascade');

            // Evitar duplicados
            $table->unique(['user_id', 'seguido_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguidor');
    }
};
