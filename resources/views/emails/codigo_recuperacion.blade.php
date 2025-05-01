@component('mail::message')
# Recuperación de contraseña

Tu código de recuperación es:

# **{{ $codigo }}**

Ingresa este código en el formulario para restablecer tu contraseña.

Gracias,<br>
{{ config('app.name') }}
@endcomponent
