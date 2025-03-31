<x-layout>
    @section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6 flex items-center">
            <i class="fas fa-file-invoice-dollar text-blue-500 mr-2"></i> Facturación por día
        </h1>

        <!-- Formulario para elegir la fecha -->
        <form action="{{ route('reparaciones.facturacion') }}" method="GET" class="mb-6">
            <div class="flex items-center gap-4">
                <label for="fecha" class="font-semibold">Selecciona una fecha:</label>
                <input type="date" id="fecha" name="fecha" value="{{ request('fecha', \Carbon\Carbon::now()->toDateString()) }}" class="border rounded px-2 py-1">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    <i class="fas fa-search mr-1"></i> Consultar
                </button>
            </div>
        </form>

        <p class="mb-4 text-lg">
            <strong>Fecha seleccionada:</strong> {{ \Carbon\Carbon::parse($fechaSeleccionada)->format('d/m/Y') }}
        </p>

        <!-- Tabla de reparaciones -->
        <table class="min-w-full bg-white rounded shadow mb-4">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="py-2 px-4">ID</th>
                    <th class="py-2 px-4">Modelo</th>
                    <th class="py-2 px-4">Fallas</th>
                    <th class="py-2 px-4">Costo</th>
                    <th class="py-2 px-4">Estado</th>
                </tr>
            </thead>
            <tbody>
                @if ($reparaciones->isEmpty())
                    <tr>
                        <td colspan="5" class="py-4 px-4 text-center text-gray-500">
                            No hay reparaciones registradas para esta fecha.
                        </td>
                    </tr>
                @else
                    @foreach ($reparaciones as $reparacion)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-2 px-4">{{ $reparacion->id }}</td>
                        <td class="py-2 px-4">{{ $reparacion->modelo }}</td>
                        <td class="py-2 px-4">{{ $reparacion->fallas }}</td>
                        <td class="py-2 px-4">${{ number_format($reparacion->costo, 2) }}</td>
                        <td class="py-2 px-4">{{ $reparacion->estado }}</td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Total -->
        <div class="p-4 bg-gray-100 rounded shadow">
            <h2 class="text-xl font-semibold">Total facturado: ${{ number_format($totalFacturado, 2) }}</h2>
        </div>

        <!-- Botón para volver -->
        <div class="mt-4">
            <a href="{{ route('reparaciones.index') }}" class="inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                <i class="fas fa-arrow-left mr-1"></i> Volver a Reparaciones
            </a>
        </div>
    </div>
    @endsection
</x-layout>
