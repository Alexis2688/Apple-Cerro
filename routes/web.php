<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReparacionController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\BalanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompraInsumoController;

use App\Http\Controllers\ProfileController;

// Ruta raíz redirige al login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas públicas (sin autenticación)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Rutas protegidas (requieren autenticación y ser admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/inicio', [VentaController::class, 'inicio'])->name('inicio');
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Inicio Route::get('/inicio', [VentaController::class, 'inicio'])->name('inicio');

    // Calculadora
    Route::get('/calculadora', function () {
        return view('calculadora');
    })->name('calculadora');

    // Ventas
    Route::resource('ventas', VentaController::class);
    Route::post('/ventas/delete-multiple', [VentaController::class, 'destroyMultiple'])->name('ventas.destroyMultiple');
    Route::get('/venta/facturacion', [VentaController::class, 'facturacion'])->name('ventas.facturacion');
    Route::delete('ventas/facturacion/{fecha}', [VentaController::class, 'eliminarPorFecha'])->name('ventas.eliminarPorFecha');

    // Reparaciones
    Route::resource('reparaciones', ReparacionController::class)->parameters([
        'reparaciones' => 'reparacion'
    ]);
    Route::post('/reparaciones/destroy-multiple', [ReparacionController::class, 'destroyMultiple'])
         ->name('reparaciones.destroyMultiple');
    Route::get('/facturacion', [ReparacionController::class, 'facturacion'])->name('reparaciones.facturacion');

    // Compras
    Route::prefix('compras')->group(function () {
        Route::get('/', [CompraController::class, 'index'])->name('compras.index');
        Route::get('/create', [CompraController::class, 'create'])->name('compras.create');
        Route::post('/', [CompraController::class, 'store'])->name('compras.store');
        Route::get('/{compra}/edit', [CompraController::class, 'edit'])->name('compras.edit');
        Route::put('/{compra}', [CompraController::class, 'update'])->name('compras.update');
        Route::delete('/{compra}', [CompraController::class, 'destroy'])->name('compras.destroy');
        Route::post('/destroy-multiple', [CompraController::class, 'destroyMultiple'])->name('compras.destroyMultiple');
        Route::get('/facturacion', [CompraController::class, 'facturacion'])->name('compras.facturacion');
    });

    // Catálogos
    Route::resource('catalogos', CatalogoController::class);

    // Balance
    Route::get('/balance', [BalanceController::class, 'index'])->name('balance');

    Route::resource('compras-insumos', CompraInsumoController::class)->except(['show']);
    Route::post('compras-insumos/destroy-multiple', [CompraInsumoController::class, 'destroyMultiple'])
        ->name('compras-insumos.destroy-multiple');
});
