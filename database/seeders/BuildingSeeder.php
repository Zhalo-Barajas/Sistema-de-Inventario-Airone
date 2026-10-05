<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creación de seeder para buildings, con los 4 edificios pertenecientes al AAIyA
        Building::create([
            'nameBuilding' => 'Edificio A',
        ]);
        Building::create([
            'nameBuilding' => 'Edificio F',
        ]);
        Building::create([
            'nameBuilding' => 'Edificio H',
        ]);
        Building::create([
            'nameBuilding' => 'Edificio AAIyA',
        ]);
    }
}
