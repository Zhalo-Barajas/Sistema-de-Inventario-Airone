<?php

namespace Database\Seeders;

use App\Models\furnitureAtribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class furnitureAtributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        furnitureAtribute::create([
            'color' => 'Indigo',
            'material' => 'tactopiel',
            'dimensions' => '3Mx2.3Mx4M',
            'shelves' => 3,
            'doors'=> 0,
            'serialNumber' => 'MXX0450Z5Z',
            'invNumber' => '00210487',
            "element_id"=>2,
        ]);
         
    }
}
