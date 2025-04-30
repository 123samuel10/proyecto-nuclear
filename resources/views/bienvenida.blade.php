@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Publicaciones</h1>

<a href="{{ route('publicaciones.create') }}" class="bg-azulU text-white px-4 py-2 rounded-lg mb-6 inline-block">
    Crear nueva publicación
</a>

@if (session('success'))
    <div class="p-4 bg-green-100 border border-green-300 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="space-y-6">
    @foreach ($publicaciones as $publicacion)
        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="font-semibold text-xl">{{ $publicacion->titulo }}</h2>
            <p class="text-sm text-gray-500">
                Publicado por {{ $publicacion->user->name }} - {{ $publicacion->created_at->diffForHumans() }}
            </p>
            <p class="mt-2 text-gray-700">{{ $publicacion->descripcion }}</p>
            <p class="mt-2 text-sm text-gray-600"><strong>Tipo:</strong> {{ ucfirst($publicacion->tipo) }}</p>

            {{-- Mostrar archivo si es una imagen, o permitir descargarlo si no lo es --}}
            @if($publicacion->archivo)
                @php
                    $extension = pathinfo($publicacion->archivo, PATHINFO_EXTENSION);
                @endphp

                @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                    <img src="{{ asset('storage/' . $publicacion->archivo) }}" alt="Imagen de publicación" class="mt-2 w-full h-auto rounded-lg">
                @else
                    <a href="{{ asset('storage/' . $publicacion->archivo) }}" target="_blank" class="text-blue-600 underline mt-2 inline-block">
                        Ver archivo
                    </a>
                @endif
            @endif

            {{-- Botón de editar (solo visible si el usuario es el autor) --}}
            @if (auth()->id() === $publicacion->user_id)
                <div class="mt-4">
                    <a href="{{ route('publicaciones.edit', $publicacion->id) }}" class="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                        Editar publicación
                    </a>
                </div>
            @endif

            {{-- Interfaz de Me gusta y comentarios (sin funcionalidad todavía) --}}
            <div class="mt-6 border-t pt-4">
                <div class="flex items-center gap-4">
                    <button class="text-blue-500 hover:underline"> Me gusta</button>
                    <button class="text-blue-500 hover:underline">💬 Comentar</button>
                </div>
                <div class="mt-2">
                    <input type="text" class="w-full border rounded-lg p-2 mt-2" placeholder="Escribe un comentario...">
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
