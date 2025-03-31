<x-layout>
    @section('title', 'Balance - Apple Cell')

    @section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Encabezado -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                Balance Mensual
            </h1>
            <p class="text-gray-500 mt-1">Resumen financiero del mes actual</p>
        </div>

        <!-- Selector de mes y año -->
        <div class="bg-white rounded-lg shadow-sm p-4 mb-6 border border-gray-200">
            <form method="GET" action="{{ route('balance') }}" class="flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Mes</label>
                    <select id="month" name="month" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3" selected>Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
                <div class="flex-1">
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Año</label>
                    <select id="year" name="year" class="block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025" selected>2025</option>
                    </select>
                </div>
                <div class="self-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 w-full sm:w-auto">
                        Mostrar
                    </button>
                </div>
            </form>
        </div>

        <!-- Totales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Ventas -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-600">Total Ventas</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($totalVentas, 2) }}</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-shopping-cart text-blue-600"></i>
                    </div>
                </div>
            </div>

            <!-- Compras -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-600">Total Compras</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($totalCompras, 2) }}</h3>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-shopping-basket text-purple-600"></i>
                    </div>
                </div>
            </div>

            <!-- Reparaciones -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-600">Total Reparaciones</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($totalReparaciones, 2) }}</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-tools text-green-600"></i>
                    </div>
                </div>
            </div>

            <!-- Ganancia Neta -->
            <div class="bg-white rounded-lg shadow-sm p-6 border border-indigo-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-indigo-600">Ganancia Neta</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-2">${{ number_format($gananciaNeta, 2) }}</h3>
                        <p class="text-xs text-gray-500 mt-2">(Ventas + Reparaciones) - Compras</p>
                    </div>
                    <div class="bg-indigo-100 p-3 rounded-full">
                        <i class="fas fa-hand-holding-usd text-indigo-600"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fórmula de cálculo -->
        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
            <h3 class="text-lg font-medium text-gray-800 mb-2">Fórmula de Ganancia:</h3>
            <div class="flex items-center justify-center space-x-4">
                <div class="text-center">
                    <div class="bg-blue-100 text-blue-800 p-2 rounded-lg">Ventas</div>
                    <span class="text-2xl font-bold">${{ number_format($totalVentas, 2) }}</span>
                </div>
                <span class="text-2xl">+</span>
                <div class="text-center">
                    <div class="bg-green-100 text-green-800 p-2 rounded-lg">Reparaciones</div>
                    <span class="text-2xl font-bold">${{ number_format($totalReparaciones, 2) }}</span>
                </div>
                <span class="text-2xl">-</span>
                <div class="text-center">
                    <div class="bg-purple-100 text-purple-800 p-2 rounded-lg">Compras</div>
                    <span class="text-2xl font-bold">${{ number_format($totalCompras, 2) }}</span>
                </div>
                <span class="text-2xl">=</span>
                <div class="text-center">
                    <div class="bg-indigo-100 text-indigo-800 p-2 rounded-lg">Ganancia</div>
                    <span class="text-2xl font-bold">${{ number_format($gananciaNeta, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-layout>
