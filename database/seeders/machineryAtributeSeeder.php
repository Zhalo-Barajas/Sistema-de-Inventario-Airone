<?php

namespace Database\Seeders;

use App\Models\machineryAtribute;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class machineryAtributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        machineryAtribute::create([
            'brand' => 'infra',
            'model' => 'E-6011',
            'invNumber' => '00324132',
            'serialNumber' => 'ER4342GT',
            "element_id"=>5,
        ]);
    }
}
