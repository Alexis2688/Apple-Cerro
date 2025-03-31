<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $catalogo->nombre }} - Detalle del Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between mb-4">
                    <h2>Detalle del Producto</h2>
                    <a href="{{ route('catalogos.index') }}" class="btn btn-primary">Volver</a>
                </div>

                <div class="card">
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if ($catalogo->imagen_url)
                            <img src="{{ $catalogo->imagen_url }}" class="img-fluid rounded-start" alt="{{ $catalogo->nombre }}">
                            @else
                            <div class="bg-light text-center py-5 h-100">
                                <p class="text-muted">Sin imagen</p>
                            </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $catalogo->nombre }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${{ number_format($catalogo->precio, 2) }}</h6>
                                <p class="card-text">{{ $catalogo->descripcion }}</p>
                                <p class="card-text"><small class="text-muted">Última actualización: {{ $catalogo->updated_at->format('d/m/Y H:i') }}</small></p>
                                <div class="d-flex">
                                    <a href="{{ route('catalogos.edit', $catalogo->id) }}" class="btn btn-primary me-2">Editar</a>
                                    <form action="{{ route('catalogos.destroy', $catalogo->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
