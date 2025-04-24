<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación - Proyecto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center">
        <!-- Contenedor del formulario -->
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-lg">
            <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Iniciar sesión</h2>

             <!-- login va porque tiene el metodo post -->
            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Correo -->
                <div>
                    <label for="email" class="block mb-1 font-medium text-gray-700">Correo electrónico</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block mb-1 font-medium text-gray-700">Contraseña</label>
                    <input type="password" name="contraseña" id="password" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <!-- Botón -->
                <div>
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        Iniciar sesión
                    </button>
                </div>

                <!-- Enlace de registro -->
                <p class="text-sm text-center text-gray-600">
                    ¿No tienes cuenta?
                    <a href="{{ route('register.formulario') }}" class="text-blue-600 hover:underline">Regístrate</a>
                </p>

                <!-- Enlace para recuperar la contraseña -->
                <p class="text-sm text-center text-gray-600 mt-2">
                    <a href="{{ route('recuperar-contraseña.formulario') }}" class="text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
                </p>

            </form>
        </div>
    </div>

</body>
</html>
