<?php

use App\Http\Controllers\Autenticacion\BienvenidaController;  // Importa el controlador de bienvenida.
use App\Http\Controllers\Autenticacion\CerrarSesionController; // Importa el controlador para cerrar sesión.
use App\Http\Controllers\Autenticacion\InicioSesionController; // Importa el controlador para inicio de sesión.
// use App\Http\Controllers\Autenticacion\RestablecerContrasenaController; // Importa el controlador para recuperar contraseña.
use App\Http\Controllers\Autenticacion\RegistroController; // Importa el controlador para registro de usuario.
use App\Http\Controllers\Autenticacion\RestablecerContrasenaController;
use App\Http\Controllers\Comentario\ComentarioController;
use App\Http\Controllers\MeGustaController;
use App\Http\Controllers\Perfil\PerfilController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\Seguimiento\SeguimientoController;
// use App\Http\Controllers\RestablecerContrasenaController as ControllersRestablecerContrasenaController;
use Illuminate\Support\Facades\Route; // Importa la fachada Route, que se usa para definir rutas.

// Redirige la ruta principal al formulario de inicio de sesión
Route::get('/', function () {
    return redirect()->route('login.formulario');
});
// La ruta principal es la página de inicio, y se le asigna el nombre 'inicio'.

Route::get('/iniciar-sesion', [InicioSesionController::class, 'mostrarFormularioInicioSesion'])->name('login.formulario');
// Ruta GET para mostrar el formulario de inicio de sesión. Se asigna al método 'mostrarFormularioInicioSesion' del controlador 'InicioSesionController'.
// La ruta tiene el nombre 'login.formulario'.(login.formulario:Mostrar el formulario se usa en Enlaces, redirecciones a la vista del login)

Route::post('/iniciar-sesion', [InicioSesionController::class, 'iniciarSesion'])->name('login');
// Ruta POST para enviar los datos del formulario de inicio de sesión. Se asigna al método 'iniciarSesion' del controlador 'InicioSesionController'.
// La ruta tiene el nombre 'login'. (login:Procesar el formulario se usa En action del <form>)

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

// Route::get('/bienvenida', [BienvenidaController::class, 'index'])->name('bienvenida');
Route::get('/perfil', [BienvenidaController::class, 'verPerfil'])->name('ver-perfil');

// Route::post('/cambiar-contraseña', [BienvenidaController::class, 'cambiarContraseña'])->name('cambiar-contraseña');
Route::get('/logout', [BienvenidaController::class, 'logout'])->name('logout');

// web.php
Route::get('/recuperar-contraseña', [RestablecerContrasenaController::class, 'mostrarFormulario'])->name('recuperar-contraseña.formulario');
Route::post('/recuperar-contraseña', [RestablecerContrasenaController::class, 'restablecer'])->name('recuperar-contraseña');
Route::post('/enviar-codigo', [RestablecerContrasenaController::class, 'enviarCodigo'])->name('enviar-codigo');

// sistema de busquedad
Route::get('/buscar-usuarios', [BienvenidaController::class, 'buscarUsuarios'])->name('buscar.usuarios');
Route::get('/buscar-publicaciones-etiqueta', [BienvenidaController::class, 'buscarPublicacionesPorEtiqueta'])->name('buscar.publicaciones.etiqueta');

// Ruta para mostrar el formulario de edición de perfil
Route::get('/perfil/editar', [PerfilController::class, 'editar'])->name('perfil.editar');
// Ruta para actualizar los datos del perfil
Route::put('/perfil/actualizar', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');

// publicaciones
// Route::get('/publicaciones', [PublicacionController::class, 'index'])->name('publicaciones.index');
Route::get('/publicaciones/crear', [PublicacionController::class, 'create'])->name('publicaciones.create');
Route::post('/publicaciones', [PublicacionController::class, 'store'])->name('publicaciones.store');
Route::get('publicaciones/{publicacion}/editar', [PublicacionController::class, 'edit'])->name('publicaciones.edit');

Route::put('publicaciones/{publicacion}', [PublicacionController::class, 'update'])->name('publicaciones.update');
Route::delete('publicaciones/{publicacion}', [PublicacionController::class, 'destroy'])->name('publicaciones.destroy');
Route::get('/publicaciones/{publicacion}', [BienvenidaController::class, 'mostrarPublicacion'])->name('publicacion.mostrar');

// comentarios:
// Route::post('/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
// Rutas de comentarios
Route::post('/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::get('/comentarios/{id}/edit', [ComentarioController::class, 'edit'])->name('comentarios.edit');
Route::put('/comentarios/{id}', [ComentarioController::class, 'update'])->name('comentarios.update');
Route::delete('/comentarios/{id}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');

Route::get('/perfil/{id}', [PerfilController::class, 'mostrar'])->name('perfil.mostrar');

// sistema de seguimiento:

Route::post('/seguir/{id}', [SeguimientoController::class, 'seguir'])->name('seguir');
Route::delete('/dejar-de-seguir/{id}', [SeguimientoController::class, 'dejarDeSeguir'])->name('dejarDeSeguir');

// me gusta
// web.php
Route::post('/me-gusta/{publicacion}', [MeGustaController::class, 'toggle'])->name('me-gusta.toggle');

Route::get('/me-gusta/{publicacion}/usuarios', [MeGustaController::class, 'usuarios'])->name('me-gusta.usuarios');

// notificaciones
Route::get('/notificaciones/megusta', [MeGustaController::class, 'notificaciones'])->name('notificaciones.megusta');

Route::get('/notificaciones/lista', [MeGustaController::class, 'listaNotificaciones'])->name('notificaciones.lista');


Route::get('/notificaciones/comentarios', [ComentarioController::class, 'notificaciones'])->name('notificaciones.comentarios');
Route::get('/notificaciones/comentarios/lista', [ComentarioController::class, 'listaNotificaciones'])->name('notificaciones.comentarios.lista');




// Rutas para contar notificaciones de seguimiento
Route::get('/notificaciones/seguimiento', [SeguimientoController::class, 'notificaciones'])->name('notificaciones.seguimiento');

// Ruta para listar notificaciones de seguimiento
Route::get('/notificaciones/seguimiento/lista', [SeguimientoController::class, 'listaNotificaciones'])->name('notificaciones.seguimiento.lista');
