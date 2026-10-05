<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubication extends Model
{
    use HasFactory;
    // protected $primaryKey = 'idUbication'; ///Asignar nombre de columna de llave primaria. ///NOTA: Descartado en favor de utilizar la convención de Laravel///

    //Relacion 1 a muchos con la tabla elements
    public function elements(){
        return $this->hasMany(Element::class);
    }
    
}
