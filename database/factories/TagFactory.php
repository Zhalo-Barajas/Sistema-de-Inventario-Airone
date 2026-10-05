<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nameTag = $this->faker->unique()->word(20);
        return [
            //
                'nameTag' => $nameTag,
                'slug' => Str::slug($nameTag),
                'color' => $this->faker->randomElement(['red', 'yellow', 'green', 'blue', 'indigo', 'purple',' pink']) //Añadido seeder de colores aleatorios para color de los posts
            
    
        ];
    }
}
