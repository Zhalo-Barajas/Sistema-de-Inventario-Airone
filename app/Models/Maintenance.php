<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    //Relacion 1 a muchos con la tabla elements
    public function elements(){
        return $this->hasMany(Element::class);
    }
}
