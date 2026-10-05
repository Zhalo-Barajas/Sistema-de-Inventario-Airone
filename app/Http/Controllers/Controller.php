<?php

namespace App\Http\Controllers;


//Llamada para utilizar facades que incluyen metodos como authorize(). Esta acción es requerida en laravel 11 debido a que estas fueron removidas del paquete controller default de laravel en favor a usar gates.
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller
{
    //llamada a uso de los facades/traits invocados.
    use AuthorizesRequests;
    use ValidatesRequests;
}
