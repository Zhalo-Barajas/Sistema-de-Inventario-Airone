<?php

namespace Database\Seeders;

use App\Models\User; //Llamada al modelo user
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use HasRoles;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        //Creación de usuario con valores en especifico
        User::create([
            'name' => 'Diego Ángel Barajas',
            'email' => 'zhalobarajas@gmail.com',
            'password' => bcrypt('Azura743')
        ])->assignRole('Administrador');

        //->assignRole('Admin');  La llamada a esta función hace que se asigne al usuario que creamos uno de los roles que fueron creados en el seeder de roles

        User::factory(9)->create(); //Creación de usuarios de acuerdo al factory
    }
}
