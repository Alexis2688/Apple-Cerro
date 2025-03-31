<x-layout>
    @section('content')
    <!-- Formulario de registro de ventas -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Registrar Nueva Venta</h2>

        <!-- FORMULARIO -->
        <form action="{{ route('ventas.store') }}" method="POST">
            @csrf <!-- Token de seguridad -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="modelo">
                        Producto
                    </label>
                    <input id="modelo" name="modelo" type="text" value="{{ old('modelo') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ej: iPhone 13 Pro Max" required>
                    @error('modelo')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="estado">
                        Estado
                    </label>
                    <select id="estado" name="estado"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Seleccione...</option>
                        <option value="nuevo" {{ old('estado') == 'nuevo' ? 'selected' : '' }}>Nuevo</option>
                        <option value="usado" {{ old('estado') == 'usado' ? 'selected' : '' }}>Usado</option>
                        <option value="reacondicionado" {{ old('estado') == 'reacondicionado' ? 'selected' : '' }}>Reacondicionado</option>
                    </select>
                    @error('estado')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="precio_venta">
                        Precio de Venta ($)
                    </label>
                    <input id="precio_venta" name="precio_venta" type="number" step="0.01"
                           value="{{ old('precio_venta') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Ej: 1000" required>
                    @error('precio_venta')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="cantidad">
                        Cantidad
                    </label>
                    <input id="cantidad" name="cantidad" type="number" min="1"
                           value="{{ old('cantidad', 1) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('cantidad')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Fecha -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="fecha">
                        Fecha de Venta
                    </label>
                    <input id="fecha" name="fecha" type="date"
                           value="{{ old('fecha', now()->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('fecha')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            <div class="mt-6 flex space-x-2">
                <a href="{{ route('ventas.index') }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-md">
                    <i class="fas fa-plus mr-2"></i> Registrar Venta
                </button>
            </div>
        </form>
        <!-- FIN FORMULARIO -->
    </div>
    @endsection
</x-layout>
