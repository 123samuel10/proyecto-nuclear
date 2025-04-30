<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tipografía -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Colores personalizados -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        azulU: '#003366',
                        rojoU: '#B22222',
                        grisClaro: '#f5f7fa',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-grisClaro text-gray-800 font-sans antialiased">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-12">

        <!-- Cabecera del perfil -->
        <div class="bg-white p-8 rounded-3xl shadow-2xl flex flex-col md:flex-row items-center md:items-start gap-8">

            <!-- Foto de perfil -->
            <div class="relative flex-shrink-0">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-4 border-azulU shadow-md">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=300" alt="Foto de perfil" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Información del usuario -->
            <div class="flex-1 text-center md:text-left space-y-4">
                <h1 class="text-4xl font-extrabold text-gray-800">{{ $user->name }}</h1>
                <p class="text-lg text-gray-500">{{ $user->email }}</p>

                <!-- Botón Volver -->
                <div class="mt-6">
                    <a href="{{ route('ver-perfil') }}"
                       class="inline-block bg-azulU hover:bg-white hover:text-azulU border-2 border-azulU text-white text-sm font-semibold px-8 py-3 rounded-full shadow-md transition-all duration-300 hover:scale-105">
                        Volver al perfil
                    </a>
                </div>
            </div>
        </div>

        <!-- Formulario de edición de perfil -->
        <div class="bg-white p-8 rounded-3xl shadow-2xl">

            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded-lg mb-8 text-center font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('perfil.actualizar') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!--old() es una función de Laravel que permite recuperar e
                    l valor previamente enviado en un formulario, para mantener los datos ingresados por el usuario en caso de que ocurra un error de validación.-->
                    <!-- Nombre -->
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Nombre</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="w-full border border-gray-300 rounded-xl p-3 focus:border-azulU focus:ring-azulU focus:ring-2 focus:outline-none">
                    </div>

                    <!-- Foto de Perfil -->
                    <div>
                        <label class="block mb-2 text-sm font-bold text-gray-700">Foto de Perfil</label>
                        <input type="file" name="foto_perfil"
                               class="w-full text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-azulU file:text-white hover:file:bg-white hover:file:text-azulU transition-all cursor-pointer">
                    </div>
                </div>

                <!-- Descripción Académica -->
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">Descripción Académica</label>
                    <textarea name="descripcion_academica" rows="4"
                              class="w-full border border-gray-300 rounded-xl p-4 focus:border-azulU focus:ring-azulU focus:ring-2 resize-none focus:outline-none">{{ old('descripcion_academica', $user->descripcion_academica) }}</textarea>
                </div>

                <!-- Intereses -->
                <div>
                    <label class="block mb-2 text-sm font-bold text-gray-700">Intereses</label>
                    <textarea name="intereses" rows="3"
                              class="w-full border border-gray-300 rounded-xl p-4 focus:border-azulU focus:ring-azulU focus:ring-2 resize-none focus:outline-none">{{ old('intereses', $user->intereses) }}</textarea>
                </div>

                <!-- Botón Guardar Cambios -->
                <div class="text-center pt-8">
                    <button type="submit"
                            class="bg-azulU hover:bg-rojoU text-white font-bold py-3 px-10 rounded-full shadow-lg transition-all duration-300 hover:scale-105">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>

    </div>

</body>
</html>
