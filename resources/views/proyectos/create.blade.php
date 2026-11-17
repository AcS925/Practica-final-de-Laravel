<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Crear proyecto
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

      <div class="bg-white shadow-sm rounded-lg p-6">

        <form action="{{ route('proyectos.store') }}" method="POST">

          @csrf

          <div class="mb-4">
            <label for="title">Título</label>

            <input type="text" id="title" name="title" value="{{ old('title') }}"
              class="block w-full border-gray-300 rounded-md">

            @error('title')
              <p class="text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="description">Descripción</label>

            <textarea id="description" name="description"
              class="block w-full border-gray-300 rounded-md">{{ old('description') }}</textarea>

            @error('description')
              <p class="text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="due_date">Fecha límite</label>

            <input type="date" id="due_date" name="due_date" value="{{ old('due_date') }}"
              class="block w-full border-gray-300 rounded-md">

            @error('due_date')
              <p class="text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="status">Estado</label>

            <select id="status" name="status" class="block w-full border-gray-300 rounded-md">

              <option value="pending">Pendiente</option>
              <option value="in_progress">En progreso</option>
              <option value="completed">Completado</option>

            </select>

            @error('status')
              <p class="text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Guardar proyecto
          </button>

          <a href="{{ route('proyectos.index') }}" class="ml-2 text-gray-600">
            Cancelar
          </a>

        </form>

      </div>
    </div>
  </div>
</x-app-layout>