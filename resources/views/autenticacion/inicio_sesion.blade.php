<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación - Proyecto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .modal-show {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }
        .modal-hide {
            opacity: 0;
            pointer-events: none;
            transform: translateY(-20px);
        }
        .transition-modal {
            transition: all 0.4s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Modal elegante -->
    <div id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm modal-hide transition-modal z-50">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full text-center">
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-red-600 mb-2">¡Ups! Algo salió mal</h3>
            <ul class="text-gray-700 mb-4">
                @foreach ($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                @endforeach
            </ul>
            <button onclick="closeModal()"
                class="bg-gradient-to-r from-red-500 to-pink-500 text-white px-6 py-2 rounded-full hover:scale-105 transform transition">
                Entendido
            </button>
        </div>
    </div>

    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="flex flex-col md:flex-row bg-white rounded-2xl shadow-2xl overflow-hidden max-w-4xl w-full">
            <div class="hidden md:block md:w-1/2">
                <img src="/storage/fondo.png" alt="Imagen decorativa"
                     class="w-full h-full object-cover" />
            </div>
            <div class="w-full md:w-1/2 p-8 bg-white bg-opacity-90">
                <h2 class="text-3xl font-bold text-center mb-6 text-gray-800">Iniciar sesión</h2>

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="email" class="block mb-1 font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" name="email" id="email" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <label for="password" class="block mb-1 font-medium text-gray-700">Contraseña</label>
                        <input type="password" name="contraseña" id="password" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            Iniciar sesión
                        </button>
                    </div>

                    <p class="text-sm text-center text-gray-700">
                        ¿No tienes cuenta?
                        <a href="{{ route('register.formulario') }}" class="text-blue-600 hover:underline">Regístrate</a>
                    </p>
                    <p class="text-sm text-center text-gray-700 mt-2">
                        <a href="{{ route('recuperar-contraseña.formulario') }}" class="text-blue-600 hover:underline">¿Olvidaste tu contraseña?</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para controlar el modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                const modal = document.getElementById('errorModal');
                modal.classList.add('modal-show');
                modal.classList.remove('modal-hide');
            @endif
        });

        function closeModal() {
            const modal = document.getElementById('errorModal');
            modal.classList.remove('modal-show');
            modal.classList.add('modal-hide');
        }
    </script>

</body>
</html>
