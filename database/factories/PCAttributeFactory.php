<?php

namespace Database\Factories;

use App\Models\Element;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PCAttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         
        return [
            //
            //Estos son atributos de la tabla de pcattributes.
            'model' => $this->faker->word(20),
            'processor' => $this->faker->word(20),
            'RAM' => $this->faker->numberBetween(1,3),
            'Hard_Disk' => $this->faker->numberBetween(1,3),
            'RAMType' => $this->faker->word(20),
            'HDType' => $this->faker->word(20),
            'IPAddr' => $this->faker->word(20),
            'MACAddr' => $this->faker->word(20),
            'SubnetMask' => $this->faker->word(20),
            'Gateway' => $this->faker->word(20),
            'DNS1' => $this->faker->word(20),
            'DNS2' => $this->faker->word(20),

            ///NOTA: atributo renombrado para seguir convención de Laravel ///
            'element_id' => Element::all()->where('category_id',1)->random()->id, 
            //En esta consulta estamos recopilando todos los campos, una vez obtenidos se seleccionan todos aquello con un category_id = 1, de estos registros se tomará un id de la tabla elements de manera aleatoria.
            
        ];
    }
}
