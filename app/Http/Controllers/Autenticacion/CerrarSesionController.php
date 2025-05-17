<?php

namespace App\Http\Controllers\Autenticacion;

// Importa la clase base Controller de Laravel, que permite definir controladores de manera sencilla.
use App\Http\Controllers\Controller;
// Importa la fachada Auth de Laravel, que proporciona acceso a la autenticación de usuarios.
use Illuminate\Support\Facades\Auth;

class CerrarSesionController extends Controller
{
    // Definición del método cerrarSesion, que se encarga de cerrar la sesión del usuario.
    public function cerrarSesion()
    {
        // Llama al método logout de la fachada Auth, que termina la sesión del usuario.
        Auth::logout();

        // Redirige al usuario a la ruta llamada 'inicio', que generalmente sería la página de inicio o login.
        return redirect()->route('inicio');
    }
}
