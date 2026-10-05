<?php

namespace Database\Seeders;

use App\Models\Ubication;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UbicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //10/04: Creación de seeder para tabla ubications
        Ubication::create([
            'nameUbication' => 'Oficinas de Coordinadores',
        ]);
        Ubication::create([
            'nameUbication' => 'Aulas',
        ]);
        Ubication::create([
            'nameUbication' => 'Cubículos de Investigadores',
        ]);
        Ubication::create([
            'nameUbication' => 'Auditorio',
        ]);
        Ubication::create([
            'nameUbication' => 'Jefatura',
        ]);
        Ubication::create([
            'nameUbication' => 'Áreas de Apoyo',
        ]);
        Ubication::create([
            'nameUbication' => 'Laboratorios',
        ]);
        Ubication::create([
            'nameUbication' => 'Bodegas',
        ]);
        Ubication::create([
            'nameUbication' => 'Laboratorios de Cómputo',
        ]);
    }
}
