@extends('layouts.app')

@section('content')
    <div class="bg-white p-10 rounded-xl shadow-xl max-w-lg mx-auto">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">Bienvenido, {{ Auth::user()->name }}</h1>
        <div class="text-center space-y-4">
            <a href="{{ route('ver-perfil') }}" class="text-blue-600 hover:text-blue-800 text-lg font-medium transition-all duration-300">Ver perfil</a>
            <span class="text-gray-500">|</span>
            <a href="{{ route('logout') }}" class="text-red-600 hover:text-red-800 text-lg font-medium transition-all duration-300">Cerrar sesión</a>
        </div>
    </div>
@endsection
