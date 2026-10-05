<?php

namespace Database\Seeders;

use App\Models\Conveyance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConveyanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Conveyance::create([
            "conveyanceDate" => "2024-05-03",
            "oldBuilding_id" => 3,
            "oldUbication_id" => 2,
            "building_id" => 4,
            "ubication_id" => 3,
            "element_id" => 1

        ]);
    }
}