@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Editar publicación</h1>

    <form action="{{ route('publicaciones.update', $publicacion->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl mx-auto">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium text-gray-700 mb-2">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo', $publicacion->titulo) }}"
                class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU @error('titulo') border-red-500 @else border-gray-300 @enderror" required>
            @error('titulo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-2">Descripción</label>
            <textarea name="descripcion" rows="4"
                class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU @error('descripcion') border-red-500 @else border-gray-300 @enderror">{{ old('descripcion', $publicacion->descripcion) }}</textarea>
            @error('descripcion')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-2">Tipo de publicación</label>
            <select name="tipo"
                class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU @error('tipo') border-red-500 @else border-gray-300 @enderror" required>
                <option value="tutorial" {{ old('tipo', $publicacion->tipo) == 'tutorial' ? 'selected' : '' }}>Tutorial</option>
                <option value="video" {{ old('tipo', $publicacion->tipo) == 'video' ? 'selected' : '' }}>Video educativo</option>
                <option value="material" {{ old('tipo', $publicacion->tipo) == 'material' ? 'selected' : '' }}>Material de estudio</option>
                <option value="articulo" {{ old('tipo', $publicacion->tipo) == 'articulo' ? 'selected' : '' }}>Publicación académica</option>
                <option value="evento" {{ old('tipo', $publicacion->tipo) == 'evento' ? 'selected' : '' }}>Evento académico</option>
            </select>
            @error('tipo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-2">Archivo (opcional)</label>
            <input type="file" name="archivo"
                class="w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU @error('archivo') border-red-500 @else border-gray-300 @enderror">

            @if ($publicacion->archivo)
                <p class="text-sm text-gray-500 mt-2">
                    Archivo actual: <a href="{{ asset('storage/' . $publicacion->archivo) }}" target="_blank" class="text-blue-600 underline">Ver archivo</a>
                </p>
            @endif
            @error('archivo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="etiquetas" class="block text-sm font-medium text-gray-700 mb-2">Etiquetas</label>
            <select name="etiquetas[]" id="etiquetas" multiple
                class="mt-1 block w-full border rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU bg-white shadow-md hover:shadow-lg transition duration-300 @error('etiquetas') border-red-500 @else border-gray-300 @enderror">
                @foreach ($etiquetas as $etiqueta)
                    <option value="{{ $etiqueta->id }}"
                        {{ in_array($etiqueta->id, old('etiquetas', $etiquetasSeleccionadas ?? [])) ? 'selected' : '' }}
                        class="p-3 text-gray-700 hover:bg-azulU hover:text-white transition duration-200">
                        {{ $etiqueta->nombre }}
                    </option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Usa Ctrl (Windows) o Cmd (Mac) para seleccionar varias etiquetas.</p>
            @error('etiquetas')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-azulU text-white px-6 py-3 rounded-lg hover:bg-azulU-dark transition duration-200">
            Actualizar publicación
        </button>
    </form>
@endsection
