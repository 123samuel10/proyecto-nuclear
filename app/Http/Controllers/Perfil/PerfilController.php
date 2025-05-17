<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    // Muestra el formulario de edición de perfil
    public function editar()
    {
        $user = Auth::user();

        return view('perfil.editar', compact('user'));
    }

    // Actualiza los datos del perfil
    public function actualizar(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Validación
        $request->validate([
            'name' => 'required|string|max:255',
            'descripcion_academica' => 'nullable|string',
            'intereses' => 'nullable|string',
            'foto_perfil' => 'nullable|image|max:2048', // Máx 2MB
        ]);

        // Actualizar los datos del perfil
        $user->name = $request->name;
        $user->descripcion_academica = $request->descripcion_academica;
        $user->intereses = $request->intereses;

        if ($request->hasFile('foto_perfil')) {
            $foto = $request->file('foto_perfil');
            $nombreFoto = time().'_'.$foto->getClientOriginalName();
            $foto->storeAs('public/fotos_perfil', $nombreFoto);
            $user->foto_perfil = 'fotos_perfil/'.$nombreFoto;
        }

        $user->save();

        return redirect()->route('perfil.editar')->with('success', 'Perfil actualizado correctamente.');
    }

    public function mostrar($id)
    {
        $user = User::withCount(['seguidores', 'seguidos'])->findOrFail($id);
        $misPublicaciones = $user->publicaciones;

        return view('perfil.mostrar', compact('user', 'misPublicaciones'));
    }
}
