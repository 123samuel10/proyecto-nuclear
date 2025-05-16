<?php

namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicacionController extends Controller
{
  public function create()
    {
        $etiquetas = Etiqueta::all();
        return view('publicaciones.crear', compact('etiquetas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:tutorial,video,material,articulo,evento',
            'archivo' => 'nullable|file|max:20480',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id'
        ]);

        $rutaArchivo = null;

        if ($request->hasFile('archivo')) {
            $rutaArchivo = $request->file('archivo')->store('publicaciones', 'public');
        }

        $publicacion = Publicacion::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'archivo' => $rutaArchivo ? str_replace('public/', '', $rutaArchivo) : null,
        ]);

        if ($request->filled('etiquetas')) {
            $publicacion->etiquetas()->sync($request->etiquetas);
        }

        return redirect()->route('bienvenida')->with([
            'publicacion_creada' => true,
            'mensaje_exito' => '¡Publicación creada correctamente!',
        ]);
    }

    public function edit($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        $etiquetas = Etiqueta::all();
        $etiquetasSeleccionadas = $publicacion->etiquetas->pluck('id')->toArray();

        return view('publicaciones.editar', compact('publicacion', 'etiquetas', 'etiquetasSeleccionadas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:tutorial,video,material,articulo,evento',
            'archivo' => 'nullable|file|mimes:jpg,png,pdf,docx,txt|max:20480',
            'etiquetas' => 'nullable|array',
            'etiquetas.*' => 'exists:etiquetas,id'
        ]);

        $publicacion = Publicacion::findOrFail($id);
        $publicacion->titulo = $request->titulo;
        $publicacion->descripcion = $request->descripcion;
        $publicacion->tipo = $request->tipo;

        if ($request->hasFile('archivo')) {
            if ($publicacion->archivo && Storage::disk('public')->exists($publicacion->archivo)) {
                Storage::disk('public')->delete($publicacion->archivo);
            }

            $archivo = $request->file('archivo')->store('publicaciones', 'public');
            $publicacion->archivo = str_replace('public/', '', $archivo);
        }

        $publicacion->save();

        if ($request->filled('etiquetas')) {
            $publicacion->etiquetas()->sync($request->etiquetas);
        } else {
            $publicacion->etiquetas()->detach(); // Borra etiquetas si no se seleccionan
        }

        return redirect()->route('bienvenida')->with([
            'publicacion_creada' => true,
            'mensaje_exito' => '¡Publicación actualizada correctamente!',
        ]);
    }

    public function destroy($id)
    {
        $publicacion = Publicacion::findOrFail($id);
        $publicacion->etiquetas()->detach(); // Borra relación antes de eliminar
        $publicacion->delete();

        return redirect()->route('bienvenida')->with([
            'publicacion_creada' => true,
            'mensaje_exito' => '¡Publicación eliminada correctamente!',
        ]);
    }


}
