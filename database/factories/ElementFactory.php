<?php

namespace Database\Factories;

//Llamada a modelos del sistema.

use App\Models\Building;
use App\Models\Category;
use App\Models\Fund;
use App\Models\Ubication;
use App\Models\User;


use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;
//LLamada a STR

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Element>
 */
class ElementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameElement = $this->faker->unique()->sentence(); //creacion de frase unica no repetible
        $adquisitionDate = $this->faker->dateTimeThisYear('-1 month'); //Creación de una fecha falsa
        $maintenanceDate = $this->faker->dateTimeThisYear('+1 month'); //Creación de una fecha falsa
        return [
            //
            'nameElement' => $nameElement,
            'slug' => Str::slug($nameElement),
            'adquisitionDate' => $adquisitionDate, //Asignamos la fecha a partir de la variable $adquisitionDate
            'statusInv' => $this->faker->randomElement([1,2]), //Añadida variable las cuál fungira para señalar si un elemento está de alta o baja., Ya no utiliza una variable booleana.
            'maintenanceDate' => $maintenanceDate, //Asignamos la fecha a partir de la variable $maintenanceDate
            'description' => $this->faker->text(250),
            ///NOTA: atributos renombrados para seguir convención de Laravel ///
            'ubication_id' => Ubication::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'user_id' => User::all()->random()->id, 
            'fund_id' => Fund::all()->random()->id, //Asignación aleatoria con una id de la tabla funds
            'building_id' => Building::all()->random()->id //Asignación aleatoria con una id de la tabla funds
        ];
    }
}
