<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\computingAtribute;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/// Agregar este facade, creara la ruta/carpeta faltante para donde se almacenaran las imagenes
use Illuminate\Support\Facades\Storage;

use App\Models\Tag;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Storage::deleteDirectory('public/elements'); //Elimina la carpeta donde se almacenan las imagenes
        Storage::makeDirectory('public/elements'); ////Crea la carpeta donde se almacenan las imagenes


        $this->call(RoleSeeder::class); //Llamada a archivo seeder de roles y permisos

        //ESTE CONJUNTO DE LINEAS ES EL ORDEN EN EL QUE SE CREARAN LOS SEEDERS, Iniciar por entidades fuertes y luego entidades debiles
        $this->call(UserSeeder::class); //Llamada al archivo seeder del mismo nombre (UserSeeder)
        $this->call(CategorySeeder::class); //Llamada al archivo seeder CategorySeeder
        Tag::factory(8)->create();
        $this->call(FundSeeder::class); //10/04: Llamada a seeder para la tabla funds
        $this->call(UbicationSeeder::class);
        $this->call(BuildingSeeder::class); //10/04: llamada para seeder de tabla de buildings
        $this->call(ElementSeeder::class);
        $this->call(computingAtributeSeeder::class);
        $this->call(furnitureAtributeSeeder::class);
        $this->call(infrastructureAtributeSeeder::class);
        $this->call(labEquipAtributeSeeder::class);
        $this->call(machineryAtributeSeeder::class);
        $this->call(secEquipAtributeSeeder::class);
        $this->call(ConveyanceSeeder::class);
    }
}
