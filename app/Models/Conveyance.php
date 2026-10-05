<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conveyance extends Model
{
    use HasFactory;

    //Relacion 1 a muchos con la tabla elements
    public function elements(){
        return $this->hasMany(Element::class);
    }

        //Relacion 1 a muchos inversa con la tabla ubications
    public function ubications(){
        return $this->hasMany(Ubication::class); //Se debe de llamar explicitamente al nombre de la llave foraneas, en este caso la id de Ubication.
    }

    //Relacion 1 a muchos inversa con la tabla buildings
    public function buildings(){
        return $this->hasMany(Building::class); //Se debe de llamar explicitamente al nombre de la llave foraneas, en este caso la id de Ubication.
    }
}
