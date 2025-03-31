<x-layout>
    @section('title', 'Facturación de Ventas - Por Día')

    @section('content')
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Facturación de Ventas - Por Día</h2>

            <!-- Formulario para filtrar por fecha -->
            <form action="{{ route('ventas.facturacion') }}" method="GET" class="mb-6 flex items-center gap-4">
                <label for="fecha" class="text-sm font-medium">Selecciona una fecha:</label>
                <input type="date" name="fecha" id="fecha" value="{{ request('fecha', \Carbon\Carbon::now()->toDateString()) }}" class="border rounded px-2 py-1">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                    <i class="fas fa-search mr-1"></i> Buscar
                </button>
            </form>

            <!-- Tabla de ventas por fecha -->
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Ventas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($facturacionPorDia as $factura)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($factura->fecha)->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${{ number_format($factura->total, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('ventas.eliminarPorFecha', ['fecha' => $factura->fecha]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-md">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">No se encontraron ventas para esta fecha.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endsection
</x-layout>
