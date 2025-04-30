<?php

namespace App\Http\Controllers\Autenticacion;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RestablecerContrasenaController extends Controller
{
    public function mostrarFormulario()
    {
        return view('autenticacion.recuperar_contraseña');
    }

    public function restablecer(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $usuario = User::where('email', $request->email)->first();

        $usuario->password = Hash::make($request->password);
        $usuario->save();
        // la contraseña en la base de datos sí se actualiza,
        // y además se guarda de forma segura porque está encriptada con bcrypt
        //(gracias a Hash::make()), así que todo bien por ese lado.

        return redirect()->route('login.formulario')->with('success', 'Contraseña actualizada correctamente. Ahora puedes iniciar sesión.');
    }
}
