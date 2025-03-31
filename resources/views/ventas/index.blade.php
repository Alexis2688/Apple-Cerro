<x-layout>
    @section('title', 'Registro de Ventas - Apple Cell')

    @section('content')
    <div class="min-h-screen bg-gray-50">
        <!-- Header móvil -->
        <div class="lg:hidden bg-gradient-to-r from-blue-800 to-blue-900 text-white px-4 py-3 flex items-center justify-between shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-mobile-alt text-blue-300 text-2xl"></i>
                <span class="text-white text-xl mx-2 font-semibold">Apple Cell</span>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Encabezado con acciones -->
            <div class="bg-white/90 backdrop-blur-sm rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                            <i class="fas fa-shopping-cart text-blue-500 mr-3"></i>
                            Registro de Ventas
                        </h1>
                        <p class="text-gray-500 mt-1">Gestión completa de transacciones comerciales</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('ventas.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-lg font-semibold text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-md">
                            <i class="fas fa-plus mr-2"></i>
                            Nueva Venta
                        </a>
                        <a href="{{ route('ventas.facturacion') }}"
                           class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-lg font-semibold text-white hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all shadow-md">
                            <i class="fas fa-file-invoice mr-2"></i>
                            Facturación
                        </a>
                    </div>
                </div>
            </div>

            <!-- Barra de búsqueda y filtros -->
            <div class="bg-white rounded-xl shadow-sm p-4 mb-6 border border-gray-100">
                <form action="{{ route('ventas.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" name="search" value="{{ request()->search }}"
                               class="pl-10 w-full rounded-lg py-2 border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Buscar por modelo, fecha...">
                    </div>

                    <select name="order" class="rounded-lg py-2 border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="desc" {{ request()->order == 'desc' ? 'selected' : '' }}>Más recientes</option>
                        <option value="asc" {{ request()->order == 'asc' ? 'selected' : '' }}>Más antiguos</option>
                    </select>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg flex items-center justify-center transition-colors">
                        <i class="fas fa-search mr-2"></i>
                        Buscar
                    </button>
                </form>
            </div>

            <!-- Acciones masivas -->
            <div class="flex justify-between items-center mb-4">
                <button id="eliminar-seleccionados"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg flex items-center transition-colors shadow-sm">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Eliminar Seleccionados
                </button>

                <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-lg font-semibold">
                    <i class="fas fa-chart-line mr-2"></i>
                    Total: ${{ number_format($totalVentas ?? 0, 2) }}
                </div>
            </div>

            <!-- Tabla de ventas -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" id="select-all" class="rounded text-blue-500 focus:ring-blue-500">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modelo</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($ventas as $venta)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="ventas[]" value="{{ $venta->id }}"
                                           class="rounded text-blue-500 focus:ring-blue-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $venta->cantidad }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $venta->modelo }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                          {{ $venta->estado == 'Completado' ? 'bg-green-100 text-green-800' :
                                             ($venta->estado == 'Pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $venta->estado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($venta->precio_venta, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    ${{ number_format($venta->precio_venta * $venta->cantidad, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($venta->fecha_creacion)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('ventas.edit', $venta->id) }}"
                                           class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>
                                        </a>
                                        <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST"
                                              onsubmit="return confirm('¿Confirmas eliminar esta venta?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <!-- Paginación -->
            <div class="mt-6">
                {{ $ventas->links('vendor.pagination.tailwind') }}
            </div> --}}
        </div>
    </div>

    <!-- JavaScript Corregido -->
    <script>
        // Selección de todos los checkboxes
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[name="ventas[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Eliminación múltiple con AJAX
        document.getElementById('eliminar-seleccionados').addEventListener('click', async function() {
    const checkboxes = document.querySelectorAll('tbody input[name="ventas[]"]:checked');
    const ids = Array.from(checkboxes).map(cb => cb.value);

    if (ids.length === 0) {
        alert('Por favor selecciona al menos una venta');
        return;
    }

    if (confirm(`¿Estás seguro de ocultar ${ids.length} ventas del mes actual? Se mantendrán en la base de datos pero no se mostrarán.`)) {
        try {
            const response = await fetch("{{ route('ventas.destroyMultiple') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ ventas: ids })
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
    </script>
    @endsection
</x-layout>
