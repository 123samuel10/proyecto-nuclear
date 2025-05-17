<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeGusta extends Model
{
    protected $table = 'megustas';

    protected $fillable = [
        'usuario_id',
        'publicacion_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }
}
