<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
   protected $fillable = ['nombre'];

    public function publicaciones()
    {
        return $this->belongsToMany(Publicacion::class, 'publicacion_etiqueta');
    }
}
