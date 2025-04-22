<form action="{{ route('login') }}" method="POST">
    <!--
        Este es un formulario que envía una solicitud POST a la ruta 'login'.
        La ruta 'login' debe estar definida en tus rutas de Laravel y debe estar asociada a un controlador que maneje el inicio de sesión.
    -->

    @csrf
    <!--
        Esto genera un token CSRF (Cross-Site Request Forgery) para proteger el formulario de ataques CSRF.
        Laravel requiere este token en los formularios para asegurarse de que las solicitudes provienen de una fuente legítima.
    -->

    <input type="email" name="email" placeholder="Correo electrónico" required>
    <!--
        Este es un campo de entrada donde el usuario debe escribir su correo electrónico.
        El atributo 'required' asegura que el campo no pueda ser dejado vacío.
    -->

    <input type="password" name="contraseña" placeholder="Contraseña" required>
    <!--
        Este es un campo de entrada de tipo 'password', donde el usuario ingresa su contraseña.
        También tiene el atributo 'required' para asegurarse de que no se deje vacío.
    -->

    <button type="submit">Iniciar sesión</button>
    <!--
        Este botón envía el formulario para intentar iniciar sesión.
    -->

       <!-- Enlace para ir a la página de recuperación de contraseña -->

</form>

@if ($errors->any())
    <!--
        Verifica si hay errores de validación en la sesión.
        Si hay algún error, lo muestra en un bloque <div>.
    -->
    <div>
        <strong>{{ $errors->first() }}</strong>
        <!--
            Muestra el primer error de la lista de errores en el formulario.
            Si hay varios errores, solo se mostrará el primero.
        -->
    </div>
@endif
