@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-xl max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Recuperar contraseña</h2>

    {{-- Formulario para enviar el código al correo --}}
    <form action="{{ route('enviar-codigo') }}" method="POST" class="space-y-4 mb-8">
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
    <form action="{{ route('recuperar-contraseña') }}" method="POST" class="space-y-4">
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

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Restablecer contraseña
        </button>
    </form>

    {{-- Mensajes --}}
    @if(session('success'))
        <p class="mt-4 text-green-600">{{ session('success') }}</p>
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
@endsection
