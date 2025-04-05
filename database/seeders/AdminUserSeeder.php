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
            'name' => 'Administrador Alexis',
            'email' => 'danielleites2020@gmail.com',
            'password' => Hash::make('mbappe100'), // Cambia esto en producción
            'admin' => true
        ]);

        User::create([
            'name' => 'Administrador Juan',
            'email' => 'juanleites@gmail.com',
            'password' => Hash::make('juan2025'), // Cambia esto en producción
            'admin' => true
        ]);

        User::create([
            'name' => 'Administrador Miqui',
            'email' => 'miqueasferreira@gmail.com',
            'password' => Hash::make('miqueas2025'), // Cambia esto en producción
            'admin' => true
        ]);
    }
}
