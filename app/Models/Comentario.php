<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
 use HasFactory;

    protected $fillable = ['user_id', 'publicacion_id', 'contenido']; // Asegúrate de que estos campos puedan ser rellenados

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class); // Un comentario pertenece a un usuario
    }




    // Relación con el modelo Publicacion
    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class); // Un comentario pertenece a una publicación
    }

    public function likes()
{
    return $this->belongsToMany(User::class, 'comentario_likes');
}


}
