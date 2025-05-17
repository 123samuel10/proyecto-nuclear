<?php

namespace App\Http\Controllers;

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
            // Quitar like
            $meGusta->delete();

            // Borrar notificación con LIKE en mensaje
            \App\Models\Notificacion::where('usuario_id', $publicacion->user_id)
                ->where('publicacion_id', $publicacion->id)
                ->where('tipo', 'like')
                ->where('mensaje', 'like', "%{$usuario->name}%me gusta%\"{$publicacion->titulo}\"%")
                ->delete();

            $status = 'dislike';
        } else {
            // Agregar like
            MeGusta::create([
                'publicacion_id' => $publicacion->id,
                'usuario_id' => $usuario->id,
            ]);

            $status = 'like';

            // Crear notificación siempre, incluso si es el mismo usuario
            \App\Models\Notificacion::create([
                'usuario_id' => $publicacion->user_id,
                'publicacion_id' => $publicacion->id,
                'tipo' => 'like',
                'mensaje' => "{$usuario->name} le dio me gusta a tu publicación \"{$publicacion->titulo}\".",
            ]);
        }

        $total = $publicacion->meGustas()->count();

        return response()->json([
            'status' => $status,
            'total' => $total,
        ]);
    }

    public function usuarios(Publicacion $publicacion)
    {
        // Obtener los nombres de los usuarios que le dieron like
        $usuarios = $publicacion->meGustas()->with('usuario')->get()->map(function ($meGusta) {
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

    public function listaNotificaciones()
    {
        $usuario = Auth::user();

        $notificaciones = \App\Models\Notificacion::where('usuario_id', $usuario->id)
            ->where('tipo', 'like')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($notificacion) {
                return [
                    'mensaje' => $notificacion->mensaje,
                    'fecha' => $notificacion->created_at->toDateTimeString(),
                ];
            });

        return response()->json($notificaciones);
    }
}
