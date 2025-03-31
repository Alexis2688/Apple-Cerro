<x-layout>
    @section('title', 'Editar Reparación')
    @section('content')

    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-2xl">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-edit text-blue-500 mr-2"></i> Editar Reparación
            </h2>

            <form action="{{ route('reparaciones.update', $reparacion) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-2xl text-black">
                    <!-- Modelo -->
                    <div>
                        <label for="modelo" class="block text-sm font-medium text-gray-100">Modelo</label>
                        <input type="text" name="modelo" id="modelo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" value="{{ old('modelo', $reparacion->modelo) }}" required>
                        @error('modelo')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-100">Estado</label>
                        <select name="estado" id="estado" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-100 text-gray-800">
                            <option value="Pendiente" {{ $reparacion->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="En proceso" {{ $reparacion->estado == 'En proceso' ? 'selected' : '' }}>En proceso</option>
                            <option value="Reparado" {{ $reparacion->estado == 'Reparado' ? 'selected' : '' }}>Reparado</option>
                        </select>
                        @error('estado')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fallas -->
                    <div>
                        <label for="fallas" class="block text-sm font-medium text-gray-100">Fallas</label>
                        <input type="text" name="fallas" id="fallas" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" value="{{ old('fallas', $reparacion->fallas) }}" required>
                        @error('fallas')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Costo -->
                    <div>
                        <label for="costo" class="block text-sm font-medium text-gray-100">Costo</label>
                        <input type="number" name="costo" id="costo" step="0.01" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 text-gray-800" value="{{ old('costo', $reparacion->costo) }}" required>
                        @error('costo')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Fecha -->
                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-100">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 text-gray-800" value="{{ old('fecha', $reparacion->fecha) }}" required>
                        @error('fecha')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center mt-6">
                        <a href="{{ route('reparaciones.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-arrow-left mr-1"></i> Volver
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                            <i class="fas fa-save mr-1"></i> Guardar cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-layout>
