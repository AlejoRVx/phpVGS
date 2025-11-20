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
            'precio' => 37500,
            'descripcion' => 'El videojuego cuenta la historia del Caballero, en su búsqueda para descubrir los secretos del largamente abandonado reino de Hallownest, cuyas profundidades atraen a los aventureros y valientes con la promesa de tesoros o la respuesta a misterios antiguos.',
            'imagen' => 'Hollow Knight.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Terror',
            'nombre' => 'Resident Evil 4 Remake',
            'compania' => 'CAPCOM Co., Ltd.',
            'fecha_lanzamiento' => '2023-03-24',
            'precio' => 121800,
            'descripcion' => 'Resident Evil 4 trata sobre la misión del agente del gobierno estadounidense Leon S. Kennedy para rescatar a Ashley Graham, la hija del presidente, de una misteriosa secta en una zona rural de España.',
            'imagen' => 'Resident Evil 4 Remake.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Accion',
            'nombre' => 'God of War Ragnarök',
            'compania' => 'SIE Santa Monica Studio, Jetpack Interactive.',
            'fecha_lanzamiento' => '2022-11-09',
            'precio' => 219000,
            'descripcion' => 'God of War Ragnarök es un juego de aventura y acción que continúa la historia de Kratos y su hijo Atreus, quienes deben viajar por los Nueve Reinos para evitar el Ragnarök. El juego combina combate visceral con una narrativa madura centrada en la relación padre-hijo y temas de miedo y destino.',
            'imagen' => 'God of War Ragnarök.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Metroidvania',
            'nombre' => 'Hollow Knight Silksong',
            'compania' => 'Team Cherry',
            'fecha_lanzamiento' => '2025-02-14',
            'precio' => 47500,
            'descripcion' => 'Silksong sigue la historia de Hornet mientras asciende a través de un nuevo reino lleno de insectos, trampas y desafíos rápidos.',
            'imagen' => 'Hollow Knight Silksong.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Rolegame',
            'nombre' => 'Hades I',
            'compania' => 'Supergiant Games',
            'fecha_lanzamiento' => '2020-09-17',
            'precio' => 45000,
            'descripcion' => 'Zagreus intenta escapar del inframundo luchando contra hordas de enemigos en este galardonado roguelike lleno de estilo y narrativa.',
            'imagen' => 'Hades I.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Rolegame',
            'nombre' => 'Hades II',
            'compania' => 'Supergiant Games',
            'fecha_lanzamiento' => '2025-12-01',
            'precio' => 70000,
            'descripcion' => 'Melinoë, la princesa del inframundo, emprende una misión épica para enfrentarse a Cronos en esta secuela llena de magia oscura y acción.',
            'imagen' => 'Hades II.gif',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Aventura',
            'nombre' => 'The Legend of Zelda Tears of the Kingdom',
            'compania' => 'Nintendo',
            'fecha_lanzamiento' => '2023-05-12',
            'precio' => 179000,
            'descripcion' => 'Link explora cielos, islas flotantes y tierras renovadas en una aventura masiva llena de libertad y creatividad.',
            'imagen' => 'The Legend of Zelda Tears of the Kingdom.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Accion',
            'nombre' => 'Elden Ring',
            'compania' => 'FromSoftware',
            'fecha_lanzamiento' => '2022-02-25',
            'precio' => 150000,
            'descripcion' => 'Un vasto mundo abierto lleno de desafíos, jefes colosales y una historia escrita en colaboración con George R. R. Martin.',
            'imagen' => 'Elden Ring.gif',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Juego',
            'genero' => 'Aventura',
            'nombre' => 'Spider-Man 2',
            'compania' => 'Insomniac Games',
            'fecha_lanzamiento' => '2023-10-20',
            'precio' => 118000,
            'descripcion' => 'Peter Parker y Miles Morales unen fuerzas para enfrentar a nuevos villanos en una historia llena de acción y exploración en mundo abierto.',
            'imagen' => 'Spider-Man 2.gif',
        ]);

        // Consolas

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Play Station 5',
            'compania' => 'Sony Interactive Entertainment.',
            'fecha_lanzamiento' => '2020-11-19',
            'precio' => 3000000,
            'descripcion' => 'La PlayStation 5 es la consola de última generación de Sony, ofreciendo gráficos 4K, tiempos de carga ultrarrápidos y una nueva experiencia de juego con el mando DualSense.',
            'imagen' => 'Play Station 5.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Xbox Serie X',
            'compania' => 'Microsoft Corporation.',
            'fecha_lanzamiento' => '2020-11-11',
            'precio' => 2600000,
            'descripcion' => 'La Xbox Series X es la consola más potente de Microsoft, ofreciendo gráficos 4K, tiempos de carga rápidos y compatibilidad con una amplia biblioteca de juegos.',
            'imagen' => 'Xbox Serie X.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Nintendo Switch 2',
            'compania' => 'Nintendo.',
            'fecha_lanzamiento' => '2025-06-05',
            'precio' => 2900000,
            'descripcion' => 'La Nintendo Switch 2 es la próxima generación de la popular consola híbrida, ofreciendo mejoras en rendimiento, pantalla y duración de batería.',
            'imagen' => 'Nintendo Switch 2.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Steam Deck OLED',
            'compania' => 'Valve Corporation',
            'fecha_lanzamiento' => '2023-11-16',
            'precio' => 1500000,
            'descripcion' => 'Una versión mejorada con pantalla OLED, mayor batería, menor peso y mejor rendimiento.',
            'imagen' => 'Steam Deck OLED.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'PlayStation 2',
            'compania' => 'Sony Interactive Entertainment',
            'fecha_lanzamiento' => '2000-03-04',
            'precio' => 550000,
            'descripcion' => 'La PlayStation 2 es una de las consolas más exitosas de todos los tiempos, conocida por su amplia biblioteca de juegos y su lector de DVD integrado.',
            'imagen' => 'PlayStation 2.gif',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Xbox Series S Carbon Black',
            'compania' => 'Microsoft',
            'fecha_lanzamiento' => '2023-09-01',
            'precio' => 1800000,
            'descripcion' => 'Edición renovada de la Series S con 1 TB de almacenamiento y acabado en color negro.',
            'imagen' => 'Xbox Series S Carbon Black.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Nintendo Switch OLED',
            'compania' => 'Nintendo',
            'fecha_lanzamiento' => '2021-10-08',
            'precio' => 2100000,
            'descripcion' => 'Pantalla OLED vibrante, mejor audio, soporte ajustable ancho y base con puerto LAN integrado.',
            'imagen' => 'Nintendo Switch OLED.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'ROG Ally',
            'compania' => 'ASUS ROG',
            'fecha_lanzamiento' => '2023-06-13',
            'precio' => 2000000,
            'descripcion' => 'Consola portátil con Windows 11, pantalla 1080p a 120 Hz y chip AMD Z1 Extreme.',
            'imagen' => 'ROG Ally.jpg',
        ]);

        Productos::create([
            'stock' => 100,
            'tipo' => 'Consola',
            'nombre' => 'Atari VCS',
            'compania' => 'Sega Corporation',
            'fecha_lanzamiento' => '2021-05-15',
            'precio' => 600000,
            'descripcion' => 'Una consola retro que combina juegos clásicos de Atari con capacidades modernas de streaming y aplicaciones.',
            'imagen' => 'Atari VCS.jpg',
        ]);

    }
}