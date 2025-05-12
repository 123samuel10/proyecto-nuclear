@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-10 space-y-10">

    {{-- Sección de cabecera del perfil --}}
    <div class="bg-white p-8 rounded-2xl shadow-lg flex flex-col md:flex-row items-center gap-8 relative">

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
                    <p class="text-2xl font-bold">{{ $user->seguidores_count }}</p>
                    <p class="text-sm text-gray-400">Seguidores</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold">{{ $user->seguidos_count }}</p>
                    <p class="text-sm text-gray-400">Seguidos</p>
                </div>
            </div>
@auth
    @if(auth()->id() !== $user->id)
        <div class="flex gap-4 mt-4">
            <form action="{{ auth()->user()->estaSiguiendo($user->id) ? route('dejarDeSeguir', $user->id) : route('seguir', $user->id) }}" method="POST">
                @csrf
                @if(auth()->user()->estaSiguiendo($user->id))
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 rounded-full text-sm font-semibold shadow-md transition-all
                        bg-gray-300 text-black hover:bg-gray-400">
                        Siguiendo
                    </button>
                @else
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 rounded-full text-sm font-semibold shadow-md transition-all
                        bg-blue-600 text-white hover:bg-blue-700">
                        Seguir
                    </button>
                @endif
            </form>
        </div>
    @endif
@endauth

        </div>

    </div>

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

                        @if($publicacion->archivo)
                            @php
                                $extension = pathinfo($publicacion->archivo, PATHINFO_EXTENSION);
                            @endphp

                            @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                <img src="{{ asset('storage/' . $publicacion->archivo) }}" alt="Imagen de publicación" class="mt-4 w-full h-auto rounded-lg">
                            @else
                                <a href="{{ asset('storage/' . $publicacion->archivo) }}" target="_blank" class="text-blue-600 underline mt-4 inline-block">
                                    Ver archivo
                                </a>
                            @endif
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
