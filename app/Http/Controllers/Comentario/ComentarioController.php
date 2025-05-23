<?php

namespace App\Http\Controllers\Comentario;

use App\Http\Controllers\Controller;
use App\Models\Comentario;
use App\Models\Notificacion;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{

public function store(Request $request)
{
    $request->validate([
        'publicacion_id' => 'required|exists:publicaciones,id',
        'contenido' => 'required|string|max:1000',
    ]);

    $usuario = Auth::user();
    $publicacion = Publicacion::findOrFail($request->publicacion_id);

    $comentario = Comentario::create([
        'user_id' => $usuario->id,
        'publicacion_id' => $publicacion->id,
        'contenido' => $request->contenido,
    ]);

    // Crear notificación siempre, incluso si es el mismo usuario
    Notificacion::create([
        'usuario_id' => $publicacion->user_id,
        'publicacion_id' => $publicacion->id,
        'tipo' => 'comentario',
        'mensaje' => "{$usuario->name} comentó en tu publicación \"{$publicacion->titulo}\".",
    ]);

    return redirect()->route('bienvenida')->with([
        'publicacion_creada' => true,
        'mensaje_exito' => '¡Comentario creado correctamente!',
    ]);
}


    // Edita un comentario existente
    public function edit($id)
    {
        $comentario = Comentario::findOrFail($id);

        // Verificar que el usuario autenticado sea el autor del comentario
        if ($comentario->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No tienes permiso para editar este comentario.');
        }

        return view('comentarios.edit', compact('comentario'));
    }

    // Actualiza el comentario editado
 public function update(Request $request, $id)
{
    $comentario = Comentario::findOrFail($id);

    if ($comentario->user_id !== Auth::id()) {
        return redirect()->back()->with('error', 'No tienes permiso para editar este comentario.');
    }

    $request->validate([
        'contenido' => 'required|string|max:1000',
    ]);

    $comentario->update([
        'contenido' => $request->contenido,
    ]);

    $usuario = Auth::user();
    $publicacion = Publicacion::findOrFail($comentario->publicacion_id);

    // Eliminar notificación antigua relacionada con este comentario (si existe)
    Notificacion::where('usuario_id', $publicacion->user_id)
        ->where('publicacion_id', $publicacion->id)
        ->where('tipo', 'comentario')
        ->where('mensaje', 'like', "%{$usuario->name}%")
        ->delete();

    // Crear nueva notificación con el contenido actualizado del comentario
    Notificacion::create([
        'usuario_id' => $publicacion->user_id,
        'publicacion_id' => $publicacion->id,
        'tipo' => 'comentario',
        'mensaje' => "{$usuario->name} editó su comentario: \"{$request->contenido}\"",
    ]);

    return redirect()->route('bienvenida')->with([
        'publicacion_creada' => true,
        'mensaje_exito' => '¡Comentario actualizado correctamente!',
    ]);
}


    // Elimina un comentario
   public function destroy($id)
{
    $comentario = Comentario::findOrFail($id);

    if ($comentario->user_id !== Auth::id()) {
        return redirect()->back()->with('error', 'No tienes permiso para eliminar este comentario.');
    }

    // Buscar la publicación y el usuario autenticado
    $publicacion = Publicacion::find($comentario->publicacion_id);
    $usuario = Auth::user();

    // Eliminar la notificación del comentario, sea quien sea el autor
    if ($publicacion) {
        Notificacion::where('usuario_id', $publicacion->user_id)
            ->where('publicacion_id', $publicacion->id)
            ->where('tipo', 'comentario')
            ->where('mensaje', 'like', "%{$usuario->name}%comentó en tu publicación \"%{$publicacion->titulo}\"%")
            ->delete();
    }

    $comentario->delete();

    return redirect()->route('bienvenida')->with([
        'publicacion_creada' => true,
        'mensaje_exito' => '¡Comentario eliminado correctamente!',
    ]);
}


    // NUEVO método para contar notificaciones de comentarios
    public function notificaciones()
    {
        $usuario = Auth::user();

        $totalComentariosRecibidos = Notificacion::where('usuario_id', $usuario->id)
            ->where('tipo', 'comentario')
            ->count();

        return response()->json(['notificaciones' => $totalComentariosRecibidos]);
    }
// NUEVO método para listar las notificaciones completas de comentarios
    public function listaNotificaciones()
    {
        $usuario = Auth::user();

        $notificaciones = Notificacion::where('usuario_id', $usuario->id)
            ->where('tipo', 'comentario')
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
