<x-layout>
    @section('title', 'Registro de Compras - Apple Cell')

    @section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Encabezado con efecto vidrio -->
        <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                        <i class="fas fa-shopping-basket text-blue-500 mr-2"></i>
                        Registro de Compras
                    </h1>
                    <p class="text-gray-500 mt-1">Gestión completa de tus compras y proveedores</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('compras.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-lg font-semibold text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-md">
                        <i class="fas fa-plus mr-2"></i>
                        Nueva Compra
                    </a>
                    <a href="{{ route('compras.facturacion') }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-lg font-semibold text-white hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all shadow-md">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Facturación Diaria
                    </a>
                </div>
            </div>
        </div>

        <!-- Barra de búsqueda y filtros -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
            <form action="{{ route('compras.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" name="search" value="{{ request()->search }}"
                           class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Buscar por modelo, proveedor o fecha...">
                </div>

                <div class="w-full md:w-48">
                    <select name="order" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="desc" {{ request()->order == 'desc' ? 'selected' : '' }}>Más recientes primero</option>
                        <option value="asc" {{ request()->order == 'asc' ? 'selected' : '' }}>Más antiguos primero</option>
                    </select>
                </div>

                <button type="submit"
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow-sm transition-colors">
                    Buscar
                </button>
            </form>
        </div>

        <!-- Formulario para eliminar múltiples compras -->
        <form id="delete-form" action="{{ route('compras.destroyMultiple') }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
            <input type="hidden" name="compras[]" id="compras-input">
        </form>

        <!-- Contenedor principal -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <!-- Acción masiva -->
            <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center">
                    <input type="checkbox" id="select-all"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <label for="select-all" class="ml-2 text-sm text-gray-700">Seleccionar todo</label>
                </div>
                <button type="button" id="eliminar-seleccionados"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg shadow-sm transition-colors flex items-center">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Eliminar Seleccionados
                </button>
            </div>

            <!-- Tabla de compras -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8"></th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modelo</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Proveedor</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Unitario</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($compras as $compra)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="compras[]" value="{{ $compra->id }}"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $compra->cantidad }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-medium text-gray-900">{{ $compra->modelo }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $compra->proveedor }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($compra->estado == 'Completado')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $compra->estado }}
                                </span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    {{ $compra->estado }}
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">${{ number_format($compra->precio, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">${{ number_format($compra->precio * $compra->cantidad, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ \Carbon\Carbon::parse($compra->fecha_creacion)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                <a href="{{ route('compras.edit', $compra->id) }}"
                                   class="text-blue-600 hover:text-blue-900 transition-colors flex items-center"
                                   title="Editar">
                                    <i class="fas fa-edit mr-1"></i>
                                </a>
                                <form action="{{ route('compras.destroy', $compra->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition-colors flex items-center"
                                            onclick="return confirm('¿Estás seguro de eliminar esta compra?')"
                                            title="Eliminar">
                                        <i class="fas fa-trash-alt mr-1"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Resumen y paginación -->
        <div class="mt-6 flex flex-col md:flex-row justify-between items-center">
            <div class="bg-white rounded-lg shadow-sm p-4 mb-4 md:mb-0">
                <h3 class="text-lg font-semibold text-gray-800">
                    Total de Compras: <span class="text-blue-600">${{ number_format($totalCompras ?? 0, 2) }}</span>
                </h3>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-2">
                {{ $compras->links() }}
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Función para actualizar el contador de seleccionados
        function updateSelectedCount() {
            const selectedCount = document.querySelectorAll('tbody input[name="compras[]"]:checked').length;
            const deleteBtn = document.getElementById('eliminar-seleccionados');

            if (selectedCount > 0) {
                deleteBtn.innerHTML = `<i class="fas fa-trash-alt mr-2"></i> Eliminar (${selectedCount})`;
                deleteBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                deleteBtn.classList.add('bg-red-500', 'hover:bg-red-600');
            } else {
                deleteBtn.innerHTML = `<i class="fas fa-trash-alt mr-2"></i> Eliminar Seleccionados`;
                deleteBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                deleteBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
            }
        }

        // Selección múltiple - Versión corregida
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[name="compras[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });

        // Escuchar cambios en los checkboxes individuales
        document.querySelectorAll('tbody input[name="compras[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Actualizar el estado de "Seleccionar todo"
                const allCheckboxes = document.querySelectorAll('tbody input[name="compras[]"]');
                const selectAll = document.getElementById('select-all');
                selectAll.checked = Array.from(allCheckboxes).every(cb => cb.checked);

                updateSelectedCount();
            });
        });

        // Eliminación múltiple con AJAX (manteniendo tu versión actual)
        document.getElementById('eliminar-seleccionados').addEventListener('click', async function() {
            const checkboxes = document.querySelectorAll('tbody input[name="compras[]"]:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);

            if (ids.length === 0) {
                alert('Por favor selecciona al menos una compra');
                return;
            }

            if (confirm(`¿Estás seguro de ocultar ${ids.length} compras del mes actual? Se mantendrán en la base de datos pero no se mostrarán.`)) {
                try {
                    const response = await fetch("{{ route('compras.destroyMultiple') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ compras: ids })
                    });

                    const data = await response.json();

                    if (data.success) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        throw new Error(data.message);
                    }
                } catch (error) {
                    alert('Error: ' + error.message);
                }
            }
        });

        // Inicializar el contador al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            updateSelectedCount();
        });
    </script>
    @endsection
</x-layout>
