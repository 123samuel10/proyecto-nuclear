<?php

namespace App\Http\Controllers\Comentario;


use App\Http\Controllers\Controller;
use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
   public function store(Request $request)
    {
        // Validación de los datos de entrada
        $request->validate([
            'publicacion_id' => 'required|exists:publicaciones,id', // Asegúrate de que el id de la publicación exista
            'contenido' => 'required|string|max:1000', // El comentario debe ser una cadena de texto con un máximo de 1000 caracteres
        ]);

        // Crear el comentario y asociarlo con el usuario y la publicación
        $comentario = Comentario::create([
            'user_id' => Auth::id(), // Asocia el comentario con el usuario autenticado
            'publicacion_id' => $request->publicacion_id, // Asocia el comentario con la publicación
            'contenido' => $request->contenido, // Contenido del comentario
        ]);

        // Devuelve a la misma página con el comentario agregado
        return back()->with('success', 'Comentario agregado con éxito!');
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

        return redirect()->route('bienvenida')->with('success', 'Comentario actualizado con éxito.');
    }

    // Elimina un comentario
    public function destroy($id)
    {
        $comentario = Comentario::findOrFail($id);

        if ($comentario->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar este comentario.');
        }

        $comentario->delete();

        return back()->with('success', 'Comentario eliminado con éxito.');
    }




}
