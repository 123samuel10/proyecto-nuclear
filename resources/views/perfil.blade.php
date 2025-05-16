@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 space-y-10">

    {{-- Sección de cabecera del perfil --}}
    <div class="bg-white p-8 rounded-2xl shadow-lg flex flex-col md:flex-row items-center gap-8 relative">

        {{-- Botones de acciones (arriba a la derecha) --}}
        <div class="absolute top-6 right-6 flex gap-4">
            {{-- Botón Volver a Bienvenida --}}
            <a href="{{ route('bienvenida') }}"
               class="inline-flex items-center gap-2 bg-azulU text-white text-xs font-semibold px-5 py-2 rounded-full shadow-lg transition-all duration-300 hover:bg-white hover:text-azulU hover:border hover:border-azulU hover:shadow-2xl transform hover:-translate-y-1">
                <i class="fas fa-home"></i>
                Inicio
            </a>

            {{-- Botón Cerrar Sesión --}}
            <a href="{{ route('logout') }}"
               class="inline-flex items-center gap-2 bg-red-500 text-white text-xs font-semibold px-5 py-2 rounded-full shadow-lg transition-all duration-300 hover:bg-white hover:text-red-500 hover:border hover:border-red-500 hover:shadow-2xl transform hover:-translate-y-1">
                <i class="fas fa-sign-out-alt"></i>
                Cerrar sesión
            </a>
        </div>

        {{-- Foto de perfil --}}
        <div class="relative">
            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-azulU shadow-lg">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=300" alt="Foto de perfil" class="w-full h-full object-cover">
            </div>
        </div>

        {{-- Información del usuario --}}
        <div class="flex-1 text-center md:text-left">
            <h1 class="text-3xl font-extrabold text-gray-800">{{ $user->name }}</h1>
            <p class="text-gray-500 mt-2">{{ $user->email }}</p>

            <div class="flex justify-center md:justify-start gap-10 mt-6 text-gray-700">
                <div class="text-center">
                    <p class="text-2xl font-bold">{{ $misPublicaciones->count() }}</p>
                    <p class="text-sm text-gray-400">Publicaciones</p>
                </div>
<div class="text-center">
    <p class="text-2xl font-bold">{{ $seguidoresCount }}</p>
    <p class="text-sm text-gray-400">Seguidores</p>
</div>
<div class="text-center">
    <p class="text-2xl font-bold">{{ $seguidosCount }}</p>
    <p class="text-sm text-gray-400">Seguidos</p>
</div>


            </div>
        </div>

    </div>

    {{-- Sección de publicaciones --}}
{{-- Sección de publicaciones --}}
<div class="bg-white p-8 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Mis Publicaciones</h2>

    @if($misPublicaciones->isEmpty())
        <p class="text-gray-400 text-center">Todavía no has publicado nada.</p>
    @else
        <div class="space-y-6">
@foreach ($misPublicaciones as $publicacion)
    <div class="bg-gray-50 p-6 rounded-xl shadow-sm hover:shadow-md transition">
        <h3 class="font-semibold text-lg text-gray-800">{{ $publicacion->titulo }}</h3>
        <p class="text-sm text-gray-500 mb-1">{{ $publicacion->created_at->diffForHumans() }}</p>
        <p class="mt-2 text-gray-700">{{ $publicacion->descripcion }}</p>
        <p class="mt-2 text-sm text-gray-600"><strong>Tipo:</strong> {{ ucfirst($publicacion->tipo) }}</p>

        {{-- Mostrar etiquetas si hay --}}
        @if ($publicacion->etiquetas->isNotEmpty())
            <p class="mt-2 text-sm text-gray-600">
                <strong>Etiquetas:</strong>
                @foreach ($publicacion->etiquetas as $etiqueta)
                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1">
                        {{ $etiqueta->nombre }}
                    </span>
                @endforeach
            </p>
        @endif

   {{-- Mostrar imagen, PDF, Word u otro archivo --}}
@if($publicacion->archivo)
    @php
        $extension = strtolower(pathinfo($publicacion->archivo, PATHINFO_EXTENSION));
        $rutaArchivo = asset('storage/' . $publicacion->archivo);
    @endphp

    @if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
        <img src="{{ $rutaArchivo }}" alt="Imagen de publicación" class="mt-4 w-full h-auto rounded-lg shadow-md">

    @elseif ($extension === 'pdf')
        <iframe src="{{ $rutaArchivo }}#page=1" width="100%" height="500px" class="mt-4 rounded-lg shadow-md"></iframe>

    @elseif (in_array($extension, ['doc', 'docx']))
        <a href="{{ $rutaArchivo }}" target="_blank" download class="text-blue-600 underline mt-4 inline-block hover:text-blue-800 transition">
            Descargar archivo Word
        </a>

    @else
        <a href="{{ $rutaArchivo }}" target="_blank" class="text-blue-600 underline mt-4 inline-block hover:text-blue-800 transition">
            Ver archivo
        </a>
    @endif
@endif

    </div>
@endforeach

        </div>
    @endif
</div>


    {{-- Botón Editar Perfil --}}
    <div class="mt-4 flex justify-center md:justify-start">
        <a href="{{ route('perfil.editar') }}"
           class="inline-flex items-center gap-2 bg-azulU text-white text-sm font-semibold px-6 py-3 rounded-full shadow-lg transition-all duration-300 hover:bg-white hover:text-azulU hover:border hover:border-azulU hover:shadow-2xl transform hover:-translate-y-1">
            <i class="fas fa-user-edit"></i>
            Editar Perfil
        </a>
    </div>

</div>
@endsection
