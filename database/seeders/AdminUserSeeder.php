<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'danielleites2020@gmail.com',
            'password' => Hash::make('mbappe100'), // Cambia esto en producción
            'admin' => true
        ]);
    }
}
