<?php

namespace Database\Seeders;

use App\Models\computingAtribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class computingAtributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        computingAtribute::create([
            'brand' => 'HP',
            'model' => 'HP Pavilion Slimline s5000 series',
            'serialNumber' => 'MXX0450Z5Z',
            'invNumber' => '00210487',
            "element_id"=>1,
        ]);
    }
}
