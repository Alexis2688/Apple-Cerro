<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'modelo',
        'estado',
        'precio_venta',
        'cantidad',
        'total',
        'fecha_creacion'
    ];

    protected $casts = [
        'precio_venta' => 'decimal:2',
        'fecha_creacion' => 'date',
    ];
}
