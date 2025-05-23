<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Etiqueta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    // Muestra el formulario de edición de perfil
public function editar()
{
    $user = Auth::user();
    $etiquetas = Etiqueta::all(); // Recupera todas las etiquetas

    return view('perfil.editar', compact('user', 'etiquetas'));
}

public function actualizar(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'descripcion_academica' => 'nullable|string',
        'intereses' => 'nullable|array',
        'foto_perfil' => 'nullable|image|max:2048',
    ]);

    $user->name = $request->name;
    $user->descripcion_academica = $request->descripcion_academica;
    $user->intereses = $request->intereses ? implode(',', $request->intereses) : null;

    /** @var \Illuminate\Filesystem\Filesystem $fileHelper */
    $fileHelper = app('files');

    if ($request->hasFile('foto_perfil')) {
        if ($user->foto_perfil && $fileHelper->exists(public_path('storage/' . $user->foto_perfil))) {
            $fileHelper->delete(public_path('storage/' . $user->foto_perfil));
        }

        $foto = $request->file('foto_perfil');
        $nombreFoto = time() . '_' . $foto->getClientOriginalName();
        $foto->move(public_path('storage/fotos_perfil'), $nombreFoto);

        $user->foto_perfil = 'fotos_perfil/' . $nombreFoto;
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
