<?php // Indica que el archivo es de PHP

namespace App\Models; // Define el namespace donde se encuentra el modelo User


// use Illuminate\Contracts\Auth\MustVerifyEmail; // (Comentado) Se usaría si quisieras requerir verificación de email

use Illuminate\Database\Eloquent\Factories\HasFactory; // Importa el trait para habilitar el uso de factories en este modelo
use Illuminate\Foundation\Auth\User as Authenticatable; // Importa la clase base para modelos de usuarios autenticados
use Illuminate\Notifications\Notifiable; // Importa el trait para permitir notificaciones en el modelo

class User extends Authenticatable // Define la clase User que hereda de Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */ // Documenta que este modelo usa una factory específica

    use HasFactory, Notifiable; // Usa los traits HasFactory y Notifiable para añadir funcionalidades al modelo

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [ // Define los campos que pueden ser asignados masivamente
        'name', // Nombre del usuario
        'email', // Correo electrónico del usuario
        'password', // Contraseña del usuario
        'foto_perfil', // Foto de perfil del usuario
        'descripcion_academica', // Descripción académica del usuario
        'intereses', // Intereses del usuario
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [ // Define los campos que deben ocultarse cuando el modelo se convierte en JSON
        'password', // Oculta la contraseña
        'remember_token', // Oculta el token de "recordarme" usado en sesiones persistentes
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array // Define cómo deben convertirse automáticamente algunos atributos
    {
        return [
            'email_verified_at' => 'datetime', // Convierte el campo email_verified_at a un objeto tipo fecha y hora
            'password' => 'hashed', // Indica que el password debe ser tratado como un hash
        ];
    }

   /**
     * Usuarios que siguen a este usuario.
     */
    /**
     * Usuarios que siguen a este usuario (relación inversa).
     */
    /**
     * Relación con los seguidores
     */
// Relación con los seguidores
public function seguidores()
{
    return $this->belongsToMany(User::class, 'seguimientos', 'seguido_id', 'usuario_id');
}

// Relación con los seguidos
public function seguidos()
{
    return $this->belongsToMany(User::class, 'seguimientos', 'usuario_id', 'seguido_id');
}

public function estaSiguiendo($usuarioId)
{
    // Corregir la referencia a la columna `id` de la tabla `users` correctamente
    return $this->seguidos()->where('seguimientos.seguido_id', $usuarioId)->exists();
}





  // Relación con las publicaciones
    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class);
    }
public function megustas()
{
    return $this->hasMany(MeGusta::class, 'usuario_id');
}


}
