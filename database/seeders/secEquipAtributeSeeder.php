<?php

namespace Database\Seeders;

use App\Models\secEquipAtribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class secEquipAtributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        secEquipAtribute::create([
            'brand' => 'PROMEX',
            'model' => 'HFC',
            'invNumber' => '00324132',
            'typeExt' => 'PQS Clase ABC',  
            //Eliminado atributo fireType 
            'capacity' => 4,  
            "element_id"=>6,
        ]);

    }
}
