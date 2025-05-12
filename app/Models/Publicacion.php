<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
