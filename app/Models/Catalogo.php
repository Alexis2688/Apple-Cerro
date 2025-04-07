<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    use HasFactory;

    protected $table = 'catalogos';

    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'categoria',
        'descripcion',
        'imagen_url'
    ];
}
