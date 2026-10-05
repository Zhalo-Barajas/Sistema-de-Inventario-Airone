<?php

namespace Database\Seeders;

use App\Models\Fund;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //10/04: Creación de seeder para fondos
        Fund::create([
            'nameFund' => 'Ingreso Propio',
            'slug' => 'ingreso-propio',
        ]);
        Fund::create([
            'nameFund' => 'Federal Genérico',
            'slug' => 'federal-generico',
        ]);
        Fund::create([
            'nameFund' => 'Estatal Genérico',
            'slug' => 'estatal-generico',
        ]);
        Fund::create([
            'nameFund' => 'PAO',
            'slug' => 'pao',
        ]);
        Fund::create([
            'nameFund' => 'PROMEP/PRODEP',
            'slug' => 'prome-prode',
        ]);
        Fund::create([
            'nameFund' => 'PROFECXE/PIFI',
            'slug' => 'profecxe-pifi',
        ]);
        Fund::create([
            'nameFund' => 'CONAHCYT',
            'slug' => 'conahcyt',
        ]);
        /*Consultar años de los fondos para hacer registros con el siguiente formato:
        Fund::create([
            'nameFund' => 'PROFECXE/PIFI 2020',
        ]);
        Fund::create([
            'nameFund' => 'CONAHCYT 2019',
        ]);
        Fund::create([
            'nameFund' => 'CONAHCYT 2017',
        ]);
            */
    }
}
