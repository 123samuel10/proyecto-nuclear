<?php

// app/Http/Controllers/Autenticacion/BienvenidaController.php

// Define el espacio de nombres (namespace) para este controlador
// Esto es para organizar el código y evitar conflictos con otros controladores.
namespace App\Http\Controllers\Autenticacion;


use App\Http\Controllers\Controller;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// Definición de la clase BienvenidaController que extiende de la clase base Controller
class BienvenidaController extends Controller
{

    public function index()
    {
        // Trae todas las publicaciones, ordenadas de más reciente a más antigua
        $publicaciones = Publicacion::latest()->get();
        return view('bienvenida', compact('publicaciones'));
    }

    public function verPerfil()
    {
        $user = Auth::user();
        // Trae solo las publicaciones del usuario autenticado
        $misPublicaciones = Publicacion::where('user_id', $user->id)->latest()->get();
        return view('perfil', compact('user', 'misPublicaciones'));
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    //esta se usa para actualizar el perfil
    public function actualizarPerfil(Request $request)
{
/** @var \App\Models\User $user */
     $user = Auth::user();


    $request->validate([
        'name' => 'required|string|max:255',
        'descripcion_academica' => 'nullable|string',
        'intereses' => 'nullable|string',
        'foto_perfil' => 'nullable|image|max:2048', // Máx 2MB
    ]);

    $user->name = $request->name;
    $user->descripcion_academica = $request->descripcion_academica;
    $user->intereses = $request->intereses;

    if ($request->hasFile('foto_perfil')) {
        $foto = $request->file('foto_perfil');
        $nombreFoto = time() . '_' . $foto->getClientOriginalName();
        $foto->storeAs('public/fotos_perfil', $nombreFoto);
        $user->foto_perfil = 'fotos_perfil/' . $nombreFoto;
    }

    $user->save();

    return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
}


}
