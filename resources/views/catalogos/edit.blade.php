<x-layout>
    @section('title', 'Editar Producto - Apple Cell')
    @section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Encabezado con efecto vidrio -->
        <div class="bg-white/80 backdrop-blur-md rounded-xl shadow-sm p-6 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        <i class="fas fa-edit text-blue-500 mr-2"></i>
                        Editar Producto
                    </h1>
                    <p class="text-gray-500 mt-1">Actualiza la información del producto en el catálogo</p>
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
        <div x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-2"
             class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg shadow-sm">
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
            <form action="{{ route('catalogos.update', $catalogo->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nombre -->
                    <div class="col-span-2">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                            Nombre del Producto <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-box text-gray-400"></i>
                            </div>
                            <input type="text" name="nombre" id="nombre"
                                   class="pl-10 form-input block w-full rounded-lg py-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Ej: iPhone 13 Pro Max"
                                   value="{{ old('nombre', $catalogo->nombre) }}"
                                   required>
                        </div>
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
                                   value="{{ old('precio', $catalogo->precio) }}"
                                   required>
                        </div>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">
                            Cantidad en Stock <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-layer-group text-gray-400"></i>
                            </div>
                            <input type="number" name="stock" id="stock"
                                   class="pl-10 form-input block w-full rounded-lg py-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                   placeholder="Ej: 10"
                                   min="0"
                                   value="{{ old('stock', $catalogo->stock ?? 0) }}"
                                   required>
                        </div>
                    </div>

                    <!-- Categoría -->
                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">
                            Categoría
                        </label>
                        <select name="categoria" id="categoria"
                                class="form-input block w-full rounded-lg py-3 border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Seleccione una categoría</option>
                            <option value="Smartphones" {{ old('categoria', $catalogo->categoria ?? '') == 'Smartphones' ? 'selected' : '' }}>Smartphones</option>
                            <option value="Accesorios" {{ old('categoria', $catalogo->categoria ?? '') == 'Accesorios' ? 'selected' : '' }}>Accesorios</option>
                            <option value="Repuestos" {{ old('categoria', $catalogo->categoria ?? '') == 'Repuestos' ? 'selected' : '' }}>Repuestos</option>
                        </select>
                    </div>

                    <!-- Imagen -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Imagen del Producto
                        </label>

                        <!-- Vista previa de la imagen actual -->
                        @if($catalogo->imagen_url)
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-2">Imagen actual:</p>
                            <div class="relative w-48 h-48 rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ $catalogo->imagen_url }}" alt="{{ $catalogo->nombre }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                            </div>
                        </div>
                        @endif

                        <!-- Selector de archivos -->
                        <div id="file-upload-container" class="file-upload relative rounded-lg p-6 text-center cursor-pointer">
                            <input type="file" name="imagen" id="imagen"
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                   accept=".jpg, .jpeg, .png">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400"></i>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium text-blue-600">Haz clic para subir</span> o arrastra y suelta
                                </p>
                                <p class="text-xs text-gray-500">JPG, PNG (Máx. 2MB)</p>
                            </div>
                        </div>
                        <div id="file-preview" class="mt-3 hidden">
                            <div class="flex items-center justify-between bg-gray-50 p-3 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-file-image text-blue-500"></i>
                                    <span id="file-name" class="text-sm font-medium"></span>
                                </div>
                                <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
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
                                  required>{{ old('descripcion', $catalogo->descripcion) }}</textarea>
                    </div>
                </div>

                <!-- Botón de enviar -->
                <div class="mt-8 flex justify-end">
                    <button type="submit"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 border border-transparent rounded-lg font-semibold text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all shadow-md">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Manejo de la subida de archivos con preview
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('imagen');
            const fileUploadContainer = document.getElementById('file-upload-container');
            const filePreview = document.getElementById('file-preview');
            const fileName = document.getElementById('file-name');
            const removeFileBtn = document.getElementById('remove-file');

            // Efecto al arrastrar sobre el área
            ['dragenter', 'dragover'].forEach(eventName => {
                fileUploadContainer.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                fileUploadContainer.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                e.preventDefault();
                e.stopPropagation();
                fileUploadContainer.classList.add('dragover');
            }

            function unhighlight(e) {
                e.preventDefault();
                e.stopPropagation();
                fileUploadContainer.classList.remove('dragover');
            }

            // Mostrar preview del archivo seleccionado
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    fileName.textContent = this.files[0].name;
                    filePreview.classList.remove('hidden');
                }
            });

            // Eliminar archivo seleccionado
            removeFileBtn.addEventListener('click', function() {
                fileInput.value = '';
                filePreview.classList.add('hidden');
            });
        });
    </script>
    @endsection
</x-layout>
