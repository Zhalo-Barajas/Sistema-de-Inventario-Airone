<?php

namespace App\Livewire;

use App\Models\Category; //Llamada al modelo Category 
use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        return view('livewire.navigation');
        //Retornará la pagina con livewire denominada navigation, el metodo compact es nativo de PHP y devuelve un arreglo con una colección de variables,
        //en este caso la variable $categories esta llamanado al modelo categories y recopilando todos los registros que tiene.
    }
}
