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
Schema::create('notificaciones', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('usuario_id');
    $table->unsignedBigInteger('publicacion_id')->nullable();
    $table->string('tipo');
    $table->boolean('leida')->default(false);
    $table->timestamps();

    $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('publicacion_id')->references('id')->on('publicaciones')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
