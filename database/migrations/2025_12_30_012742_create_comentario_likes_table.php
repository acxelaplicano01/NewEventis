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
        Schema::create('comentario_likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comentario_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('comentario_id')->references('id')->on('comentarios')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['comentario_id', 'user_id']); // Un usuario solo puede dar like una vez por comentario
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentario_likes');
    }
};
