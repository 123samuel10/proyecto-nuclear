@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Crear publicación</h1>

    <form action="{{ route('publicaciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 max-w-3xl mx-auto">
        @csrf

        <div>
            <label class="block font-medium text-gray-700 mb-2">Título</label>
            <input type="text" name="titulo" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-2">Descripción</label>
            <textarea name="descripcion" rows="4" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU"></textarea>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-2">Tipo de publicación</label>
            <select name="tipo" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU" required>
                <option value="tutorial">Tutorial</option>
                <option value="video">Video educativo</option>
                <option value="material">Material de estudio</option>
                <option value="articulo">Publicación académica</option>
                <option value="evento">Evento académico</option>
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-700 mb-2">Archivo (opcional)</label>
            <input type="file" name="archivo" class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU">
        </div>

        <div>
            <label for="etiquetas" class="block text-sm font-medium text-gray-700 mb-2">Etiquetas</label>
            <select name="etiquetas[]" id="etiquetas" multiple class="mt-1 block w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-azulU focus:border-azulU bg-white shadow-md hover:shadow-lg transition duration-300">
                @foreach ($etiquetas as $etiqueta)
                    <option value="{{ $etiqueta->id }}" class="p-3 text-gray-700 hover:bg-azulU hover:text-white transition duration-200">{{ $etiqueta->nombre }}</option>
                @endforeach
            </select>
            <p class="text-xs text-gray-500 mt-1">Usa Ctrl (Windows) o Cmd (Mac) para seleccionar varias etiquetas.</p>
        </div>

        <button type="submit" class="bg-azulU text-white px-6 py-3 rounded-lg hover:bg-azulU-dark transition duration-200">
            Publicar
        </button>
    </form>
@endsection
