<x-layout>
    @section('title', 'Detalle de Producto - Apple Cell')
    @section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Encabezado -->
        <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        Detalle del Producto
                    </h1>
                    <p class="text-gray-500 mt-1">Información completa del producto</p>
                </div>
                <a href="{{ route('catalogos.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-600 border border-transparent rounded-lg font-semibold text-white hover:from-gray-600 hover:to-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Catálogo
                </a>
            </div>
        </div>

        <!-- Detalle del producto -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Imagen -->
                <div class="p-6">
                    @if ($catalogo->imagen_url)
                    <div class="relative rounded-lg overflow-hidden border border-gray-200 h-96">
                        <img src="{{ $catalogo->imagen_url }}"
                             alt="{{ $catalogo->nombre }}"
                             class="w-full h-full object-contain">
                    </div>
                    @else
                    <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center rounded-lg">
                        <i class="fas fa-camera text-gray-300 text-5xl"></i>
                    </div>
                    @endif
                </div>

                <!-- Información -->
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $catalogo->nombre }}</h2>
                        <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                            {{ $catalogo->categoria ?? 'General' }}
                        </span>
                    </div>

                    <div class="flex items-center mb-6">
                        <span class="text-3xl font-bold text-gray-900 mr-4">
                            ${{ number_format($catalogo->precio, 2) }}
                        </span>
                        @if($catalogo->stock > 0)
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">
                            <i class="fas fa-check-circle mr-1"></i> Disponible
                        </span>
                        @else
                        <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded-full">
                            <i class="fas fa-times-circle mr-1"></i> Agotado
                        </span>
                        @endif
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Cantidad en stock</h3>
                        <p class="text-lg font-semibold text-gray-800">{{ $catalogo->stock }} unidades</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Descripción</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $catalogo->descripcion }}</p>
                    </div>

                    <div class="flex space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('catalogos.edit', $catalogo->id) }}"
                           class="flex-1 text-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg hover:from-blue-600 hover:to-blue-700">
                            <i class="fas fa-edit mr-2"></i> Editar
                        </a>
                        <form action="{{ route('catalogos.destroy', $catalogo->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('¿Estás seguro de eliminar este producto?')"
                                    class="w-full px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-lg hover:from-red-600 hover:to-red-700">
                                <i class="fas fa-trash-alt mr-2"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-layout>
