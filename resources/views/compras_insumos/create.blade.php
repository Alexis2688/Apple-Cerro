<x-layout>
    @section('title', 'Nueva Compra de Insumo')

    @section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    <i class="fas fa-cart-plus text-blue-500 mr-2"></i>
                    Registrar Nueva Compra
                </h2>
                <a href="{{ route('compras-insumos.index') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </a>
            </div>

            <form action="{{ route('compras-insumos.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Producto -->
                    <div class="col-span-2">
                        <label for="producto" class="block text-sm font-medium text-gray-700 mb-1">Producto *</label>
                        <input type="text" name="producto" id="producto" required
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Nombre del producto">
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">Categoría *</label>
                        <input type="text" name="categoria" id="categoria" required
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Ej. Oficina, Limpieza, Cocina">
                    </div>

                    <!-- Proveedor -->
                    <div>
                        <label for="proveedor" class="block text-sm font-medium text-gray-700 mb-1">Proveedor *</label>
                        <input type="text" name="proveedor" id="proveedor" required
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Nombre del proveedor">
                    </div>

                    <!-- Cantidad -->
                    <div>
                        <label for="cantidad" class="block text-sm font-medium text-gray-700 mb-1">Cantidad *</label>
                        <input type="number" name="cantidad" id="cantidad" min="1" required
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="0">
                    </div>

                    <!-- Precio Unitario -->
                    <div>
                        <label for="precio_unitario" class="block text-sm font-medium text-gray-700 mb-1">Precio Unitario *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" name="precio_unitario" id="precio_unitario" step="0.01" min="0" required
                                   class="pl-8 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <!-- Fecha de Compra -->
                    <div>
                        <label for="fecha_compra" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Compra *</label>
                        <input type="date" name="fecha_compra" id="fecha_compra" required
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               value="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado *</label>
                        <select name="estado" id="estado" required
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="pendiente">Pendiente</option>
                            <option value="recibido">Recibido</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>

                    <!-- Notas -->
                    <div class="col-span-2">
                        <label for="notas" class="block text-sm font-medium text-gray-700 mb-1">Notas</label>
                        <textarea name="notas" id="notas" rows="3"
                                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                  placeholder="Observaciones adicionales..."></textarea>
                    </div>
                </div>

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('compras-insumos.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow-sm transition-colors">
                        Guardar Compra
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-layout>
