<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Models\Notificacion;
use App\Models\Seguimiento;
use Illuminate\Support\Facades\Auth;

class SeguimientoController extends Controller
{
     /**
     * Seguir a un usuario
     */
    public function seguir($id)
    {
        $usuario = Auth::user();

        // Verificar si ya está siguiendo a este usuario
        $existeSeguimiento = Seguimiento::where('usuario_id', $usuario->id)
            ->where('seguido_id', $id)
            ->exists();

        if ($existeSeguimiento) {
            return redirect()->back()->with('error', 'Ya sigues a este usuario');
        }

        // Crear el seguimiento
        Seguimiento::create([
            'usuario_id' => $usuario->id,
            'seguido_id' => $id,
        ]);

        // Crear notificación para el usuario seguido
        Notificacion::create([
            'usuario_id' => $id,
            'tipo' => 'seguimiento',
            'mensaje' => "{$usuario->name} comenzó a seguirte.",
        ]);

        return redirect()->back()->with('success', 'Has seguido al usuario correctamente');
    }

    /**
     * Dejar de seguir a un usuario
     */
  public function dejarDeSeguir($id)
{
    $usuario = Auth::user();

    // Buscar relación de seguimiento
    $seguimiento = Seguimiento::where('usuario_id', $usuario->id)
        ->where('seguido_id', $id)
        ->first();

    if ($seguimiento) {
        // Eliminar seguimiento
        $seguimiento->delete();

        // Eliminar notificación relacionada (opcional: puedes usar más condiciones si es necesario)
        Notificacion::where('usuario_id', $id)
            ->where('tipo', 'seguimiento')
            ->where('mensaje', "{$usuario->name} comenzó a seguirte.")
            ->delete();

        return redirect()->back()->with('success', 'Has dejado de seguir a este usuario');
    } else {
        return redirect()->back()->with('error', 'No estás siguiendo a este usuario');
    }
}

    /**
     * Contar notificaciones de seguimientos
     */
    public function notificaciones()
    {
        $usuario = Auth::user();

        $totalSeguimientosRecibidos = Notificacion::where('usuario_id', $usuario->id)
            ->where('tipo', 'seguimiento')
            ->count();

        return response()->json(['notificaciones' => $totalSeguimientosRecibidos]);
    }

    /**
     * Listar notificaciones completas de seguimientos
     */
    public function listaNotificaciones()
    {
        $usuario = Auth::user();

        $notificaciones = Notificacion::where('usuario_id', $usuario->id)
            ->where('tipo', 'seguimiento')
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
