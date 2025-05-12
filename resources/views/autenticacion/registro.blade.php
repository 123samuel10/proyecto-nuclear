<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>


</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex items-center justify-center px-4">
        <!-- Tarjeta combinada -->
        <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-2xl overflow-hidden max-w-4xl w-full">

            <!-- Imagen a la izquierda -->
            <div class="hidden md:block md:w-1/2">
                <img src="/storage/fondo.png" alt="Imagen de registro" class="w-full h-full object-cover" />
            </div>

            <!-- Formulario a la derecha -->
            <div class="w-full md:w-1/2 p-8">
                <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Crear cuenta</h2>

                {{-- Mensaje de estado --}}
                @if(session('status'))
                    <div class="mb-4 text-sm text-green-600 font-semibold text-center">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Errores de validación --}}
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600 font-semibold text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Nombre -->
                    <div>
                        <label for="nombre" class="block mb-1 text-gray-700 font-medium">Nombre completo</label>
                        <input type="text" name="nombre" id="nombre" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Escribe tu nombre completo">
                    </div>

                    <!-- Correo -->
                    <div>
                        <label for="email" class="block mb-1 text-gray-700 font-medium">Correo electrónico</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="ejemplo@correo.com">
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="contraseña" class="block mb-1 text-gray-700 font-medium">Contraseña</label>
                        <input type="password" name="contraseña" id="contraseña" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Mínimo 6 caracteres">
                    </div>

                    <!-- Confirmar contraseña -->
                    <div>
                        <label for="contraseña_confirmation" class="block mb-1 text-gray-700 font-medium">Confirmar contraseña</label>
                        <input type="password" name="contraseña_confirmation" id="contraseña_confirmation" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            placeholder="Vuelve a escribir la contraseña">
                    </div>

                    <!-- Botón -->
                    <div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200 font-semibold">
                            Registrarse
                        </button>
                    </div>

                    <!-- Enlace para iniciar sesión -->
                    <p class="text-sm text-center text-gray-600 mt-4">
                        ¿Ya tienes una cuenta?
                        <a href="{{ route('login.formulario') }}" class="text-blue-600 hover:underline">Inicia sesión</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
