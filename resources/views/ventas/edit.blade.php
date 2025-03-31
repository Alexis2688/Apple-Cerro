<x-layout>
    @section('content')
    <!-- Formulario de edición de ventas -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Editar Venta</h2>

        <!-- FORMULARIO -->
        <form action="{{ route('ventas.update', $venta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="modelo">
                        Producto
                    </label>
                    <input id="modelo" name="modelo" type="text" value="{{ old('modelo', $venta->modelo) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('modelo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="estado">
                        Estado
                    </label>
                    <select id="estado" name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="nuevo" {{ old('estado', $venta->estado) == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                        <option value="usado" {{ old('estado', $venta->estado) == 'usado' ? 'selected' : '' }}>Usado</option>
                        <option value="reacondicionado" {{ old('estado', $venta->estado) == 'reacondicionado' ? 'selected' : '' }}>Reacondicionado</option>
                    </select>
                    @error('estado')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="precio_venta">
                        Precio de Venta ($)
                    </label>
                    <input id="precio_venta" name="precio_venta" type="number" step="0.01" value="{{ old('precio_venta', $venta->precio_venta) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('precio_venta')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="cantidad">
                        Cantidad
                    </label>
                    <input id="cantidad" name="cantidad" type="number" min="1" value="{{ old('cantidad', $venta->cantidad) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('cantidad')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Estado del Producto (Siempre Vendido) -->
                <input type="hidden" name="stock_venta" value="vendido">

                <!-- Fecha de Creación -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="fecha_creacion">
                        Fecha de Creación
                    </label>
                    <input id="fecha_creacion" name="fecha_creacion" type="date" value="{{ old('fecha_creacion', $venta->fecha_creacion) }}" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('fecha_creacion')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex space-x-2">
                <a href="{{ route('ventas.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                </button>
            </div>
        </form>
        <!-- FIN FORMULARIO -->

    </div>
    @endsection
</x-layout>
