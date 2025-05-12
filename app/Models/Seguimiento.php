<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
use HasFactory;

    // Definir los campos que son asignables en masa
    protected $fillable = [
        'usuario_id',
        'seguido_id'
    ];

    /**
     * Relación con el modelo User (el que sigue).
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación con el modelo User (el seguido).
     */
    public function seguido()
    {
        return $this->belongsTo(User::class, 'seguido_id');
    }
}
