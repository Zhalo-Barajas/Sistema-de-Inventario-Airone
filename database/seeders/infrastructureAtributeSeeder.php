<?php

namespace Database\Seeders;

use App\Models\infrastructureAtribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class infrastructureAtributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        infrastructureAtribute::create([
            'material' => 'madera',
            'dimensions' => '1Mx1Mx1m',
            'color' => 'castaño',
            'quantity' => 30,
            "element_id"=>3,
        ]);
            
    }
}
