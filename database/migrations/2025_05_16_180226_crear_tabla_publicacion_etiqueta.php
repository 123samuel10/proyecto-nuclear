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
      Schema::create('publicacion_etiqueta', function (Blueprint $table) {
        $table->unsignedBigInteger('publicacion_id');
        $table->unsignedBigInteger('etiqueta_id');

        $table->foreign('publicacion_id')->references('id')->on('publicaciones')->onDelete('cascade');
        $table->foreign('etiqueta_id')->references('id')->on('etiquetas')->onDelete('cascade');

        $table->primary(['publicacion_id', 'etiqueta_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicacion_etiqueta');
    }
};
