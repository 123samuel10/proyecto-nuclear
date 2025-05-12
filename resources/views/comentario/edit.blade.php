@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Comentario</h2>

        <form action="{{ route('comentarios.update', $comentario->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <textarea name="contenido" class="w-full p-3 border rounded-lg" rows="4" required>{{ old('contenido', $comentario->contenido) }}</textarea>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Actualizar Comentario</button>
        </form>
    </div>
@endsection
