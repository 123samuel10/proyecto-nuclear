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

<!-- FOOTER -->
{{-- <footer class="bg-azulU text-white mt-16 pt-24 pb-12"> <!-- Aumenta el padding-top a 24 o más según lo necesites -->


    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div>
                <h2 class="text-xl font-semibold mb-4">Universidad Alexander von Humboldt</h2>
                <p class="text-sm text-gray-300">Armenia, Quindío</p>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Sedes</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><strong>Sede Principal:</strong><br>Av. Bolívar #1-189<br>📞 315 392 1662</li>
                    <li><strong>Sede Anova:</strong><br>Cra. 13 N° 15 Norte-46 Ed. Anova<br>📞 310 804 9716</li>
                    <li><strong>Casa Anova:</strong><br>Calle 16N #13-09<br>📞 310 804 9716</li>
                </ul>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-4">Otras Sedes</h3>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><strong>Sede Alcázar:</strong><br>Calle 4 Norte #13-05<br>📞 316 259 0798</li>
                    <li><strong>Sede Nogal:</strong><br>Carrera 13 #16N-07<br>📞 310 804 9819</li>
                </ul>
            </div>
        </div>

        <!-- Redes Sociales -->
        <div class="text-center pb-6 mt-12">
            <div class="flex justify-center gap-6 text-white text-2xl mb-4">
                <!-- Íconos de redes sociales -->
                <a href="#" class="hover:text-gray-300 transition" aria-label="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="hover:text-gray-300 transition" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.instagram.com/uvonhumboldt?igsh=dHdjdnB2Y2xnZnJx" class="hover:text-gray-300 transition" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
        </div>
    </div>
</footer> --}}

</body>
</html>
