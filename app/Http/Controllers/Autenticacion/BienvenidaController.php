<?php

// app/Http/Controllers/Autenticacion/BienvenidaController.php

// Define el espacio de nombres (namespace) para este controlador
// Esto es para organizar el código y evitar conflictos con otros controladores.
namespace App\Http\Controllers\Autenticacion;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// Definición de la clase BienvenidaController que extiende de la clase base Controller
class BienvenidaController extends Controller
{
    public function index()
    {
        return view('bienvenida');
    }

    public function verPerfil()
    {
        // Asegúrate de que el usuario esté autenticado
        $user = Auth::user(); // Obtén el usuario autenticado
        return view('perfil', compact('user')); // Pasa el usuario a la vista
    }

    public function cambiarContraseña(Request $request)
    {
        // Asegúrate de que el usuario esté autenticado
        $user = Auth::user(); // Esto debería ser una instancia de User

        // Validar la nueva contraseña
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed', // 'password_confirmation' debe estar en el formulario
        ]);

        if ($validator->fails()) {
            return redirect()->route('perfil')
                ->withErrors($validator)
                ->withInput();
        }

        // Asegúrate de que $user es una instancia de User
        if ($user instanceof \App\Models\User) {
            // Encriptar y guardar la contraseña
            $user->password = Hash::make($request->password); // Encriptar la contraseña
            $user->save(); // Guardar el cambio en la base de datos
        } else {
            // Si $user no es una instancia de User, manejar el error
            return redirect()->route('perfil')->with('error', 'No se pudo actualizar la contraseña');
        }

        // Cambiar esta línea en el método cambiarContraseña
        return redirect()->route('ver-perfil')->with('success', 'Contraseña cambiada exitosamente');

    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
