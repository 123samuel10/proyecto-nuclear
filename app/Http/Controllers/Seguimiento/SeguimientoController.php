<?php

namespace App\Http\Controllers\Seguimiento;

use App\Http\Controllers\Controller;
use App\Models\Seguimiento;
use Illuminate\Support\Facades\Auth;

class SeguimientoController extends Controller
{
    /**
     * Seguir a un usuario
     */
    public function seguir($id)
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();
        // Verificar si ya está siguiendo a este usuario
        $existeSeguimiento = Seguimiento::where('usuario_id', $usuario->id)
            ->where('seguido_id', $id)
            ->exists();

        if ($existeSeguimiento) {
            // Si ya sigue al usuario, puedes retornar un mensaje o hacer lo que necesites
            return redirect()->back()->with('error', 'Ya sigues a este usuario');
        }

        // Si no está siguiendo, crear el seguimiento
        Seguimiento::create([
            'usuario_id' => $usuario->id,
            'seguido_id' => $id,
        ]);

        return redirect()->back()->with('success', 'Has seguido al usuario correctamente');
    }

    public function dejarDeSeguir($id)
    {
        /** @var \App\Models\User $usuario */
        $usuario = Auth::user();

        // Verificar si existe la relación de seguimiento
        $seguimiento = Seguimiento::where('usuario_id', $usuario->id)
            ->where('seguido_id', $id)
            ->first();

        if ($seguimiento) {
            // Eliminar el seguimiento
            $seguimiento->delete();

            // Puedes retornar un mensaje de éxito o redirigir de nuevo
            return redirect()->back()->with('success', 'Has dejado de seguir a este usuario');
        } else {
            // Si no se encontró la relación, manejarlo de alguna manera
            return redirect()->back()->with('error', 'No estás siguiendo a este usuario');
        }
    }
}
