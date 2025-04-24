<?php
namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    public function mostrarFormularioRegistro()
    {
        return view('autenticacion.registro');
    }

    public function registrar(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'nombre' => 'required|string|max:255',
          'email' => 'required|email|unique:users,email',
          //contraseña en el formulario y la validación porque quieres que todo esté en español y legible para el usuario
            'contraseña' => 'required|confirmed|min:6',
        ]);

        // Crear el usuario
        $usuario = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->contraseña),
        ]);

        // Iniciar sesión automáticament
        Auth::login($usuario);

        // Redirigir a la página principal
        return redirect()->route('bienvenida')->with('status', 'Registro exitoso');
    }
}
