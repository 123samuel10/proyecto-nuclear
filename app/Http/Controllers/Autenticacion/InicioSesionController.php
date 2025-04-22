<?php

namespace App\Http\Controllers\Autenticacion;

// Importa la clase base Controller de Laravel, que permite crear controladores.
use App\Http\Controllers\Controller;

// Importa la clase Request de Laravel, que se usa para manejar las solicitudes HTTP.
use Illuminate\Http\Request;

// Importa la fachada Auth, que permite trabajar con la autenticación de usuarios.
use Illuminate\Support\Facades\Auth;

class InicioSesionController extends Controller
{
    // Método que muestra el formulario de inicio de sesión.
    public function mostrarFormularioInicioSesion()
    {
        // Retorna la vista 'autenticacion.inicio_sesion', que es el formulario donde el usuario ingresará sus credenciales.
        return view('autenticacion.inicio_sesion');
    }

    // Método que maneja el proceso de inicio de sesión.
    public function iniciarSesion(Request $request)
    {
        // Se validan los datos del formulario de inicio de sesión.
        // 'email' debe ser un correo electrónico válido.
        // 'contraseña' debe tener al menos 6 caracteres.
        $request->validate([
            'email' => 'required|email',       // La validación asegura que el campo 'email' sea obligatorio y un correo válido.
            'contraseña' => 'required|min:6',  // La validación asegura que 'contraseña' sea obligatoria y tenga al menos 6 caracteres.
        ]);

        // Intenta iniciar sesión utilizando las credenciales proporcionadas.
        // Si las credenciales son correctas, se realiza el login automáticamente.
        if (Auth::attempt(['email' => $request->email, 'password' => $request->contraseña])) {
            // Si las credenciales son correctas, redirige al usuario a la página 'bienvenida'.
            return redirect()->route('bienvenida');
        }

        // Si las credenciales son incorrectas, redirige al formulario con un mensaje de error.
        // 'back()' devuelve al usuario a la página anterior (el formulario de inicio de sesión) con los errores de validación.
        return back()->withErrors(['email' => 'Las credenciales son incorrectas']);
    }
}
