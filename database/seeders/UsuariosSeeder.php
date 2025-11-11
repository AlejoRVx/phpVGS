<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuarios;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuarios::create([
            'correo' => 'admin@gmail.com',
            'contrasena' => Hash::make('admin123'),
            'nombre' => 'Admin',
            'direccion' => 'calle 36',
            'telefono' => '3006584878',
            'rol_id' => 2,
        ]);

        Usuarios::create([
            'correo' => 'user@gmail.com',
            'contrasena' => Hash::make('user123'),
            'nombre' => 'User',
            'direccion' => 'calle 8',
            'telefono' => '3124587898',
            'rol_id' => 1,
        ]);
    }
}
