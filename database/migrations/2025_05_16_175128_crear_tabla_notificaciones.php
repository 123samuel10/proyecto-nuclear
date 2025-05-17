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
            $table->unsignedBigInteger('usuario_id'); // Usuario que recibe la notificación
            $table->unsignedBigInteger('publicacion_id'); // <-- importante
            $table->string('tipo'); // Tipo de notificación, ej: 'like', 'comentario'
            $table->text('mensaje'); // Texto o descripción de la notificación
            $table->boolean('leida')->default(false); // Estado de lectura
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('publicacion_id')->references('id')->on('publicaciones')->onDelete('cascade'); // <-- clave foránea bien formada
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
