<?php

// Abre la etiqueta PHP, necesaria para cualquier archivo PHP.

namespace App\Mail;

// Define el namespace (espacio de nombres) donde está esta clase; ayuda a organizar el código.

use Illuminate\Bus\Queueable;
// Importa el trait Queueable, que permite poner el correo en una cola para enviarlo de forma diferida.

use Illuminate\Contracts\Queue\ShouldQueue;
// Importa la interfaz ShouldQueue, que se puede usar si quieres que el correo se envíe usando colas (no obligatorio aquí).

use Illuminate\Mail\Mailable;
// Importa la clase base Mailable, que se extiende para crear correos en Laravel.

use Illuminate\Mail\Mailables\Content;
// Importa la clase Content, que ayuda a definir el contenido del correo (en este caso, no se usa directamente aquí).

use Illuminate\Mail\Mailables\Envelope;
// Importa la clase Envelope, que ayuda a definir el sobre (asunto, remitente, etc.) del correo (tampoco se usa aquí directamente).

use Illuminate\Queue\SerializesModels;

// Importa el trait SerializesModels, que permite serializar modelos Eloquent al ponerlos en una cola.

class CodigoRecuperacionMail extends Mailable
    // Define la clase CodigoRecuperacionMail que extiende de Mailable (es decir, es un correo que se puede enviar).
{
    use Queueable, SerializesModels;
    // Usa los traits Queueable (para colas) y SerializesModels (para serializar modelos si es necesario).

    public $codigo;
    // Declara una propiedad pública llamada $codigo, que contendrá el código que se envía en el correo.

    public function __construct($codigo)
    {
        $this->codigo = $codigo;
        // Constructor de la clase: al crear una nueva instancia del correo, se le pasa un código y se guarda en la propiedad $codigo.
    }

    public function build()
    {
        return $this->subject('Tu código de recuperación')
                    // Define el asunto del correo como 'Tu código de recuperación'.
            ->markdown('emails.codigo_recuperacion')
                    // Indica que se usará una plantilla Markdown ubicada en resources/views/emails/codigo_recuperacion.blade.php.
            ->with(['codigo' => $this->codigo]);
        // Pasa la variable $codigo a la vista como una variable llamada 'codigo'.
    }
}
