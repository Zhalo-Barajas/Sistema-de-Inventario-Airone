<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class computingAtribute extends Model
{
    use HasFactory;
    //Habilitada asignación masiva en los siguientes atributos (Con el fin de poder ser importados estos valores a partir de un XLSX)
    protected $fillable = ['element_id','brand','model','serialNumber','invNumber'];

    //Relacion 1 a 1 con la tabla elements
    public function elements(){
        return $this->hasOne(Element::class);
    }
}
