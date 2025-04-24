@extends('layouts.app')

@section('content')
<div class="bg-white p-8 rounded-2xl shadow-xl max-w-md mx-auto mt-10">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Recuperar contraseña</h2>

    <form action="{{ route('recuperar-contraseña') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
            <input type="email" name="email" id="email" required class="w-full mt-2 p-3 border rounded-lg focus:ring-2 focus:ring-blue-400">
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

    @if(session('success'))
        <p class="mt-4 text-green-600">{{ session('success') }}</p>
    @endif
</div>
@endsection
