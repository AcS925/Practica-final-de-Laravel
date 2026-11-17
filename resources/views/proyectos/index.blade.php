<x-app-layout>

  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <a href="{{ route('proyectos.mine') }}"
          class="font-bold text-2xl text-gray-900 hover:text-indigo-600 transition">

          <h2>
            Mis proyectos
          </h2>

        </a>

        <p class="text-sm text-gray-500 mt-1">
          Gestiona y consulta tus proyectos.
        </p>
      </div>
    </div>
  </x-slot>

  <div class="min-h-screen bg-gray-50 py-10">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      {{-- Cabecera de la sección --}}
      <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4 p-6">

        <div>
          <h3 class="text-lg font-semibold text-gray-800">
            Todos los proyectos
          </h3>
          <p class="text-sm text-gray-500">
            Consulta el estado y los detalles de cada proyecto.
          </p>
        </div>

        <a href="{{ route('proyectos.create') }}"
          class="inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-grey-700 font-medium px-5 py-3 rounded-lg shadow-sm transition">
          + Crear proyecto
        </a>

      </div>

      {{-- Mensaje de éxito --}}
      @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
          {{ session('success') }}
        </div>
      @endif

      {{-- Listado de proyectos --}}
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        @forelse ($proyectos as $proyecto)

          <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition p-6 flex flex-col">

            {{-- Título y estado --}}
            <div class="flex items-start justify-between gap-3 mb-4">

              <h4 class="text-lg font-bold text-gray-900">
                {{ $proyecto->title }}
              </h4>

              @if ($proyecto->status === 'pending')
                <span class="shrink-0 bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">
                  Pendiente
                </span>
              @elseif ($proyecto->status === 'in_progress')
                <span class="shrink-0 bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                  En progreso
                </span>
              @else
                <span class="shrink-0 bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full">
                  Completado
                </span>
              @endif

            </div>

            {{-- Descripción --}}
            <p class="text-sm text-gray-600 leading-relaxed mb-5">
              {{ Str::limit($proyecto->description, 120) }}
            </p>

            {{-- Información --}}
            <div class="space-y-2 text-sm text-gray-500 mb-6">

              <p>
                <span class="font-medium text-gray-700">
                  Creador:
                </span>
                {{ $proyecto->user->name }}
              </p>

              <p>
                <span class="font-medium text-gray-700">
                  Fecha límite:
                </span>
                {{ $proyecto->due_date?->format('d/m/Y') ?? 'Sin fecha' }}
              </p>

            </div>

            {{-- Acciones --}}
            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center gap-3">

              <a href="{{ route('proyectos.show', $proyecto) }}"
                class="flex-1 text-center bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium text-sm py-2 rounded-lg transition">
                Ver detalles
              </a>

              @if ($proyecto->user_id === auth()->id())

                <a href="{{ route('proyectos.edit', $proyecto) }}"
                  class="text-gray-600 hover:text-indigo-600 text-sm font-medium transition">
                  Editar
                </a>

                <form action="{{ route('proyectos.destroy', $proyecto) }}" method="POST"
                  onsubmit="return confirm('¿Seguro que quieres eliminar este proyecto?')">

                  @csrf
                  @method('DELETE')

                  <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium transition">
                    Eliminar
                  </button>

                </form>

              @endif

            </div>

          </div>

        @empty

          <div class="col-span-full bg-white border border-gray-200 rounded-xl p-16 text-center">

            <h4 class="text-lg font-semibold text-gray-800 mb-2">
              Todavía no hay proyectos
            </h4>

            <p class="text-gray-500 text-sm mb-5">
              Crea tu primer proyecto para empezar a organizar tu trabajo.
            </p>

            <a href="{{ route('proyectos.create') }}"
              class="inline-block bg-indigo-600 hover:bg-indigo-700 text-grey px-5 py-2 rounded-lg transition">
              Crear primer proyecto
            </a>

          </div>

        @endforelse

      </div>

      {{-- Paginación --}}
      <div class="mt-8">
        {{ $proyectos->links() }}
      </div>

    </div>
  </div>

</x-app-layout>