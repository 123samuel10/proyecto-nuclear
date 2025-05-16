<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{

 protected $table = 'notificaciones'; // o el nombre que uses en la BD

    protected $fillable = [
        'usuario_id',
        'mensaje',
        'leida',
        // otros campos...
    ];


    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
