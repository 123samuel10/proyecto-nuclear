@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-xl max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Recuperar contraseña</h2>

    {{-- Formulario para enviar el código al correo --}}
    <form id="formEnviarCodigo" action="{{ route('enviar-codigo') }}" method="POST" class="space-y-4 mb-8">
        @csrf
        <div>
            <label for="email_enviar" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
            <input type="email" name="email" id="email_enviar" required class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
            Enviar código al correo
        </button>
    </form>

    {{-- Formulario para restablecer contraseña con código --}}
    <form id="formRestablecer" action="{{ route('recuperar-contraseña') }}" method="POST" class="space-y-4 hidden">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
            <input type="email" name="email" id="email" required class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700">Código recibido</label>
            <input type="text" name="codigo" id="codigo" required class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Nueva contraseña</label>
            <input type="password" name="password" id="password" required class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400">
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition" id="btnRestablecer">
            Restablecer contraseña
        </button>
    </form>

    {{-- Mensajes --}}
    @if(session('success'))
        <p id="mensajeSuccess" class="mt-4 text-green-600 text-center">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <div class="mt-4 text-red-600">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Volver a iniciar sesión</a>
    </div>
</div>

{{-- Modal de resultado --}}
<div id="modalResult" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div id="modalContent" class="bg-white rounded-2xl p-8 max-w-sm text-center shadow-2xl animate-fadeIn">
        <div id="modalIcon" class="text-green-500 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h3 id="modalTitle" class="text-2xl font-bold mb-2"></h3>
        <p id="modalMessage" class="mb-4 text-gray-600"></p>
        <a href="{{ route('login') }}" id="modalButton" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Ir a iniciar sesión
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mensajeSuccess = document.getElementById('mensajeSuccess');
        const formEnviar = document.getElementById('formEnviarCodigo');
        const formRestablecer = document.getElementById('formRestablecer');
        const modalResult = document.getElementById('modalResult');
        const modalTitle = document.getElementById('modalTitle');
        const modalMessage = document.getElementById('modalMessage');
        const modalIcon = document.getElementById('modalIcon');
        const btnRestablecer = document.getElementById('btnRestablecer');

        // Muestra el modal con los mensajes de éxito
        if (mensajeSuccess) {
            if (mensajeSuccess.textContent.includes('Se ha enviado un código')) {
                formEnviar.classList.add('hidden');
                formRestablecer.classList.remove('hidden');
            }
            if (mensajeSuccess.textContent.includes('Contraseña actualizada correctamente')) {
                modalResult.classList.remove('hidden');
                modalTitle.textContent = "¡Contraseña cambiada!";
                modalMessage.textContent = "Tu contraseña ha sido actualizada correctamente. Ahora puedes iniciar sesión.";
                modalIcon.classList.replace('text-green-500', 'text-blue-500');
            }
        }

        // Mostrar el modal si hay errores
        @if($errors->any())
            modalResult.classList.remove('hidden');
            modalTitle.textContent = "¡Error!";
            modalMessage.textContent = "Hubo un error con los datos. Por favor, verifica la información ingresada.";
            modalIcon.classList.replace('text-green-500', 'text-red-500');
        @endif


    });
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}
.animate-fadeIn {
    animation: fadeIn 0.4s ease-out forwards;
}
</style>

@endsection
