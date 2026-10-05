<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    // protected $primaryKey = 'idTag'; ///Asignar nombre de columna de llave primaria.

    protected $fillable = ['nameTag','slug','color']; //permitir asignacion masiva a estas columnas de tag

    public function getRouteKeyName()
    {
        return 'slug';
    }



    //Relacion muchos a muchos

    //Correción del nombre de la función que contiene la relación muchos a muchos
    public function elements(){
        return $this->belongsToMany(Element::class);
    }
}
