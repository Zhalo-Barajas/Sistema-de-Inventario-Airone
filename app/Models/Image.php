<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    
    protected $fillable = ['url']; //Habilitación de Asignación masiva para la variable url
    //Relacion polimorfica inversa
    public function imageable(){
        return $this->morphTo();
    }
}
