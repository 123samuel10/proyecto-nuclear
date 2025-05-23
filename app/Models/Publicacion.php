<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicaciones';

    protected $fillable = [
        'user_id',
        'titulo',
        'descripcion',
        'tipo',
        'archivo',
    ];

    // AGREGA ESTA FUNCIÓN:
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'publicacion_etiqueta');
    }

    public function megustas()
    {
        return $this->hasMany(MeGusta::class, 'publicacion_id');
    }

    public function leDioMeGusta($usuarioId)
    {
        return $this->megustas()->where('usuario_id', $usuarioId)->exists();
    }


}
