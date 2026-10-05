<?php

namespace Database\Seeders;

use App\Models\labEquipAtribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class labEquipAtributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        labEquipAtribute::create([
            'brand' => 'infra',
            'model' => 'E-6011',
            'invNumber' => '00324132',
            'serialNumber' => 'ER4342GT',
            "element_id"=>4,
        ]);
    }
}
