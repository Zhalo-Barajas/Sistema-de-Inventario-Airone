<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //Enlace de la url y almacenamienot de las imagenes a una resolucion de 640x480
            'url' => 'elements/' . $this->faker->unique()->image('public/storage/elements',640,480,null, false) 
            // se retorna para el campo URL una dirección con el siguiente formato: elements/54ec6ba5ba7b920328110f7b436b7b41.png

        ];
    }
}
