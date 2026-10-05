<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    use HasFactory;
    // protected $primaryKey = 'idFund'; ///Asignar nombre de columna de llave primaria. ///NOTA: Descartado en favor de utilizar la convención de Laravel///
    //Relacion 1 a muchos con la tabla elements

    protected $fillable = ['nameFund','slug']; //Habilitación de asignación masiva para estos atributos

    //Relación de 1  muchos con la tabla elements
    public function elements(){
        return $this->hasMany(Element::class);
    }
}
