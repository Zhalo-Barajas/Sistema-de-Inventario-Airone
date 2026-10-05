<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    //Relacion 1 a muchos con la tabla elements
    protected $fillable = ['nameBuilding','slug'];
    
    //Relación 1 a muchos con la tabla elements 
    public function elements(){
        return $this->hasMany(Element::class);
    }
}
