<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraInsumo extends Model
{
    use HasFactory;

    protected $table = 'compras_insumos';

    protected $fillable = [
        'producto',
        'categoria',
        'proveedor',
        'cantidad',
        'precio_unitario',
        'total',
        'fecha_compra',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha_compra' => 'date',
        'precio_unitario' => 'decimal:2',
        'total' => 'decimal:2',
    ];


    // Calcular el total antes de guardar
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->total = $model->cantidad * $model->precio_unitario;
        });
    }

    // Scope para búsqueda
    public function scopeSearch($query, $search)
    {
        return $query->where('producto', 'like', "%$search%")
                    ->orWhere('proveedor', 'like', "%$search%")
                    ->orWhere('categoria', 'like', "%$search%");
    }
}
