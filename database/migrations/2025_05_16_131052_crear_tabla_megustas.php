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
        Schema::create('megustas', function (Blueprint $table) {
    $table->id();
    $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('publicacion_id')->constrained('publicaciones')->onDelete('cascade');
    $table->timestamps();

    $table->unique(['usuario_id', 'publicacion_id']); // Para evitar duplicados
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('megustas');
    }
};
