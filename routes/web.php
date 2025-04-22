<?php

use App\Http\Controllers\Autenticacion\BienvenidaController;  // Importa el controlador de bienvenida.
use App\Http\Controllers\Autenticacion\CerrarSesionController; // Importa el controlador para cerrar sesión.
use App\Http\Controllers\Autenticacion\InicioSesionController; // Importa el controlador para inicio de sesión.
use App\Http\Controllers\Autenticacion\RestablecerContraseñaController; // Importa el controlador para recuperar contraseña.
use App\Http\Controllers\Autenticacion\RegistroController; // Importa el controlador para registro de usuario.

use Illuminate\Support\Facades\Route; // Importa la fachada Route, que se usa para definir rutas.

Route::get('/', function () {
    // Ruta para la página de inicio. Devuelve la vista 'autenticacion.inicio'.
    return view('autenticacion.inicio');
})->name('inicio');
// La ruta principal es la página de inicio, y se le asigna el nombre 'inicio'.

Route::get('/iniciar-sesion', [InicioSesionController::class, 'mostrarFormularioInicioSesion'])->name('login.formulario');
// Ruta GET para mostrar el formulario de inicio de sesión. Se asigna al método 'mostrarFormularioInicioSesion' del controlador 'InicioSesionController'.
// La ruta tiene el nombre 'login.formulario'.

Route::post('/iniciar-sesion', [InicioSesionController::class, 'iniciarSesion'])->name('login');
// Ruta POST para enviar los datos del formulario de inicio de sesión. Se asigna al método 'iniciarSesion' del controlador 'InicioSesionController'.
// La ruta tiene el nombre 'login'.

Route::get('/registrarse', [RegistroController::class, 'mostrarFormularioRegistro'])->name('register.formulario');
// Ruta GET para mostrar el formulario de registro de usuario. Se asigna al método 'mostrarFormularioRegistro' del controlador 'RegistroController'.
// La ruta tiene el nombre 'register.formulario'.

Route::post('/registrarse', [RegistroController::class, 'registrar'])->name('register');
// Ruta POST para enviar los datos del formulario de registro de usuario. Se asigna al método 'registrar' del controlador 'RegistroController'.
// La ruta tiene el nombre 'register'.

Route::get('/cerrar-sesion', [CerrarSesionController::class, 'cerrarSesion'])->name('logout');
// Ruta GET para cerrar sesión. Se asigna al método 'cerrarSesion' del controlador 'CerrarSesionController'.
// La ruta tiene el nombre 'logout'.



Route::get('/bienvenida', [BienvenidaController::class, 'index'])->name('bienvenida');
// Ruta GET para mostrar la página de bienvenida después de que el usuario haya iniciado sesión. Se asigna al método 'index' del controlador 'BienvenidaController'.
// La ruta tiene el nombre 'bienvenida'.
