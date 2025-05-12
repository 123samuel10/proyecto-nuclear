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
            Schema::create('seguimientos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('seguido_id')->constrained('users')->onDelete('cascade');
        $table->timestamps();

        $table->unique(['usuario_id', 'seguido_id']); // evita seguir dos veces
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
              Schema::dropIfExists('seguimientos');
    }
};
