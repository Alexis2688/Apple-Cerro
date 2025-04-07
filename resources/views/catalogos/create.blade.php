<x-layout>
    @section('title', 'Creación de Productos - Apple Cell')

    @section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Encabezado -->
        <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-plus-circle text-blue-500 mr-2"></i>
                        Crear Nuevo Producto
                    </h1>
                    <p class="text-gray-500 mt-1">Completa el formulario para agregar un nuevo producto al catálogo</p>
                </div>
                <a href="{{ route('catalogos.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-600 border border-transparent rounded-lg font-semibold text-white hover:from-gray-600 hover:to-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all shadow-md">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Catálogo
                </a>
            </div>
        </div>

        <!-- Mensajes de error -->
        @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
            <div class="flex justify-between items-start">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3 text-xl"></i>
                    <div>
                        <p class="text-red-700 font-medium">¡Error! Hubo problemas con tu formulario.</p>
                        <ul class="list-disc list-inside text-red-600 text-sm mt-1">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button @click="show = false" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        @endif

        <!-- Formulario -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100">
            <form action="{{ route('catalogos.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div class="col-span-2">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre del Producto <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nombre" id="nombre"
                               class="form-input block w-full rounded-lg py-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Ej: iPhone 13 Pro Max"
                               value="{{ old('nombre') }}"
                               required>
                    </div>

                    <!-- Precio -->
                    <div>
                        <label for="precio" class="block text-sm font-medium text-gray-700 mb-1">
                            Precio <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input type="number" name="precio" id="precio"
                                   class="pl-10 form-input block w-full rounded-lg py-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0"
                                   value="{{ old('precio') }}"
                                   required>
                        </div>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                            Cantidad en Stock <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" id="stock"
                               class="form-input block w-full rounded-lg py-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Ej: 10"
                               min="0"
                               value="{{ old('stock', 0) }}"
                               required>
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">
                            Categoría
                        </label>
                        <select name="categoria" id="categoria"
                                class="form-input block w-full rounded-lg py-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccione una categoría</option>
                            <option value="Smartphones" {{ old('categoria') == 'Smartphones' ? 'selected' : '' }}>Smartphones</option>
                            <option value="Accesorios" {{ old('categoria') == 'Accesorios' ? 'selected' : '' }}>Accesorios</option>
                            <option value="Repuestos" {{ old('categoria') == 'Repuestos' ? 'selected' : '' }}>Repuestos</option>
                        </select>
                    </div>

                    <!-- Imagen -->
                    <div class="col-span-2">
                        <label for="imagen" class="block text-sm font-medium text-gray-700 mb-1">
                            Imagen del Producto
                        </label>
                        <input type="file" name="imagen" id="imagen"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-blue-50 file:text-blue-700
                                      hover:file:bg-blue-100"
                               accept="image/*">
                    </div>

                    <!-- Descripción -->
                    <div class="col-span-2">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                            Descripción <span class="text-red-500">*</span>
                        </label>
                        <textarea name="descripcion" id="descripcion"
                                  class="form-input block w-full rounded-lg py-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                  rows="5"
                                  placeholder="Describe las características del producto..."
                                  required>{{ old('descripcion') }}</textarea>
                    </div>
                </div>

                <!-- Botón de enviar -->
                <div class="mt-8 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-lg font-semibold text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-md">
                        <i class="fas fa-save mr-2"></i>
                        Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endsection
</x-layout>
