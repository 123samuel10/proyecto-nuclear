<?php

namespace App\Http\Controllers;

use App\Models\Publicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PublicacionController extends Controller
{
    // public function index()
    // {
    //     $publicaciones = Publicacion::latest()->with('user')->get();
    //     return view('publicaciones.index', compact('publicaciones'));
    // }

    public function create()
    {
        return view('publicaciones.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:tutorial,video,material,articulo,evento',
            'archivo' => 'nullable|file|max:20480', // 20MB máximo
        ]);

        $rutaArchivo = null;

        if ($request->hasFile('archivo')) {
            $rutaArchivo = $request->file('archivo')->store('public/publicaciones');
        }

        Publicacion::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'archivo' => $rutaArchivo ? str_replace('public/', '', $rutaArchivo) : null,
        ]);

        return redirect()->route('bienvenida')->with('success', '¡Publicación creada correctamente!');
    }

    // Método para mostrar el formulario de edición
public function edit($id)
{
    $publicacion = Publicacion::findOrFail($id);
    return view('publicaciones.editar', compact('publicacion'));
}

// Método para actualizar la publicación
public function update(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'required|string',
        'tipo' => 'required|string',
        'archivo' => 'nullable|file|mimes:jpg,png,pdf,docx,txt|max:2048',
    ]);

    $publicacion = Publicacion::findOrFail($id);

    $publicacion->titulo = $request->titulo;
    $publicacion->descripcion = $request->descripcion;
    $publicacion->tipo = $request->tipo;

    if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo')->store('publicaciones', 'public');
        $publicacion->archivo = $archivo;
    }

    $publicacion->save();

    return redirect()->route('bienvenida')->with('success', 'Publicación actualizada correctamente.');
}

}
