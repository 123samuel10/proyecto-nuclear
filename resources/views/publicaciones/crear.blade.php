@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Crear publicación</h1>

    <form action="{{ route('publicaciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Título</label>
            <input type="text" name="titulo" class="w-full border rounded-lg p-2" required>
        </div>

        <div>
            <label class="block font-medium">Descripción</label>
            <textarea name="descripcion" rows="4" class="w-full border rounded-lg p-2"></textarea>
        </div>

        <div>
            <label class="block font-medium">Tipo de publicación</label>
            <select name="tipo" class="w-full border rounded-lg p-2" required>
                <option value="tutorial">Tutorial</option>
                <option value="video">Video educativo</option>
                <option value="material">Material de estudio</option>
                <option value="articulo">Publicación académica</option>
                <option value="evento">Evento académico</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Archivo (opcional)</label>
            <input type="file" name="archivo" class="w-full border rounded-lg p-2">
        </div>

        <button type="submit" class="bg-azulU text-white px-6 py-2 rounded-lg">
            Publicar
        </button>
    </form>
@endsection
