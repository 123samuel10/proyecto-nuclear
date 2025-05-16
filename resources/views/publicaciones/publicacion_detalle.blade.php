@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">{{ $publicacion->titulo ?? 'Publicación' }}</h2>

    @if($publicacion->archivo)
        <img src="{{ asset('storage/' . $publicacion->archivo) }}" class="w-full rounded mb-4">
    @endif

    <p class="text-gray-700 mb-2"><strong>Tipo:</strong> {{ $publicacion->tipo }}</p>
    <p class="text-gray-700 mb-2"><strong>Publicado por:</strong> {{ $publicacion->user?->name ?? 'Usuario no disponible' }}</p>
    <p class="text-gray-700 mb-4">{{ $publicacion->descripcion }}</p>

    <div class="mb-4">
        <strong>Etiquetas:</strong>
        @foreach($publicacion->etiquetas as $etiqueta)
            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2">
                {{ $etiqueta->nombre }}
            </span>
        @endforeach
    </div>

    <hr class="my-4">

    <h3 class="text-lg font-semibold mb-2">Comentarios:</h3>
    @foreach($publicacion->comentarios as $comentario)
        <div class="mb-3">
            <strong>{{ $comentario->user?->name ?? 'Anónimo' }}:</strong>
            <span>{{ $comentario->contenido }}</span>
        </div>
    @endforeach

    @auth
    <form action="{{ route('comentarios.store', $publicacion->id) }}" method="POST" class="mt-4">
        @csrf
        <textarea name="contenido" rows="2" class="w-full border rounded p-2" placeholder="Añadir comentario..."></textarea>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700">Comentar</button>
    </form>
    @endauth
</div>
@endsection
