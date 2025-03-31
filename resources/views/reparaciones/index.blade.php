<x-layout>
    @section('title', 'Gestión de Reparaciones - Apple Cell')

    @section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Encabezado con efecto vidrio -->
        <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-tools text-green-500 mr-2"></i>
                        Gestión de Reparaciones
                    </h1>
                    <p class="text-gray-500 mt-1">Registro y seguimiento de todas las reparaciones</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('reparaciones.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 border border-transparent rounded-lg font-semibold text-white hover:from-green-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all shadow-md">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Nueva Reparación
                    </a>
                    <a href="{{ route('reparaciones.facturacion') }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-lg font-semibold text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-md">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                        Facturación del Día
                    </a>
                </div>
            </div>
        </div>

        <!-- Notificación flash -->
        @if (session('success'))
        <div x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg shadow-sm">
            <div class="flex justify-between items-start">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-emerald-500 mr-3 text-xl"></i>
                    <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        <!-- Formulario para eliminación múltiple -->
        <form id="delete-form" action="{{ route('reparaciones.destroyMultiple') }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
            <input type="hidden" name="reparaciones[]" id="reparaciones-input">
        </form>

        <!-- Tabla de reparaciones -->
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
                    Eliminar
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-green-500 to-green-600">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider w-8">
                                <!-- Checkbox header -->
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Modelo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Fallas
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Costo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Fecha
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-white uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $total = 0;
                        @endphp

                        @if ($reparaciones->isEmpty())
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-tools text-4xl text-gray-300 mb-3"></i>
                                    <p class="text-lg font-medium">No hay reparaciones registradas</p>
                                    <p class="text-sm text-gray-500">Comienza agregando una nueva reparación</p>
                                </div>
                            </td>
                        </tr>
                        @else
                            @foreach ($reparaciones as $reparacion)
                            @php
                                $total += $reparacion->costo;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="reparaciones[]" value="{{ $reparacion->id }}"
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $reparacion->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $reparacion->modelo }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                    {{ $reparacion->fallas }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    ${{ number_format($reparacion->costo, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $estadoClasses = [
                                            'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                            'En Proceso' => 'bg-blue-100 text-blue-800',
                                            'Completada' => 'bg-green-100 text-green-800',
                                            'Entregada' => 'bg-purple-100 text-purple-800',
                                            'Cancelada' => 'bg-red-100 text-red-800',
                                        ];
                                        $defaultClass = 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $estadoClasses[$reparacion->estado] ?? $defaultClass }}">
                                        {{ $reparacion->estado }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($reparacion->fecha)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('reparaciones.edit', $reparacion->id) }}"
                                           class="text-blue-500 hover:text-blue-700 transition-colors"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('reparaciones.destroy', $reparacion->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta reparación?')"
                                                    class="text-red-500 hover:text-red-700 transition-colors"
                                                    title="Eliminar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Total acumulado -->
        <div class="mt-6 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl shadow-sm p-6 border border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Resumen Financiero</h2>
                    <p class="text-sm text-gray-500">Total acumulado de todas las reparaciones visibles</p>
                </div>
                <div class="mt-3 md:mt-0">
                    <span class="text-2xl font-bold text-green-600">${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Función para actualizar el contador de seleccionados
        function updateSelectedCount() {
            const selectedCount = document.querySelectorAll('tbody input[name="reparaciones[]"]:checked').length;
            const deleteBtn = document.getElementById('eliminar-seleccionados');

            if (selectedCount > 0) {
                deleteBtn.innerHTML = `<i class="fas fa-trash-alt mr-2"></i> Eliminar (${selectedCount})`;
                deleteBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
                deleteBtn.classList.add('bg-red-500', 'hover:bg-red-600');
            } else {
                deleteBtn.innerHTML = `<i class="fas fa-trash-alt mr-2"></i> Eliminar Seleccionadas`;
                deleteBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
                deleteBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
            }
        }

        // Selección múltiple
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('tbody input[name="reparaciones[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedCount();
        });

        // Escuchar cambios en los checkboxes individuales
        document.querySelectorAll('tbody input[name="reparaciones[]"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                // Actualizar el estado de "Seleccionar todo"
                const allCheckboxes = document.querySelectorAll('tbody input[name="reparaciones[]"]');
                const selectAll = document.getElementById('select-all');
                selectAll.checked = Array.from(allCheckboxes).every(cb => cb.checked);

                updateSelectedCount();
            });
        });

        // Eliminación múltiple con AJAX
        document.getElementById('eliminar-seleccionados').addEventListener('click', async function() {
            const checkboxes = document.querySelectorAll('tbody input[name="reparaciones[]"]:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);

            if (ids.length === 0) {
                alert('Por favor selecciona al menos una reparación');
                return;
            }

            if (confirm(`¿Estás seguro de ocultar ${ids.length} reparaciones del mes actual? Se mantendrán en la base de datos pero no se mostrarán.`)) {
                try {
                    const response = await fetch("{{ route('reparaciones.destroyMultiple') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ reparaciones: ids })
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
