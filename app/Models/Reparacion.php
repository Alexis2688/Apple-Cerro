<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparacion extends Model
{
    use HasFactory;

    protected $table = 'reparaciones'; // <- Aquí defines la tabla correcta

    protected $fillable = [
        'modelo',
        'fallas',
        'costo',
        'estado',
        'fecha',
    ];
}
