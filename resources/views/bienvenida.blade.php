@extends('layouts.app')

@section('content')
<div class="flex">
<!-- Panel principal -->

<div class="w-3/4 p-4 overflow-y-auto flex-grow mx-auto">

<!-- Aside izquierdo fijo -->
<aside class="w-20 bg-azulU text-white min-h-screen flex flex-col items-center py-6 fixed left-0 top-16 z-20">

    <div class="space-y-6">
        @foreach (['home' => 'Inicio', 'search' => 'Búsqueda', 'compass' => 'Explorar', 'video' => 'Reels', 'paper-plane' => 'Mensajes'] as $icon => $label)
            <a href="#" class="text-white hover:text-gray-300 flex flex-col items-center text-center search-icon" data-icon="{{ $icon }}">
                <i class="fas fa-{{ $icon }} text-xl"></i>
                <p class="text-[10px] mt-1">{{ $label }}</p>
            </a>
        @endforeach

        <a href="{{ route('publicaciones.create') }}" class="text-white hover:text-gray-300 flex flex-col items-center text-center">
            <i class="fas fa-plus text-xl"></i>
            <p class="text-[10px] mt-1">Crear</p>
        </a>



{{-- TODO NOTIDICACIONESSS --}}
 <a href="#"
   class="relative text-white hover:text-gray-300 flex flex-col items-center text-center search-icon"
   id="abrirModalNotificaciones">

    <i class="fas fa-bell text-xl"></i>
    <p class="text-[10px] mt-1">Notificaciones</p>

    {{-- Contador --}}
    <span id="contador-notificaciones"
          class="absolute top-0 right-0 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center hidden">
    </span>
</a>

<!-- Modal Notificaciones -->
<div id="modalNotificaciones" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50">
  <div class="bg-gray-900 text-white rounded-lg shadow-lg w-96 max-w-full max-h-[80vh] overflow-auto p-6 relative">
    <h2 class="text-2xl font-semibold mb-4">Notificaciones</h2>
    <button id="cerrarModalNotificaciones" class="absolute top-4 right-4 text-gray-300 hover:text-white text-2xl font-bold">
      &times;
    </button>

    <ul id="lista-notificaciones" class="divide-y divide-gray-700">
      <!-- Aquí se inyectan las notificaciones -->
    </ul>

    <p id="sin-notificaciones" class="text-center text-gray-400 mt-4 hidden">No tienes notificaciones nuevas.</p>
  </div>
</div>
{{-- ----------------------------------------------------------}}



      {{-- perfil --}}
    <a href="{{ route('ver-perfil') }}" class="text-white hover:text-gray-300 flex flex-col items-center text-center">
            <img src="https://www.w3schools.com/w3images/avatar2.png" alt="Perfil" class="w-10 h-10 rounded-full mt-1">
            <p class="text-[10px] mt-1">Perfil</p>
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
@if ($publicacion->etiquetas->isNotEmpty())
    <p class="mt-2 text-xs text-gray-600">
        <strong>Etiquetas:</strong>
        @foreach ($publicacion->etiquetas as $etiqueta)
            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1">
                {{ $etiqueta->nombre }}
            </span>
        @endforeach
    </p>
@endif

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
        <iframe src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($rutaArchivo) }}" width="100%" height="500px" frameborder="0" class="mt-4 rounded-lg shadow-md"></iframe>

    @else
        <a href="{{ $rutaArchivo }}" target="_blank" class="text-azulU underline mt-4 inline-block hover:text-rojoU transition duration-300 ease-in-out">
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
                    <div id="publicacion-{{ $publicacion->id }}" class="mb-4 border p-4 rounded">
    <p>{{ $publicacion->contenido }}</p>

    {{-- TODOOO DEL LIKE FUNCIONA HASTA CUANDO RECARGO PAGINA ME SALGO, SOLO SE QUITA CUANDO NO LE DOY ME GUSTA --}}
@php
    $usuario = auth()->user();
    $tieneMeGusta = $publicacion->meGustas->contains('usuario_id', $usuario->id);
@endphp

<button class="btn-me-gusta text-xl {{ $tieneMeGusta ? 'text-red-500' : '' }}" data-id="{{ $publicacion->id }}">
  <i class="{{ $tieneMeGusta ? 'fa-solid' : 'fa-regular' }} fa-heart"></i> Me gusta
</button>
<span
    class="total-me-gustas ml-2 cursor-pointer text-blue-600 underline"
    id="me-gustas-{{ $publicacion->id }}"
    data-id="{{ $publicacion->id }}"
>
    {{ $publicacion->meGustas->count() }} me gusta
</span>

<span
    class="usuarios-me-gusta text-sm text-gray-600 ml-2"
    id="usuarios-{{ $publicacion->id }}"
>
    {{-- Aquí aparecerán los nombres de los usuarios --}}
    @foreach ($publicacion->meGustas as $meGusta)
        {{ $meGusta->usuario->name }}@if (!$loop->last), @endif
    @endforeach
</span>


<div
    class="text-sm text-gray-600 mt-1 usuarios-me-gusta"
    id="usuarios-{{ $publicacion->id }}"
    style="display: none;"
>
    {{-- Aquí aparecerán los usuarios --}}
</div>


  <button id="comentarios-btn-{{ $publicacion->id }}" class="text-azulU hover:text-rojoU transition duration-300">💬 Comentar</button>
</div>


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


{{-- BUSQUEDA --}}
<!-- Overlay para cerrar al hacer clic fuera -->
<div id="search-overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-10"></div>

<!-- Buscador flotante estilo Instagram -->
<div id="search-modal" class="fixed top-20 left-28 bg-white rounded-lg shadow-lg w-96 p-4 hidden z-20 opacity-0 scale-95 transition-all duration-300 ease-in-out max-h-[400px] overflow-y-auto">

    <!-- Botones para elegir tipo de búsqueda -->
    <div class="flex justify-around mb-4">
        <button id="btn-buscar-publicaciones" class="py-2 px-4 bg-azulU text-white rounded">Publicaciones</button>
        <button id="btn-buscar-usuarios" class="py-2 px-4 bg-gray-300 rounded">Usuarios</button>
    </div>

    <input type="text" id="search-input" class="w-full border rounded px-3 py-2" placeholder="Buscar publicaciones por etiqueta...">

    <div id="search-results" class="mt-4 max-h-60 overflow-y-auto">
        {{-- Resultados se cargarán dinámicamente --}}
    </div>
</div>




{{-- modal elimar, crear ,editar --}}
@if (session('publicacion_creada'))
    <div id="modal-exito" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center transition-opacity duration-300">
        <div class="bg-white rounded-xl shadow-xl p-8 max-w-md w-full text-center animate-scale-in">
            <div class="flex justify-center mb-4">
                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold text-green-600 mb-2">¡Éxito!</h2>
            <p class="text-gray-600 mb-6">
                {{ session('mensaje_exito') ?? 'La acción se realizó correctamente.' }}
            </p>
            <button onclick="cerrarModal()" class="bg-azulU hover:bg-azulU-dark text-white font-medium px-5 py-2 rounded-lg transition">
                Aceptar
            </button>
        </div>
    </div>

    <style>
        @keyframes scaleIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }
    </style>

    <script>
        function cerrarModal() {
            document.getElementById('modal-exito').remove();
        }

        // Cierre automático (opcional):
        setTimeout(cerrarModal, 4000);
    </script>
@endif




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

  let tipoBusqueda = 'publicaciones'; // Por defecto

    // Cambiar tipo de búsqueda: Publicaciones o Usuarios
    document.getElementById('btn-buscar-publicaciones').addEventListener('click', () => {
        tipoBusqueda = 'publicaciones';
        document.getElementById('btn-buscar-publicaciones').classList.add('bg-azulU', 'text-white');
        document.getElementById('btn-buscar-publicaciones').classList.remove('bg-gray-300');
        document.getElementById('btn-buscar-usuarios').classList.remove('bg-azulU', 'text-white');
        document.getElementById('btn-buscar-usuarios').classList.add('bg-gray-300');
        document.getElementById('search-input').placeholder = 'Buscar publicaciones por etiqueta...';
        document.getElementById('search-results').innerHTML = '';
        document.getElementById('search-input').focus();
    });

    document.getElementById('btn-buscar-usuarios').addEventListener('click', () => {
        tipoBusqueda = 'usuarios';
        document.getElementById('btn-buscar-usuarios').classList.add('bg-azulU', 'text-white');
        document.getElementById('btn-buscar-usuarios').classList.remove('bg-gray-300');
        document.getElementById('btn-buscar-publicaciones').classList.remove('bg-azulU', 'text-white');
        document.getElementById('btn-buscar-publicaciones').classList.add('bg-gray-300');
        document.getElementById('search-input').placeholder = 'Buscar usuarios por nombre...';
        document.getElementById('search-results').innerHTML = '';
        document.getElementById('search-input').focus();
    });
document.getElementById('search-input').addEventListener('input', async function() {
    const query = this.value.trim();
    const resultsContainer = document.getElementById('search-results');

    if (query.length < 2) {
        resultsContainer.innerHTML = '';
        return;
    }

    let url = '';
    if (tipoBusqueda === 'publicaciones') {
        url = `{{ route('buscar.publicaciones.etiqueta') }}?q=${encodeURIComponent(query)}`;
    } else {
        url = `{{ route('buscar.usuarios') }}?q=${encodeURIComponent(query)}`;
    }

    try {
        const response = await fetch(url);
        if (!response.ok) throw new Error('Error en la búsqueda');
        const data = await response.json();

        if (data.length === 0) {
            resultsContainer.innerHTML = '<p class="text-gray-500">No se encontraron resultados.</p>';
            return;
        }

        if (tipoBusqueda === 'publicaciones') {
            resultsContainer.innerHTML = data.map(pub => `
                <a href="/publicaciones/${pub.id}" class="block p-3 rounded hover:bg-gray-100 border border-transparent hover:border-gray-300 transition mb-3">
                    <h3 class="font-semibold text-azulU">${pub.titulo}</h3>
                    <p class="text-sm text-gray-600 truncate">${pub.descripcion}</p>
                    <p class="text-xs text-gray-500 mt-1">Publicado por ${pub.user_nombre}</p>
                    <p class="mt-1 text-xs">
                        ${pub.etiquetas.map(e => `<span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full mr-1">${e}</span>`).join('')}
                    </p>
                </a>
            `).join('');
        } else {
            //busquedad usuarios
            resultsContainer.innerHTML = data.map(user => `
                <a href="{{ url('perfil') }}/${user.id}" class="p-2 rounded hover:bg-gray-100 flex items-center gap-2">
                    <img src="/storage/${user.foto_perfil || 'default-avatar.png'}" class="w-10 h-10 rounded-full" alt="Foto de perfil de ${user.name}">
                    <span>${user.name}</span>
                </a>
            `).join('');
        }
    } catch (error) {
        resultsContainer.innerHTML = `<p class="text-red-500">Error al buscar.</p>`;
        console.error(error);
    }
});


//me gustas
document.querySelectorAll('.btn-me-gusta').forEach(button => {
    button.addEventListener('click', function () {
        const publicacionId = this.dataset.id;

        fetch(`/me-gusta/${publicacionId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
        .then(response => response.json())
        .then(data => {
            const contador = document.getElementById(`me-gustas-${publicacionId}`);
            contador.textContent = `${data.total} me gusta`;

            const icono = this.querySelector('i');
            if (data.status === 'like') {
                icono.classList.remove('fa-regular');
                icono.classList.add('fa-solid');
                this.classList.add('text-red-500');
            } else {
                icono.classList.remove('fa-solid');
                icono.classList.add('fa-regular');
                this.classList.remove('text-red-500');
            }

            fetch(`/me-gusta/${publicacionId}/usuarios`)
                .then(resp => resp.json())
                .then(usuarios => {
                    const usuariosDiv = document.getElementById(`usuarios-${publicacionId}`);
                    usuariosDiv.textContent = usuarios.join(', ');
                });
        });
    });
});


//notificaciones document.addEventListener("DOMContentLoaded", function () {
// document.addEventListener("DOMContentLoaded", function () {
//     fetch('{{ route('notificaciones.megusta') }}')
//         .then(response => response.json())
//         .then(data => {
//             const contador = document.getElementById('contador-notificaciones');
//             if (data.notificaciones > 0) {
//                 contador.textContent = data.notificaciones;
//                 contador.classList.remove('hidden');
//             } else {
//                 contador.classList.add('hidden');
//             }
//         });
// });
document.addEventListener("DOMContentLoaded", function () {
  const btnAbrir = document.getElementById('abrirModalNotificaciones');
  const modal = document.getElementById('modalNotificaciones');
  const btnCerrar = document.getElementById('cerrarModalNotificaciones');
  const lista = document.getElementById('lista-notificaciones');
  const sinNotis = document.getElementById('sin-notificaciones');
  const contador = document.getElementById('contador-notificaciones');

  async function cargarNotificaciones() {
    try {
      const [respComentarios, respMeGusta, respSeguimiento] = await Promise.all([
        fetch('{{ route("notificaciones.comentarios.lista") }}'),
        fetch('{{ route("notificaciones.lista") }}'),
        fetch('{{ route("notificaciones.seguimiento.lista") }}'),
      ]);

      const [notisComentarios, notisMeGusta, notisSeguimiento] = await Promise.all([
        respComentarios.json(),
        respMeGusta.json(),
        respSeguimiento.json(),
      ]);

      const todasNotificaciones = [
        ...notisComentarios,
        ...notisMeGusta,
        ...notisSeguimiento,
      ];

      todasNotificaciones.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

      lista.innerHTML = '';

      if (todasNotificaciones.length === 0) {
        sinNotis.classList.remove('hidden');
      } else {
        sinNotis.classList.add('hidden');

        todasNotificaciones.forEach(noti => {
          const li = document.createElement('li');
          li.classList.add('py-2');
          li.innerHTML = `
            <p>${noti.mensaje}</p>
            <span class="text-xs text-gray-400">${new Date(noti.fecha).toLocaleString()}</span>
          `;
          lista.appendChild(li);
        });
      }

      // Actualizar contador
      contador.textContent = todasNotificaciones.length;
      contador.classList.toggle('hidden', todasNotificaciones.length === 0);

    } catch (error) {
      console.error('Error cargando notificaciones:', error);
    }
  }

  btnAbrir.addEventListener('click', e => {
    e.preventDefault();
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    cargarNotificaciones();
  });

  btnCerrar.addEventListener('click', () => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  });

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }
  });

  async function actualizarContador() {
    try {
      const [respComentarios, respMeGusta, respSeguimiento] = await Promise.all([
        fetch('{{ route("notificaciones.comentarios") }}'),
        fetch('{{ route("notificaciones.megusta") }}'),
        fetch('{{ route("notificaciones.seguimiento") }}'),
      ]);

      const [dataComentarios, dataMeGusta, dataSeguimiento] = await Promise.all([
        respComentarios.json(),
        respMeGusta.json(),
        respSeguimiento.json(),
      ]);

      const total = dataComentarios.notificaciones + dataMeGusta.notificaciones + dataSeguimiento.notificaciones;

      contador.textContent = total;
      contador.classList.toggle('hidden', total === 0);
    } catch (error) {
      console.error('Error actualizando contador:', error);
    }
  }

  actualizarContador();
});



</script>
@endsection
