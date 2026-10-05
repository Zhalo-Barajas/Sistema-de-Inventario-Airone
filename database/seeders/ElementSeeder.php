<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Image;
use App\Models\Element;


class ElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Element::create([

            "nameElement"=> "Computadora HP Slimline",
            "slug"=> "computadora-hp",
            "adquisitionDate" => "2011-03-13",
            'statusInv' => "2",
            "maintenanceDate"=>"2024-03-13",
            "description"=>"Pc Slimline con 4Gb de Ram y Disco Duro de 500GB",
            "ubication_id"=>1,
            "category_id"=>1,
            "user_id"=>1,
            "fund_id"=>1,
            "building_id"=>1,
            //10/04: Agregados atributos restantes para la tabla de elements (En la tupla de prueba)
        ]);

        Element::create([

            "nameElement"=> "Organizador",
            "slug"=> "organizador",
            "adquisitionDate" => "2019-03-13",
            'statusInv' => "2",
            "maintenanceDate"=>"2024-03-13",
            "description"=>"Organizador de 3/4",
            "ubication_id"=>1,
            "category_id"=>2,
            "user_id"=>1,
            "fund_id"=>1,
            "building_id"=>1,
            
        ]);

        Element::create([

            "nameElement"=> "Tablas de madera",
            "slug"=> "tablas-de-madera",
            "adquisitionDate" => "2019-03-13",
            'statusInv' => "2",
            "maintenanceDate"=>"2024-03-13",
            "description"=>"Organizador de 3/4",
            "ubication_id"=>1,
            "category_id"=>3,
            "user_id"=>1,
            "fund_id"=>1,
            "building_id"=>1,
            
        ]);



        Element::create([

            "nameElement"=> "Electrodo",
            "slug"=> "electrodo",
            "adquisitionDate" => "2019-03-13",
            'statusInv' => "2",
            "maintenanceDate"=>"2024-03-13",
            "description"=>"Organizador de 3/4",
            "ubication_id"=>1,
            "category_id"=>4,
            "user_id"=>1,
            "fund_id"=>1,
            "building_id"=>1,
            
        ]);


        Element::create([

            "nameElement"=> "Sierra Truper",
            "slug"=> "sierra-truper",
            "adquisitionDate" => "2019-03-13",
            'statusInv' => "2",
            "maintenanceDate"=>"2024-03-13",
            "description"=>"Organizador de 3/4",
            "ubication_id"=>1,
            "category_id"=>5,
            "user_id"=>1,
            "fund_id"=>1,
            "building_id"=>1,
            
        ]);

        Element::create([

            "nameElement"=> "Extintor32",
            "slug"=> "extintor32",
            "adquisitionDate" => "2019-03-13",
            'statusInv' => "2",
            "maintenanceDate"=>"2024-03-13",
            "description"=>"Extintor 32",
            "ubication_id"=>1,
            "category_id"=>6,
            "user_id"=>1,
            "fund_id"=>1,
            "building_id"=>1,
            
        ]);

        // $Elements = Element::factory(99)->create();

        // Image::factory(1)->create([
        //                 'imageable_id' => 1, //llamada al atributo con la llave primaria del la tabla con la relacion 1 a 1 polimorfica (En este caso elements)
        //                 'imageable_type' => Element::class //Llamada al modelo con el que se relacionará de manera polimorfica
        // ]);

        

        // foreach($Elements as $element){
            
        //     Image::factory(1)->create([
        //         'imageable_id' => $element->id, //llamada al atributo con la llave primaria del la tabla con la relacion 1 a 1 polimorfica (En este caso elements)
        //         'imageable_type' => Element::class //Llamada al modelo con el que se relacionará de manera polimorfica
        //     ]);
        //     //Llamada a la relacion Muchos a mucho tag
        //     $element->tags()->attach([
        //         rand(1,4), //Con esto se agregan 2 tags al azar dentro del rango de las opciones 1 a 4
        //         rand(5,8) //Con esto se agregan 2 tags al azar dentro del rango de las opciones 5 a 8
        //     ]);
        // }

    }
}
