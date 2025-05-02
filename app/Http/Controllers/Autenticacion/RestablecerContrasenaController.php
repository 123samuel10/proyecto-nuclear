<?php
namespace App\Http\Controllers\Autenticacion;

use Illuminate\Http\Request; // Importa la clase Request para manejar las solicitudes HTTP.
use App\Http\Controllers\Controller; // Importa la clase base Controller.
use App\Mail\CodigoRecuperacionMail; // Importa la clase del mail que se enviará con el código de recuperación.
use App\Models\User; // Importa el modelo de usuario.
use Illuminate\Support\Facades\Hash; // Importa Hash para gestionar contraseñas de manera segura.
use Carbon\Carbon; // Importa la clase Carbon para manejar fechas y tiempos.
use Illuminate\Support\Facades\Mail; // Importa la clase Mail para enviar correos.
use Illuminate\Support\Str; // Importa la clase Str (aunque no se usa en este archivo).
use Illuminate\Support\Facades\DB; // Importa la fachada DB para interactuar con la base de datos.

class RestablecerContrasenaController extends Controller
{
    // Método que muestra el formulario para ingresar el correo de recuperación de contraseña
    public function mostrarFormulario()
    {
        return view('autenticacion.recuperar_contraseña'); // Retorna la vista para recuperar la contraseña.
    }

    // Método que maneja el proceso de restablecimiento de contraseña
    public function restablecer(Request $request)
    {
        // Valida los datos enviados desde el formulario
        $request->validate([
            'email' => 'required|email|exists:users,email', // El correo debe ser válido y existir en la tabla de usuarios
            'codigo' => 'required', // El código de recuperación es obligatorio
            'password' => 'required|min:6|confirmed', // La nueva contraseña debe ser válida y confirmada
        ]);

        // Verifica si el código de recuperación existe en la base de datos y si coincide con el correo
        $registro = DB::table('codigos_recuperacion')
                      ->where('email', $request->email)
                      ->where('codigo', $request->codigo)
                      ->first();

        if (!$registro) {
            // Si no se encuentra el código o no corresponde al correo, muestra un error
            return back()->withErrors(['codigo' => 'El código ingresado es incorrecto o no corresponde a este correo.']);
        }

        // Verifica si el código ha expirado, considerando que tiene una duración de 15 minutos
        if (Carbon::parse($registro->created_at)->addMinutes(15)->isPast()) {
            return back()->withErrors(['codigo' => 'El código ha expirado. Solicita uno nuevo.']);
        }

        // Si la validación es exitosa, procede a restablecer la contraseña
        $usuario = User::where('email', $request->email)->first(); // Busca al usuario por su correo
        $usuario->password = Hash::make($request->password); // Encripta y guarda la nueva contraseña
        $usuario->save(); // Guarda los cambios en la base de datos

        // Borra el código usado para que no pueda ser reutilizado
        DB::table('codigos_recuperacion')->where('email', $request->email)->delete();

        // Redirige al usuario a la página de inicio de sesión con un mensaje de éxito
        return redirect()->route('login.formulario')->with('success', 'Contraseña actualizada correctamente. Ahora puedes iniciar sesión.');
    }

    // Método que genera y envía un código de recuperación al correo del usuario
    public function enviarCodigo(Request $request)
    {
        // Valida que el correo ingresado sea válido
        $request->validate(['email' => 'required|email']);

        $email = $request->input('email'); // Obtiene el correo ingresado por el usuario
        $codigo = rand(100000, 999999); // Genera un código aleatorio de 6 dígitos

        // Guarda o actualiza el código en la tabla 'codigos_recuperacion' con la fecha actual
        DB::table('codigos_recuperacion')->updateOrInsert(
            ['email' => $email], // Busca por el correo del usuario
            ['codigo' => $codigo, 'created_at' => Carbon::now()] // Actualiza el código y la fecha de creación
        );

        // Intenta enviar el código al correo del usuarioooo
        try {
            Mail::to($email)->send(new CodigoRecuperacionMail($codigo)); // Envía el correo con el código
            return back()->with('success', 'Se ha enviado un código a tu correo.'); // Mensaje de éxito
        } catch (\Exception $e) {
            // Si ocurre un error al enviar el correo, muestra un mensaje de error
            return back()->withErrors(['email' => 'Hubo un problema al enviar el correo. Intenta nuevamente.']);
        }
    }
}
