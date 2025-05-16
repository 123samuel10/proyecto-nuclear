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
    Schema::create('notificacions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id'); // el usuario que recibe la notificación
    $table->unsignedBigInteger('publicacion_id'); // la publicación que generó la notificación
    $table->string('tipo'); // por ahora: 'like'
    $table->boolean('leida')->default(false); // si ya fue vista
    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('publicacion_id')->references('id')->on('publicaciones')->onDelete('cascade'); // 👈 aquí estaba el problema
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicaciones');

    }
};
