@extends('layouts.app')

@section('content')
    <div class="bg-white p-12 rounded-xl shadow-2xl max-w-3xl mx-auto">

        <!-- Encabezado de perfil -->
        <div class="flex items-center gap-4 mb-8">
            <div class="bg-indigo-600 text-white rounded-full w-16 h-16 flex items-center justify-center text-2xl font-bold shadow-md">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-3xl font-semibold text-gray-800">Mi perfil</h1>
                <p class="text-gray-500 text-md">{{ $user->email }}</p>
            </div>
        </div>

        <!-- Información general -->
        <div class="mb-10">
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Información general</h2>
            <p class="text-lg text-gray-800"><strong>Nombre completo:</strong> {{ $user->name }}</p>
            <p class="text-lg text-gray-800"><strong>Correo electrónico:</strong> {{ $user->email }}</p>
        </div>

        <!-- Formulario para cambiar la contraseña -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Cambiar contraseña</h2>
            <form action="{{ route('cambiar-contraseña') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="password" class="block text-lg font-medium text-gray-700">Nueva contraseña</label>
                    <input type="password" name="password" id="password" class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-lg font-medium text-gray-700">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-2 p-4 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-3 rounded-lg shadow-lg hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-300">Cambiar contraseña</button>
            </form>
        </div>

        <!-- Mensaje de éxito -->
        @if(session('success'))
            <div class="mt-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-lg shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Enlace para volver -->
        <div class="text-center mt-6">
            <a href="{{ route('bienvenida') }}" class="text-blue-600 hover:text-blue-800 text-lg font-medium transition-all duration-300">Volver a bienvenida</a>
        </div>
    </div>
@endsection
