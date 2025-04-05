<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use Notifiable, HasFactory; // <-- Agregado HasFactory

    protected $fillable = [
        'name', 'email', 'password', 'admin'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'admin' => 'boolean',
    ];

    // Método para verificar si es admin
    public function Admin()
    {
        return $this->admin;
    }
}
