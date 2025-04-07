<x-layout>
    @section('title', 'Catálogo de Productos - Apple Cell')

    @section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Encabezado -->
        <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-boxes text-blue-500 mr-2"></i>
                        Catálogo de Productos
                    </h1>
                    <p class="text-gray-500 mt-1">Gestiona tu inventario de productos</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Barra de búsqueda -->
                    <form action="{{ route('catalogos.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4 w-full">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   class="bg-white border border-gray-300 rounded-lg pl-10 pr-4 py-2 w-full focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Buscar productos...">
                            @if(request('search'))
                            <a href="{{ route('catalogos.index') }}"
                               class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                        </div>

                        <select name="disponibilidad" class="bg-white border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos</option>
                            <option value="disponible" {{ request('disponibilidad') == 'disponible' ? 'selected' : '' }}>Disponibles</option>
                            <option value="agotado" {{ request('disponibilidad') == 'agotado' ? 'selected' : '' }}>Agotados</option>
                        </select>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                            <i class="fas fa-filter mr-1"></i> Filtrar
                        </button>
                    </form>

                    <a href="{{ route('catalogos.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-lg font-semibold text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-md">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Nuevo Producto
                    </a>
                </div>
            </div>
        </div>

        <!-- Notificación flash -->
        @if ($message = Session::get('success'))
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
                    <p class="text-emerald-700 font-medium">{{ $message }}</p>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        <!-- Grid de productos -->
        @if($catalogos->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($catalogos as $catalogo)
            <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 group">
                <!-- Imagen del producto -->
                <div class="relative overflow-hidden h-56">
                    @if ($catalogo->imagen_url)
                    <img src="{{ $catalogo->imagen_url }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                         alt="{{ $catalogo->nombre }}">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <i class="fas fa-camera text-gray-300 text-4xl"></i>
                    </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                </div>

                <!-- Contenido de la tarjeta -->
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-gray-800 truncate">{{ $catalogo->nombre }}</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                            {{ $catalogo->categoria ?? 'General' }}
                        </span>
                    </div>

                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $catalogo->descripcion }}</p>

                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xl font-bold text-gray-900">
                            ${{ number_format($catalogo->precio, 2) }}
                        </span>
                        <div class="flex flex-col items-end">
                            @if($catalogo->stock > 0)
                            <span class="text-sm font-medium text-green-600">
                                <i class="fas fa-check-circle mr-1"></i> Disponible
                            </span>
                            <span class="text-xs text-gray-500">{{ $catalogo->stock }} unidades</span>
                            @else
                            <span class="text-sm font-medium text-red-600">
                                <i class="fas fa-times-circle mr-1"></i> Agotado
                            </span>
                            <span class="text-xs text-gray-500">0 unidades</span>
                            @endif
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex space-x-2">
                        <a href="{{ route('catalogos.show', $catalogo->id) }}"
                           class="flex-1 text-center px-3 py-2 text-sm font-medium text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-700 rounded-lg transition-colors">
                            <i class="fas fa-eye mr-1"></i> Ver
                        </a>
                        <a href="{{ route('catalogos.edit', $catalogo->id) }}"
                           class="flex-1 text-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-edit mr-1"></i> Editar
                        </a>
                        <form action="{{ route('catalogos.destroy', $catalogo->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('¿Estás seguro de eliminar este producto?')"
                                    class="w-full px-3 py-2 text-sm font-medium text-red-700 hover:text-white border border-red-700 hover:bg-red-700 rounded-lg transition-colors">
                                <i class="fas fa-trash-alt mr-1"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-100">
            <i class="fas fa-box-open text-4xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-700 mb-2">No se encontraron productos</h3>
            <p class="text-gray-500 mb-4">No hay productos que coincidan con tu búsqueda o filtros</p>
            <a href="{{ route('catalogos.index') }}" class="text-blue-500 hover:text-blue-700 font-medium">
                <i class="fas fa-undo mr-1"></i> Limpiar filtros
            </a>
        </div>
        @endif
    </div>
    @endsection
</x-layout>
