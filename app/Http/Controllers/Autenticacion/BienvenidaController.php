<?php

// app/Http/Controllers/Autenticacion/BienvenidaController.php

// Define el espacio de nombres (namespace) para este controlador
// Esto es para organizar el código y evitar conflictos con otros controladores.

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use App\Models\Publicacion; // Importa el modelo de Publicación
use App\Models\User; // Importa la clase Request para manejar solicitudes HTTP
use Illuminate\Http\Request; // Importa Auth para gestionar la autenticación de usuarios
use Illuminate\Support\Facades\Auth; // Importa el modelo de Usuario
use Illuminate\Support\Facades\Hash; // Importa Hash para gestionar contraseñas (aunque no se utiliza en este archivo)

// Importa el validador para la validación de datos (aunque no se utiliza en este archivo)

// Definición de la clase BienvenidaController que extiende de la clase base Controller
class BienvenidaController extends Controller
{

     // Método que se encarga de mostrar las publicaciones en la página de bienvenida
    // public function index()
    // {
    //     // Trae todas las publicaciones, ordenadas de más reciente a más antigua
    //     // $publicaciones = Publicacion::latest()->get();
    //     $publicaciones = Publicacion::with('comentarios.user')->latest()->get(); // Carga las publicaciones junto con los comentarios y los usuarios asociados

    //     // Devuelve la vista 'bienvenida' pasando las publicaciones como parámetro
    //     return view('bienvenida', compact('publicaciones'));
    // }
    // Método que se encarga de mostrar las publicaciones en la página de bienvenida
public function index()
{
    $user = Auth::user(); // Usuario autenticado

    if ($user && $user->intereses) {
        // Convertir los intereses del usuario en array (asumiendo que están separados por comas)
        $intereses = array_map('trim', explode(',', $user->intereses));

        // Buscar publicaciones que tengan alguna etiqueta que coincida con los intereses
        $publicaciones = \App\Models\Publicacion::whereHas('etiquetas', function ($query) use ($intereses) {
            $query->whereIn('nombre', $intereses);
        })->with('comentarios.user', 'etiquetas')->latest()->get();

        // Si no se encontraron publicaciones, mostrar todas
        if ($publicaciones->isEmpty()) {
            $publicaciones = \App\Models\Publicacion::with('comentarios.user', 'etiquetas')->latest()->get();
        }
    } else {
        // Si el usuario no tiene intereses registrados
        $publicaciones = \App\Models\Publicacion::with('comentarios.user', 'etiquetas')->latest()->get();
    }

    return view('bienvenida', compact('publicaciones'));
}


    // Método que muestra el perfil del usuario autenticado
    public function verPerfil()
    {
        $user = Auth::user(); // Obtiene el usuario autenticado

        // Trae el usuario con la cantidad de seguidores y seguidos
        $user = User::withCount(['seguidores', 'seguidos'])->findOrFail($user->id);

        // Trae solo las publicaciones del usuario autenticado, ordenadas de más reciente a más antigua
        $misPublicaciones = Publicacion::where('user_id', $user->id)->latest()->get();

        // Devuelve la vista 'perfil' pasando el usuario, la cuenta de seguidores, seguidos y sus publicaciones como parámetros
        return view('perfil', [
            'user' => $user,
            'misPublicaciones' => $misPublicaciones,
            'seguidoresCount' => $user->seguidores_count,  // Cantidad de seguidores
            'seguidosCount' => $user->seguidos_count,      // Cantidad de seguidos
        ]);
    }

    // Método que cierra la sesión del usuario
    public function logout()
    {
        Auth::logout(); // Cierra la sesión del usuario

        // Redirige al usuario a la página de inicio de sesión
        return redirect()->route('login');
    }

    // Método para actualizar los datos del perfil del usuario
    public function actualizarPerfil(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); // Obtiene el usuario autenticado

        // Valida los datos del formulario de actualización de perfil
        $request->validate([
            'name' => 'required|string|max:255', // El nombre es obligatorio y debe ser una cadena de texto de máximo 255 caracteres
            'descripcion_academica' => 'nullable|string', // La descripción académica es opcional y debe ser una cadena de texto
            'intereses' => 'nullable|string', // Los intereses son opcionales y deben ser una cadena de texto
            'foto_perfil' => 'nullable|image|max:2048', // La foto de perfil es opcional, debe ser una imagen y no puede pesar más de 2MB
        ]);

        // Asigna los nuevos valores al usuario
        $user->name = $request->name;
        $user->descripcion_academica = $request->descripcion_academica;
        $user->intereses = $request->intereses;

        // Si el usuario sube una nueva foto de perfil
        if ($request->hasFile('foto_perfil')) {
            $foto = $request->file('foto_perfil'); // Obtiene el archivo de la foto
            $nombreFoto = time().'_'.$foto->getClientOriginalName(); // Genera un nombre único para la foto
            // Guarda la foto en la carpeta 'public/fotos_perfil'
            $foto->storeAs('public/fotos_perfil', $nombreFoto);
            // Asigna la ruta de la foto al usuario
            $user->foto_perfil = 'fotos_perfil/'.$nombreFoto;
        }

        // Guarda los cambios en la base de datos
        $user->save();

        // Redirige de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function buscarUsuarios(Request $request)
    {
        $query = $request->input('q');

        $usuarios = User::where('name', 'LIKE', '%'.$query.'%')
            ->select('id', 'name', 'foto_perfil')
            ->limit(10)
            ->get();

        return response()->json($usuarios);
    }

    public function buscarPublicacionesPorEtiqueta(Request $request)
    {
        $query = $request->input('q');

        $publicaciones = Publicacion::whereHas('etiquetas', function ($q) use ($query) {
            $q->where('nombre', 'LIKE', '%'.$query.'%');
        })
            ->with(['user', 'etiquetas'])
            ->limit(20)
            ->get()
            ->map(function ($pub) {
                return [
                    'id' => $pub->id,
                    'titulo' => $pub->titulo,
                    'descripcion' => $pub->descripcion,
                    'user_nombre' => $pub->user ? $pub->user->name : 'Desconocido',
                    'etiquetas' => $pub->etiquetas->pluck('nombre')->toArray(),
                ];
            });

        return response()->json($publicaciones);
    }

    public function mostrarPublicacion($id)
    {
        $publicacion = Publicacion::with(['user', 'comentarios.user', 'etiquetas'])
            ->findOrFail($id);

        return view('publicaciones.publicacion_detalle', compact('publicacion'));

    }
}
