<x-layout>
    @section('title', 'Editar Compra')

    @section('content')
        <x-slot name="title">Editar Compra</x-slot>

        <div class="flex">
            <div class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800">
                        <i class="fas fa-edit mr-2 text-blue-500"></i>
                        Editar Compra #{{ $compra->id }}
                    </h1>
                    <a href="{{ route('compras.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        <span class="hidden md:inline">Volver</span>
                    </a>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <form action="{{ route('compras.update', $compra->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="modelo" class="block text-sm font-medium text-gray-700 mb-2">Modelo</label>
                                <input type="text" name="modelo" id="modelo" required class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $compra->modelo }}">
                                @error('modelo')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="proveedor" class="block text-sm font-medium text-gray-700 mb-2">Proveedor</label>
                                <input type="text" name="proveedor" id="proveedor" required class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $compra->proveedor }}">
                                @error('proveedor')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cantidad" class="block text-sm font-medium text-gray-700 mb-2">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad" min="1" required class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $compra->cantidad }}">
                                @error('cantidad')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="precio_compra" class="block text-sm font-medium text-gray-700 mb-2">Precio de Compra ($)</label>
                                <input type="number" name="precio_compra" id="precio_compra" step="0.01" min="0" required class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $compra->precio_compra }}">
                                @error('precio_compra')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                                <select name="estado" id="estado" required class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="Nuevo" {{ $compra->estado == 'Nuevo' ? 'selected' : '' }}>Nuevo</option>
                                    <option value="Usado" {{ $compra->estado == 'Usado' ? 'selected' : '' }}>Usado</option>
                                    <option value="Reacondicionado" {{ $compra->estado == 'Reacondicionado' ? 'selected' : '' }}>Reacondicionado</option>
                                </select>
                                @error('estado')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fecha_creacion" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Compra</label>
                                <input type="date" name="fecha_creacion" id="fecha_creacion" required class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ \Carbon\Carbon::parse($compra->fecha_creacion)->format('Y-m-d') }}">
                                @error('fecha_creacion')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <label for="notas" class="block text-sm font-medium text-gray-700 mb-2">Notas Adicionales</label>
                            <textarea name="notas" id="notas" rows="3" class="w-full px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $compra->notas }}</textarea>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">
                                Actualizar Compra
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- JavaScript para cálculo automático del total -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cantidadInput = document.getElementById('cantidad');
                const precioInput = document.getElementById('precio_compra');

                function calcularTotal() {
                    const cantidad = parseFloat(cantidadInput.value) || 0;
                    const precio = parseFloat(precioInput.value) || 0;

                    const total = cantidad * precio;

                    // Puedes mostrar el total en algún elemento si lo deseas
                    // document.getElementById('total').textContent = '$' + total.toFixed(2);
                }

                cantidadInput.addEventListener('input', calcularTotal);
                precioInput.addEventListener('input', calcularTotal);

                // Calcular al cargar la página
                calcularTotal();
            });
        </script>
    @endsection
    </x-layout>
