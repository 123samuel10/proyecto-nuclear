@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Editar Publicación</h1>

    <form action="{{ route('publicaciones.update', $publicacion->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="titulo" class="block text-sm font-semibold text-gray-700">Título</label>
            <input type="text" name="titulo" id="titulo" class="mt-1 p-2 w-full border rounded-lg" value="{{ old('titulo', $publicacion->titulo) }}">
        </div>

        <div class="mb-4">
            <label for="descripcion" class="block text-sm font-semibold text-gray-700">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="4" class="mt-1 p-2 w-full border rounded-lg">{{ old('descripcion', $publicacion->descripcion) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="tipo" class="block text-sm font-semibold text-gray-700">Tipo de publicación</label>
            <select name="tipo" id="tipo" class="mt-1 p-2 w-full border rounded-lg">
                <option value="tutorial" {{ old('tipo', $publicacion->tipo) == 'tutorial' ? 'selected' : '' }}>Tutorial</option>
                <option value="video" {{ old('tipo', $publicacion->tipo) == 'video' ? 'selected' : '' }}>Video</option>
                <option value="material" {{ old('tipo', $publicacion->tipo) == 'material' ? 'selected' : '' }}>Material de estudio</option>
                <option value="evento" {{ old('tipo', $publicacion->tipo) == 'evento' ? 'selected' : '' }}>Evento</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="archivo" class="block text-sm font-semibold text-gray-700">Archivo (opcional)</label>
            <input type="file" name="archivo" id="archivo" class="mt-1 p-2 w-full border rounded-lg">
            @if($publicacion->archivo)
                <p class="text-sm text-gray-500 mt-2">Archivo actual: <a href="{{ asset('storage/' . $publicacion->archivo) }}" target="_blank" class="text-blue-600">Ver archivo</a></p>
            @endif
        </div>

        <div class="mb-6">
            <button type="submit" class="bg-azulU text-white px-6 py-2 rounded-lg hover:bg-blue-600">Actualizar publicación</button>
        </div>
    </form>

    <a href="{{ route('bienvenida') }}" class="text-blue-600 underline">Volver a las publicaciones</a>
@endsection
