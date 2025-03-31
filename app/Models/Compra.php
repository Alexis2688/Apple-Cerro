<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    // Definir la tabla asociada al modelo
    protected $table = 'compras';

    // Los campos que son asignables en masa
    protected $fillable = [
        'modelo', 'proveedor', 'cantidad', 'precio', 'estado', 'fecha', 'notas', 'total'
    ];

    // Los campos que no deben ser asignados en masa
    protected $guarded = [];

    // Para habilitar el formato de fechas si es necesario
    protected $dates = ['fecha_compra'];
}
