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
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto_perfil')->nullable()->after('email');
            $table->text('descripcion_academica')->nullable()->after('foto_perfil');
            $table->text('intereses')->nullable()->after('descripcion_academica');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['foto_perfil', 'descripcion_academica', 'intereses']);
        });
    }
};
