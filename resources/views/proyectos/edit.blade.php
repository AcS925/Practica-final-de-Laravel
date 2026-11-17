<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Modificar proyecto
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white shadow-sm rounded-lg p-6">

        <form action="{{ route('proyectos.update', $proyecto) }}" method="POST">

          @csrf
          @method('PUT')

          <div class="mb-4">
            <label for="title">Título</label>

            <input type="text" id="title" name="title" value="{{ old('title', $proyecto->title) }}"
              class="block w-full border-gray-300 rounded-md">

            @error('title')
              <p class="text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="description">Descripción</label>

            <textarea id="description" name="description"
              class="block w-full border-gray-300 rounded-md">{{ old('description', $proyecto->description) }}</textarea>

            @error('description')
              <p class="text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="due_date">Fecha límite</label>

            <input type="date" id="due_date" name="due_date"
              value="{{ old('due_date', $proyecto->due_date?->format('Y-m-d')) }}"
              class="block w-full border-gray-300 rounded-md">

            @error('due_date')
              <p class="text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="status">Estado</label>

            <select id="status" name="status" class="block w-full border-gray-300 rounded-md">

              <option value="pending" {{ old('status', $proyecto->status) == 'pending' ? 'selected' : '' }}>
                Pendiente
              </option>

              <option value="in_progress" {{ old('status', $proyecto->status) == 'in_progress' ? 'selected' : '' }}>
                En progreso
              </option>

              <option value="completed" {{ old('status', $proyecto->status) == 'completed' ? 'selected' : '' }}>
                Completado
              </option>

            </select>

            @error('status')
              <p class="text-red-600">{{ $message }}</p>
            @enderror
          </div>

          {{-- Colaboradores --}}
          <div class="mt-8">
            <h3 class="text-lg font-bold mb-4">Colaboradores</h3>

            @forelse ($proyecto->participants as $participante)

              <div class="border rounded-lg p-4 mb-4">

                <h4 class="font-semibold mb-3">
                  {{ $participante->name }}
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                  {{-- Rol --}}
                  <div>
                    <label class="block text-sm font-medium mb-1">
                      Rol
                    </label>

                    <select name="participants[{{ $participante->id }}][role]"
                      class="block w-full border-gray-300 rounded-md">

                      <option value="developer" @selected($participante->pivot->role === 'developer')>
                        Desarrollador
                      </option>

                      <option value="designer" @selected($participante->pivot->role === 'designer')>
                        Diseñador
                      </option>

                      <option value="manager" @selected($participante->pivot->role === 'manager')>
                        Gestor
                      </option>

                    </select>
                  </div>

                  {{-- Horas --}}
                  <div>
                    <label class="block text-sm font-medium mb-1">
                      Horas trabajadas
                    </label>

                    <input type="number" name="participants[{{ $participante->id }}][contribution_hours]"
                      value="{{ old('participants.' . $participante->id . '.contribution_hours', $participante->pivot->contribution_hours) }}"
                      min="0" class="block w-full border-gray-300 rounded-md">
                  </div>

                </div>
              </div>

            @empty
              <p class="text-gray-500">
                Este proyecto todavía no tiene colaboradores.
              </p>
            @endforelse
          </div>

          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Guardar cambios
          </button>

          <a href="{{ route('proyectos.index') }}" class="ml-2 text-gray-600">
            Cancelar
          </a>

        </form>

      </div>
    </div>
  </div>
</x-app-layout>