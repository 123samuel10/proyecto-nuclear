<form action="{{ route('register') }}" method="POST">
    @csrf
    <input type="text" name="nombre" placeholder="Nombre completo" required>
    <input type="email" name="email" placeholder="Correo electrónico" required>
    <input type="password" name="contraseña" placeholder="Contraseña" required>
    <input type="password" name="contraseña_confirmation" placeholder="Confirmar contraseña" required>
    <button type="submit">Registrarse</button>
</form>

@if(session('status'))
    <div>
        <strong>{{ session('status') }}</strong>
    </div>
@endif

@if ($errors->any())
    <div>
        <strong>{{ $errors->first() }}</strong>
    </div>
@endif
