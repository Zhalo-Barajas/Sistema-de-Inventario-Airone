<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PCAttribute;
use App\Models\Element;

class PCAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creación de tabla con atributos de pc con valores en especifico
        PCAttribute::create([

            "model"=>"HP Pavilion",
            "processor"=>"Intel Core i7",
            "RAM"=>"16.00",
            "Hard_Disk"=>"512.00",
            "RAMType"=>"DDR4",
            "HDType"=>"SSD",
            "IPAddr"=>"192.168.100.12",
            "MACAddr"=>"8C:23:4B:55:1C:43",
            "SubnetMask"=>"255.255.255.0",
            "Gateway"=>"192.168.100.1",
            "DNS1"=>"8.8.8.8",
            "DNS2"=>"8.8.4.4",
            ///NOTA: adaptación variables de llave foránea de acuerdo a convencion de laravel ///
            "element_id"=>1,

        ]);

        $contador = Element::where('category_id',1)->count(); 
        //Creación de variable donde se almacenan la cantidad de tuplas en la tabla elements con el valor de idCategory = 1
        //Para lograr esto se llama al modelo Element y se hará un filtrado de acuerdo con la variable de la tabla elements 
        //idCategory, el 1 es la condicional a la que se somete la variable del Modelo y se proyecta el resultado de la consulta en la funcion
        //->count(); 

        PCAttribute::factory($contador)->create(); //Creación de usuarios de acuerdo al factory, creará el numero de tuplas en base a la variable $contador.
        
    }

}
