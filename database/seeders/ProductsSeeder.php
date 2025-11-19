<?php

namespace Database\Seeders;

use App\Models\Productos;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
     public function run(): void
    {
        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Metroidvania',
            'nombre' => 'Hollow Knight',
            'compania' => 'Team Cherry',
            'fecha_lanzamiento' => '2017-02-24',
            'precio' => 37500.00,
            'descripcion' => 'El videojuego cuenta la historia del Caballero, en su búsqueda para descubrir los secretos del largamente abandonado reino de Hallownest, cuyas profundidades atraen a los aventureros y valientes con la promesa de tesoros o la respuesta a misterios antiguos.',
            'imagen' => 'imagen4.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Terror',
            'nombre' => 'Resident Evil 4 Remake',
            'compania' => 'CAPCOM Co., Ltd.',
            'fecha_lanzamiento' => '2023-03-24',
            'precio' => 121800.00,
            'descripcion' => 'Resident Evil 4 trata sobre la misión del agente del gobierno estadounidense Leon S. Kennedy para rescatar a Ashley Graham, la hija del presidente, de una misteriosa secta en una zona rural de España.',
            'imagen' => 'imagen5.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Accion',
            'nombre' => 'God of War Ragnarök',
            'compania' => 'SIE Santa Monica Studio, Jetpack Interactive.',
            'fecha_lanzamiento' => '2022-11-09',
            'precio' => 219000.00,
            'descripcion' => 'God of War Ragnarök es un juego de aventura y acción que continúa la historia de Kratos y su hijo Atreus, quienes deben viajar por los Nueve Reinos para evitar el Ragnarök. El juego combina combate visceral con una narrativa madura centrada en la relación padre-hijo y temas de miedo y destino.',
            'imagen' => 'imagen6.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Play Station 5',
            'compania' => 'Sony Interactive Entertainment.',
            'fecha_lanzamiento' => '2020-11-19',
            'precio' => 3000000,
            'descripcion' => 'La PlayStation 5 (PS5) es una consola de videojuegos de nueva generación de Sony que destaca por su rendimiento gráfico, velocidad de carga y audio 3D.',
            'imagen' => 'imagen7.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Xbox Serie X',
            'compania' => 'Microsoft Corporation.',
            'fecha_lanzamiento' => '2020-11-11',
            'precio' => 2600000,
            'descripcion' => 'La Xbox Series X es una consola de alto rendimiento con un procesador Zen 2 de 8 núcleos, una GPU RDNA 2 de 12 teraflops, 16 GB de memoria GDDR6 y un SSD NVMe personalizado de 1 TB.',
            'imagen' => 'imagen8.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Nintendo Switch 2',
            'compania' => 'Nintendo.',
            'fecha_lanzamiento' => '2025-06-05',
            'precio' => 2900000,
            'descripcion' => 'La Nintendo Switch 2 presenta una pantalla más grande de 7,9 pulgadas con resolución Full HD y hasta 120 Hz de tasa de refresco, un procesador NVIDIA más potente, 12 GB de RAM y 256 GB de almacenamiento interno expandible.',
            'imagen' => 'imagen9.jpg',
        ]);
    }
}