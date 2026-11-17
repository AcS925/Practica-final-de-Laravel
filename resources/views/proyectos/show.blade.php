<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ $titulo ?? 'Proyectos' }}
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white shadow-sm rounded-lg p-6">

        <h3 class="text-2xl font-bold mb-4">
          {{ $proyecto->title }}
        </h3>

        <p class="mb-4">
          {{ $proyecto->description }}
        </p>

        <p class="mb-2">
          <strong>Creador:</strong>
          {{ $proyecto->user->name }}
        </p>

        <p class="mb-2">
          <strong>Fecha límite:</strong>
          {{ $proyecto->due_date?->format('d/m/Y') ?? 'Sin fecha' }}
        </p>

        <p class="mb-4">
          <strong>Estado:</strong>
          {{ $proyecto->status }}
        </p>

        <h4 class="font-bold mt-6 mb-2">
          Participantes
        </h4>

        @forelse ($proyecto->participants as $participante)

          <div class="border-b py-2">
            <p>{{ $participante->name }}</p>

            <p class="text-sm text-gray-600">
              Rol: {{ $participante->pivot->role }}
            </p>

            <p class="text-sm text-gray-600">
              Horas: {{ $participante->pivot->contribution_hours }}
            </p>
          </div>

        @empty

          <p>No hay participantes registrados.</p>

        @endforelse

        @if ($proyecto->user_id === auth()->id() && $usuariosDisponibles->isNotEmpty())

          <h4 class="font-bold mt-6 mb-2">
            Añadir participante
          </h4>

          <form action="{{ route('proyectos.participants.add', $proyecto) }}" method="POST">
            @csrf

            <select name="user_id" class="border-gray-300 rounded-md">
              @foreach ($usuariosDisponibles as $usuario)
                <option value="{{ $usuario->id }}">
                  {{ $usuario->name }}
                </option>
              @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
              Añadir
            </button>
          </form>

        @elseif ($proyecto->user_id === auth()->id())

          <p class="mt-4 text-gray-500">
            No hay más usuarios disponibles.
          </p>

        @endif

        <div class="mt-6">
          <a href="{{ route('proyectos.index') }}" class="text-blue-600">
            Volver a proyectos
          </a>
        </div>

      </div>
    </div>
  </div>
</x-app-layout>