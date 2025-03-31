<x-layout>
    @section('title', 'Inicio')

    @section('content')
    <h1 class="text-2xl md:text-3xl font-semibold text-gray-800 mb-6">
        <i class="fas fa-home mr-3 w-5 text-center"></i>
        Inicio
    </h1>

    <!-- Tarjetas de resumen -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8">
        <div class="bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-mobile-alt text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-600">Total Ventas</h2>
                    <p class="text-lg font-semibold text-gray-800">${{ number_format($totalVentas, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-shopping-basket text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-600">Total Compras</h2>
                    <p class="text-lg font-semibold text-gray-800">${{ number_format($totalCompras ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-tools text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-600">Total Reparaciones</h2>
                    <p class="text-lg font-semibold text-gray-800">${{ number_format($totalReparaciones ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 transition-all duration-300 hover:shadow-lg hover:transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-chart-line text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-600">Balance Total</h2>
                    <p class="text-lg font-semibold text-gray-800">${{ number_format($balanceTotal ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bienvenida -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6 mb-6">
        <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-4">Bienvenido a Apple Cerro</h2>
        <p class="text-gray-600 mb-6">Selecciona una opción del menú para comenzar a gestionar tus ventas y reparaciones.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            <!-- Tarjeta Ventas -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-shopping-cart text-blue-500 text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-center text-blue-700">Registrar Venta</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Registra una nueva venta de dispositivo móvil</p>
                <a href="{{ route('ventas.index') }}" class="block mt-4">
                    <button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
                        Registrar
                    </button>
                </a>
            </div>

            <!-- Tarjeta Compras -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200 transition-all duration-300 hover:shadow-lg hover:border-blue-300">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-shopping-basket text-blue-500 text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-center text-blue-700">Registrar Compra</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Registra una nueva compra</p>
                <a href="{{ route('compras.index') }}" class="block mt-4">
                    <button class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
                        Registrar
                    </button>
                </a>
            </div>

            <!-- Tarjeta Reparaciones -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200 transition-all duration-300 hover:shadow-lg hover:border-green-300">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-tools text-green-500 text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-center text-green-700">Registrar Reparación</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Registra una nueva reparación</p>
                <a href="{{ route('reparaciones.index') }}" class="block mt-4">
                    <button class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
                        Registrar
                    </button>
                </a>
            </div>

            <!-- Tarjeta Balance -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-4 border border-purple-200 transition-all duration-300 hover:shadow-lg hover:border-purple-300">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-purple-500 text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-center text-purple-700">Balance Final</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Consulta el balance de ventas y reparaciones</p>
                <a href="{{ route('balance') }}" class="block mt-4">
                    <button class="w-full bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
                        Ver Balance
                    </button>
                </a>
            </div>

            <!-- Tarjeta Catálogos -->
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-lg p-4 border border-indigo-200 transition-all duration-300 hover:shadow-lg hover:border-indigo-300">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-boxes text-indigo-500 text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-center text-indigo-700">Catálogos</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Administra tus productos y modelos</p>
                <a href="{{ route('catalogos.index') }}" class="block mt-4">
                    <button class="w-full bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
                        Administrar
                    </button>
                </a>
            </div>

            <!-- Tarjeta Calculadora -->
            <div class="bg-gradient-to-br from-indigo-300  to-orange-10000 rounded-lg p-4 border border-orange-200 transition-all duration-300 hover:shadow-lg hover:border-orange-300">
                <div class="flex items-center justify-center mb-4">
                    <i class="fas fa-calculator text-orange-500 text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-center text-orange-700">Calculadora</h3>
                <p class="text-sm text-gray-600 text-center mt-2">Herramienta para cálculos rápidos</p>
                <a href="/calculadora" class="block mt-4">
                    <button class="w-full bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white py-2 px-4 rounded-lg shadow-md transition-all duration-300 hover:shadow-lg">
                        Usar Calculadora
                    </button>
                </a>
            </div>
        </div>
    </div>

    <!-- Sección de Operaciones Recientes -->
    <div class="bg-white rounded-lg shadow-md p-4 md:p-6">
        <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-4">Operaciones Recientes</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4 border border-blue-200">
                <h3 class="text-lg font-medium text-blue-700 mb-3 flex items-center">
                    <i class="fas fa-history text-blue-500 mr-2"></i>
                    Operaciones Hoy
                </h3>
                <p class="text-3xl font-bold text-gray-800">{{ $operacionesHoy ?? 0 }}</p>
                <p class="text-sm text-gray-600 mt-2">Transacciones realizadas hoy</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-4 border border-green-200">
                <h3 class="text-lg font-medium text-green-700 mb-3 flex items-center">
                    <i class="fas fa-chart-pie text-green-500 mr-2"></i>
                    Resumen del Mes
                </h3>
                <p class="text-xl font-bold text-gray-800">${{ number_format($balanceTotal ?? 0, 2) }}</p>
                <p class="text-sm text-gray-600 mt-2">Balance general del mes actual</p>
            </div>
        </div>
    </div>

    @endsection
</x-layout>
