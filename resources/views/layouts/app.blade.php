<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo', 'Sistema de Autenticación')</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tipografía -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN (para íconos de redes sociales) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

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

<!-- NAVBAR -->
<nav class="bg-azulU shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="text-white text-2xl font-bold tracking-wide uppercase">Humboldt Red</span>
        </div>

        <div class="flex items-center gap-6 text-white">
            @auth
                <div class="text-right hidden md:block">
                    <p class="text-sm font-semibold">Hola, {{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-300">Estás conectado</p>
                </div>

                <a href="{{ route('ver-perfil') }}"
                   class="bg-white text-azulU font-semibold px-4 py-2 rounded-full border border-white hover:bg-azulU hover:text-white transition-colors">
                    Ver perfil
                </a>
            @endauth
        </div>
    </div>
</nav>

<!-- CONTENIDO -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 mb-48"> <!-- Ajusta el margin-bottom para dejar espacio al footer -->


    <div class="bg-white shadow-xl rounded-3xl p-6 md:p-10">
        @yield('content')
    </div>
</main>



</body>
</html>
