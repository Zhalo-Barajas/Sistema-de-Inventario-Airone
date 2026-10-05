<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// use App\Observers\ElementObserver;
// use Illuminate\Database\Eloquent\Attributes\ObservedBy;
// #[ObservedBy([ElementObserver::class])]
//Método alternativo para implementar un observer, en este caso directamente al archivo de modelo.

class Element extends Model
{
    use HasFactory;
    // protected $primaryKey = 'idElement'; ///Asignar nombre de columna de llave primaria. ///NOTA: Descartado en favor de utilizar la convención de Laravel///


    protected $guarded = ['id','created_at','updated_at']; 
    //Esta linea selecciona al siguiente conjunto de atributos de la tabla de elements, estos atributos no podrán trabajar con asignación masiva

    //Relacion 1 a muchos inversa con la tabla Categories
    public function category(){ 
        return $this->belongsTo(Category::class); //Se debe de llamar explicitamente al nombre de la llave foraneas, en este caso la id de Category.
    }

    //Relacion 1 a muchos inversa con la tabla fund
    public function funds(){
        return $this->belongsTo(Fund::class); //Se debe de llamar explicitamente al nombre de la llave foraneas, en este caso la id de Fund.
    }

    //Relacion 1 a muchos inversa con la tabla ubications
    public function ubications(){
        return $this->belongsTo(Ubication::class); //Se debe de llamar explicitamente al nombre de la llave foraneas, en este caso la id de Ubication.
    }

    //Relacion 1 a muchos inversa con la tabla buildings
    public function buildings(){
        return $this->belongsTo(Building::class); //Se debe de llamar explicitamente al nombre de la llave foraneas, en este caso la id de Ubication.
    }

    //Relacion 1 a muchos inversa con la tabla buildings
    public function conveyances(){
        return $this->belongsTo(Conveyance::class); //Se debe de llamar explicitamente al nombre de la llave foraneas, en este caso la id de Ubication.
    }

    //Relacion 1 a muchos inversa con la tabla users
    public function users(){
        return $this->belongsTo(User::class);
    }

    //Relacion muchos a muchos con la tabla de tags
    public function tags(){
        return $this->belongsToMany(Tag::class);
    }


///Relaciones de tablas con atributos para categorias

    //Relacion 1 a uno inversa con la tabla computing_atributes
    public function computing_atributes(){
        return $this->belongsTo(computingAtribute::class);
    }

    //Relacion 1 a uno inversa con la tabla furniture_atributes
    public function furniture_atributes(){
        return $this->belongsTo(furnitureAtribute::class);
    }

    //Relacion 1 a uno inversa con la tabla infrastructure_atributes
    public function infrastructure_atributes(){
        return $this->belongsTo(infrastructureAtribute::class);
    }

    //Relacion 1 a uno inversa con la tabla lab_equip_atributes
    public function lab_equip_atributes(){
        return $this->belongsTo(labEquipAtribute::class);
    }

    //Relacion 1 a uno inversa con la tabla machinery_atributes
    public function machinery_atributes(){
        return $this->belongsTo(machineryAtribute::class);
    }

    //Relacion 1 a uno inversa con la tabla sec_equip_atributes
    public function sec_equip_atributes(){
        return $this->belongsTo(secEquipAtribute::class);
    }

//////

//Relacion 1 a uno inversa con la tabla maintenances
public function maintenances(){
    return $this->belongsTo(Maintenance::class);
}

//



    //Relacion uno a uno polimorfica (Imagenes)
    //Con esta relacion definimos que la relacion polimorfica inversa (Que se ubica en el modelo Image puede acceder a los atributos del modelo Element)
    public function image(){
        return $this->morphOne(Image::class,'imageable'); //Se llama al nombre de la relacion en el modelo image ("Imageable");
    }

 //Con esta función le pedimos a Laravel que utilice los slugs de cada elemento para generar sus rutas, no su id
    public function getRouteKeyName(){
        return 'slug';
    }

}

