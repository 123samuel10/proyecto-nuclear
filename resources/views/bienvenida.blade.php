<h1>Bienvenido, {{ Auth::user()->name }}</h1>
<!--
   Esta línea muestra un encabezado <h1> con un mensaje de bienvenida que incluye el nombre del usuario autenticado.
   'Auth::user()' obtiene el usuario autenticado en la sesión actual y 'name' obtiene su nombre.
   Esto muestra algo como: "Bienvenido, Juan Pérez", si "Juan Pérez" es el usuario autenticado.
-->

<a href="{{ route('logout') }}">Cerrar sesión</a>
<!--
   Este es un enlace (link) que redirige al usuario a la ruta de cierre de sesión.
   'route('logout')' genera la URL de la ruta llamada 'logout', que es típicamente la ruta asociada con el método para cerrar sesión.
   El texto visible en el enlace será "Cerrar sesión", y al hacer clic, el usuario será deslogueado de la aplicación.
-->
