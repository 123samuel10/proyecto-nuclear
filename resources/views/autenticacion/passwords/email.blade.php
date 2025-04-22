<!-- resources/views/autenticacion/passwords/email.blade.php -->
<form action="{{ route('password.email') }}" method="POST">
    @csrf
    <label for="email">Correo electrónico</label>
    <input type="email" name="email" id="email" required>
    <button type="submit">Enviar enlace de recuperación</button>
</form>

@if (session('status'))
    <div>{{ session('status') }}</div>
@endif
