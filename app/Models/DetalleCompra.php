<?php
// app/Models/DetalleCompra.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
    use HasFactory;

    protected $fillable = [
        'compra_id',
        'cantidad',
        'precio_compra'
    ];

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }
}

