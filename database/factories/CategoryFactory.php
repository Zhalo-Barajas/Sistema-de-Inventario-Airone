<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

//Llamada a  STR para utilizar la convesión a slug
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameCategory = $this->faker->unique()->word(20); //Generacion del nombre
        return [
            // Enn este tipo de tablas se crea de manera implicita la tabla idCategory y respectivamente el resto.
            'nameCategory' => $nameCategory,
            'slug' => Str::slug($nameCategory) //La clase importada Str se encarga de generar el slug a partir de la misma variable $nameCategory
        ];

    }
}
