@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-8 bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">{{ $publicacion->titulo ?? 'Publicación' }}</h2>

   @if($publicacion->archivo)
    @php
        $extension = strtolower(pathinfo($publicacion->archivo, PATHINFO_EXTENSION));
        $rutaArchivo = asset('storage/' . $publicacion->archivo);
    @endphp

    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
        <img src="{{ $rutaArchivo }}" alt="Imagen de publicación" class="w-full rounded mb-4 shadow-md">

    @elseif ($extension === 'pdf')
        <iframe src="{{ $rutaArchivo }}#page=1" width="100%" height="500px" class="w-full rounded mb-4 shadow-md"></iframe>

    @elseif (in_array($extension, ['doc', 'docx']))
        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($rutaArchivo) }}" width="100%" height="500px" frameborder="0" class="w-full rounded mb-4 shadow-md"></iframe>

    @else
        <a href="{{ $rutaArchivo }}" target="_blank" class="text-azulU underline mt-4 inline-block hover:text-rojoU transition duration-300 ease-in-out">
            Ver archivo
        </a>
    @endif
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


{{--
    @auth
    <form action="{{ route('comentarios.store', $publicacion->id) }}" method="POST" class="mt-4">
        @csrf
        <textarea name="contenido" rows="2" class="w-full border rounded p-2" placeholder="Añadir comentario..."></textarea>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 mt-2 rounded hover:bg-blue-700">Comentar</button>
    </form>
    @endauth --}}
</div>
@endsection
