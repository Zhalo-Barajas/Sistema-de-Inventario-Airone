<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; //Llamada a STR

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ubication>
 */
class UbicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameUbication = $this->faker->unique()->word(20); //Generacion del nombre
        return [
            //
            'nameUbication' => $nameUbication,
            'slug' => Str::slug($nameUbication)
        ];
    }
}
