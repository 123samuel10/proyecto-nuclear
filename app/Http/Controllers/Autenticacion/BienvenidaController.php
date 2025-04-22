<?php

// app/Http/Controllers/Autenticacion/BienvenidaController.php

// Define el espacio de nombres (namespace) para este controlador
// Esto es para organizar el código y evitar conflictos con otros controladores.
namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller; // Se importa la clase base Controller de Laravel, de la cual heredará este controlador.
use Illuminate\Http\Request; // Se importa la clase Request para manejar las solicitudes HTTP, aunque no se usa directamente aquí.

// Definición de la clase BienvenidaController que extiende de la clase base Controller
class BienvenidaController extends Controller
{
    // Definición del método index, este método se ejecuta cuando se hace una solicitud a la ruta asociada con este controlador.
    public function index()
    {
        // El método view() devuelve la vista 'bienvenida' ubicada en resources/views/bienvenida.blade.php
        return view('bienvenida');
    }
}
