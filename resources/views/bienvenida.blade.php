@extends('layouts.app')

@section('content')
<div class="flex">
<!-- Panel principal -->

<div class="w-3/4 p-4 overflow-y-auto flex-grow mx-auto">
    <!-- Aside izquierdo fijo -->
<aside class="w-30 bg-azulU text-white min-h-screen flex flex-col items-center py-8 fixed left-0 top-16 z-20"> <!-- Elimina el z-index si no es necesario -->


    <div class="space-y-8">
        @foreach (['home' => 'Inicio', 'search' => 'Búsqueda', 'compass' => 'Explorar', 'video' => 'Reels', 'paper-plane' => 'Mensajes', 'bell' => 'Notificaciones'] as $icon => $label)
            <a href="#" class="text-white hover:text-gray-300 flex flex-col items-center search-icon" data-icon="{{ $icon }}">
                <i class="fas fa-{{ $icon }} text-2xl"></i>
                <p class="text-sm mt-2">{{ $label }}</p>
            </a>
        @endforeach
        <a href="{{ route('publicaciones.create') }}" class="text-white hover:text-gray-300 flex flex-col items-center">
            <i class="fas fa-plus text-2xl"></i>
            <p class="text-sm mt-2">Crear</p>
        </a>
        <a href="{{ route('ver-perfil') }}" class="text-white hover:text-gray-300 flex flex-col items-center">
            <img src="https://www.w3schools.com/w3images/avatar2.png" alt="Perfil" class="w-12 h-12 rounded-full mt-2">
            <p class="text-sm mt-2">Perfil</p>
        </a>
    </div>
</aside>
    <h1 class="text-2xl font-bold mb-4 text-azulU text-center">Publicaciones</h1>

    @if (session('success'))
        <div class="p-3 bg-green-100 border border-green-300 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        @foreach ($publicaciones as $publicacion)
            <div class="bg-white p-4 rounded-xl shadow hover:shadow-lg transition duration-300 mx-auto max-w-3xl">
                <h2 class="font-semibold text-xl text-azulU">{{ $publicacion->titulo }}</h2>
                <p class="text-xs text-gray-500">
                    Publicado por {{ $publicacion->user->name }} - {{ $publicacion->created_at->diffForHumans() }}
                </p>
                <p class="mt-2 text-gray-700">{{ $publicacion->descripcion }}</p>
                <p class="mt-2 text-xs text-gray-600"><strong>Tipo:</strong> {{ ucfirst($publicacion->tipo) }}</p>

                @if($publicacion->archivo)
                    @php
                        $extension = pathinfo($publicacion->archivo, PATHINFO_EXTENSION);
                    @endphp

                    @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                        <img src="{{ asset('storage/' . $publicacion->archivo) }}" alt="Imagen de publicación" class="mt-4 w-full h-auto rounded-lg shadow-md">
                    @else
                        <a href="{{ asset('storage/' . $publicacion->archivo) }}" target="_blank" class="text-azulU underline mt-4 inline-block hover:text-rojoU transition duration-300 ease-in-out">
                            Ver archivo
                        </a>
                    @endif
                @endif

                @if (auth()->id() === $publicacion->user_id)
                <div class="mt-4 flex justify-end gap-3">
                    <a href="{{ route('publicaciones.edit', $publicacion->id) }}" class="inline-flex items-center px-4 py-2 bg-azulU text-white rounded-lg shadow hover:bg-blue-800 transition duration-300">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>

                    <form action="{{ route('publicaciones.destroy', $publicacion->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-rojoU text-white rounded-lg shadow hover:bg-red-800 transition duration-300">
                            <i class="fas fa-trash mr-1"></i> Eliminar
                        </button>
                    </form>
                </div>
                @endif

                <div class="mt-4 border-t pt-3">
                    <div class="flex items-center gap-4">
                        <button class="text-azulU hover:text-rojoU transition duration-300">Me gusta</button>
                        <button id="comentarios-btn-{{ $publicacion->id }}" class="text-azulU hover:text-rojoU transition duration-300">💬 Comentar</button>
                    </div>

                    <div id="comentarios-container-{{ $publicacion->id }}" class="comentarios-seccion mt-4 hidden">
                        <h3 class="font-semibold text-lg text-azulU">Comentarios:</h3>
                        @foreach ($publicacion->comentarios as $comentario)
                            <div class="mt-2 border p-2 rounded-lg bg-gray-50">
                                <p><strong>{{ $comentario->user->name }}:</strong> {{ $comentario->contenido }}</p>
                                @if (auth()->id() === $comentario->user_id)
                                <div class="mt-2 flex gap-2">
                                    <form action="{{ route('comentarios.update', $comentario->id) }}" method="POST" class="flex-grow flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="text" name="contenido" value="{{ $comentario->contenido }}" class="w-full border rounded px-2 py-1 text-sm">
                                        <button type="submit" class="bg-azulU text-white px-2 py-1 rounded hover:bg-blue-700 text-xs">Guardar</button>
                                    </form>
                                    <form action="{{ route('comentarios.destroy', $comentario->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rojoU text-white px-2 py-1 rounded hover:bg-red-700 text-xs">Eliminar</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        @endforeach

                        <div class="mt-4 border-t pt-3">
                            <form action="{{ route('comentarios.store') }}" method="POST">
                                @csrf
                                <textarea name="contenido" class="w-full border rounded-lg p-3 mt-2 focus:outline-none focus:ring-2 focus:ring-azulU" placeholder="Escribe un comentario..." required></textarea>
                                <input type="hidden" name="publicacion_id" value="{{ $publicacion->id }}">
                                <button type="submit" class="bg-azulU text-white px-4 py-2 mt-3 rounded-lg hover:bg-rojoU transition duration-300">Comentar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>






</div>

<!-- Overlay para cerrar al hacer clic fuera -->
<div id="search-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-10"></div>

<!-- Buscador flotante estilo Instagram -->
<div id="search-modal" class="fixed top-20 left-28 bg-white rounded-lg shadow-lg w-80 p-4 hidden z-20 opacity-0 scale-95 transition-all duration-300 ease-in-out">
    <input type="text" id="search-input" class="w-full border rounded px-3 py-2" placeholder="Buscar usuarios...">
    <div id="search-results" class="mt-4 max-h-60 overflow-y-auto">
        {{-- Resultados se cargarán dinámicamente --}}
    </div>
</div>

<script>
    // Mostrar / ocultar comentarios
    document.querySelectorAll('[id^="comentarios-btn-"]').forEach(button => {
        button.addEventListener('click', () => {
            const publicacionId = button.id.split('-')[2];
            const comentariosContainer = document.getElementById('comentarios-container-' + publicacionId);
            comentariosContainer.classList.toggle('hidden');
        });
    });

    // Buscador tipo Instagram con overlay
    document.querySelectorAll('.search-icon').forEach(icon => {
        if (icon.dataset.icon === 'search') {
            icon.addEventListener('click', () => {
                const modal = document.getElementById('search-modal');
                const overlay = document.getElementById('search-overlay');

                if (modal.classList.contains('hidden')) {
                    modal.classList.remove('hidden');
                    overlay.classList.remove('hidden');
                    setTimeout(() => {
                        modal.classList.add('opacity-100', 'scale-100');
                        modal.classList.remove('opacity-0', 'scale-95');
                    }, 10);
                    document.getElementById('search-input').focus();
                } else {
                    modal.classList.remove('opacity-100', 'scale-100');
                    modal.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        overlay.classList.add('hidden');
                    }, 300);
                }
            });
        }
    });

    // Cerrar buscador al hacer clic en el overlay
    document.getElementById('search-overlay').addEventListener('click', () => {
        const modal = document.getElementById('search-modal');
        const overlay = document.getElementById('search-overlay');
        modal.classList.remove('opacity-100', 'scale-100');
        modal.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            overlay.classList.add('hidden');
        }, 300);
    });

    // Buscar usuarios al escribir
    document.getElementById('search-input').addEventListener('input', async function() {
        const query = this.value;
        const resultsContainer = document.getElementById('search-results');
        if (query.length < 2) {
            resultsContainer.innerHTML = '';
            return;
        }
        const response = await fetch(`{{ route('buscar.usuarios') }}?q=${encodeURIComponent(query)}`);
        const users = await response.json();
        resultsContainer.innerHTML = users.map(user =>
            `<a href="{{ url('perfil') }}/${user.id}" class="p-2 rounded hover:bg-gray-100 flex items-center gap-2">
                <img src="/storage/${user.foto_perfil || 'default-avatar.png'}" class="w-10 h-10 rounded-full">
                <span>${user.name}</span>
            </a>`
        ).join('');
    });
</script>
@endsection
