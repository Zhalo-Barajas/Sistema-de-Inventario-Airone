<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // protected $primaryKey = 'idCategory'; ///Asignar nombre de columna de llave primaria. ///NOTA: Descartado en favor de utilizar la convención de Laravel///


    protected $fillable = ['nameCategory','slug']; 
    //HAblitación de asignación masiva a los campos nameCategory y slug de los datos enviados para la tabla categorias

    //Esta funcion permite que en lugar de retornar a la URL el ID de la categoria, el Slug de la categoria.
    public function getRouteKeyName()
    {
        return 'slug';
    }


    //Relacion 1 a muchos con la tabla elements
    public function elements(){
        return $this->hasMany(Element::class);
    }

}
