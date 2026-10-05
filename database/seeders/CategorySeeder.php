<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        //10/04: Agregadas categorias solicitadas.
        //seeder especializado para categorias principales del sistema.
        Category::create([
            'nameCategory' => 'Computación',
            'slug' => 'computacion',
        ]);
        Category::create([
            'nameCategory' => 'Inmobiliario',
            'slug' => 'inmobiliario',
        ]);
        Category::create([
            'nameCategory' => 'Infraestructura',
            'slug' => 'infraestructura',
        ]);
        Category::create([
            'nameCategory' => 'Equipo de Laboratorio',
            'slug' => 'equipo-de-laboratorio',
        ]);
        Category::create([
            'nameCategory' => 'Maquinaria',
            'slug' => 'maquinaria',
        ]);
        Category::create([
            'nameCategory' => 'Equipo de Seguridad',
            'slug' => 'equipo-de-seguridad',
        ]);
    }
}
