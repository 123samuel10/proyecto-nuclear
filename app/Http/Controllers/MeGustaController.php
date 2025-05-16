<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeGusta;
use App\Models\Publicacion;

use Illuminate\Support\Facades\Auth;



class MeGustaController extends Controller
{
  public function toggle(Publicacion $publicacion)
{
    $usuario = Auth::user();

    $meGusta = MeGusta::where('publicacion_id', $publicacion->id)
                      ->where('usuario_id', $usuario->id)
                      ->first();

    if ($meGusta) {
        $meGusta->delete();
        $status = 'dislike';
    } else {
        MeGusta::create([
            'publicacion_id' => $publicacion->id,
            'usuario_id' => $usuario->id
        ]);
        $status = 'like';
    }

    return response()->json([
        'status' => $status,
        'total' => $publicacion->meGustas()->count()

    ]);
}

public function usuarios(Publicacion $publicacion)
{
     // Obtener los nombres de los usuarios que le dieron like
    $usuarios = $publicacion->meGustas()->with('usuario')->get()->map(function($meGusta) {
        return $meGusta->usuario->name;  // <-- aquí el cambio
    });

    return response()->json($usuarios);
}

// MeGustaController.php
public function notificaciones()
{
    $usuario = Auth::user();

    $totalLikesRecibidos = MeGusta::whereHas('publicacion', function ($query) use ($usuario) {
        $query->where('user_id', $usuario->id);
    })->where('usuario_id', '!=', $usuario->id) // Solo si no es el mismo usuario
      ->count();

    return response()->json(['notificaciones' => $totalLikesRecibidos]);
}





}
