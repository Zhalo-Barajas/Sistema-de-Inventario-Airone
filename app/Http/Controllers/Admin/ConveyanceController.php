<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Conveyance;
use App\Models\Element;
use App\Models\Ubication;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ConveyanceController extends Controller implements HasMiddleware
{

    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de unnn metodo constructor)
    {
        return [
            
            new Middleware(middleware: 'can:admin.conveyances.index', only: ['index']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador,

        ];

        /*
            Ejemplo de comando de middleware de Laravel 10 a 11
            new Middleware(middleware: 'auth:sanctum', except: ['index', 'show']), //Laravel 11
            $this->middleware('auth:sanctum')->except(['index', 'show']); //Laravel 10
        */
    }
    //En este la pagin a index se encargará de mostrar los registros de traspasos dentro del sistema.
    public function index()
    {
        //Variable que contiene una recopilación de todos los registros.
        $conveyances = Conveyance::all();
        //Recopilación de edificos en variable $buildings
        $buildings = Building::all();
        //Recopilación de ubicaciones en variable $ubications
        $ubications = Ubication::all();

        /*La Variable viewConveyances consiste de una llamada al modelo Conveyance, estallamada hará que dentro
          de la variable se recopilen los atributos comunes de la tabla, de conveyances, a continuación se recopilará
          mediante 2 joins la tabla elements y la tabla buildings,, a partir de estos joins por medio de la función select()
          se recopilararán todos los atributos de la tabla conveyances (con conveyances.*), el atributo nameElement (elements.nameElement as nameElement)
          namebuilding ('buildings.nameBuilding as nameBuilding') y finalmente nameUbication ('ubications.nameUbication as nameUbication')
         */
        $viewConveyances = Conveyance::join('elements', 'conveyances.element_id', '=', 'elements.id')->join('buildings', 'conveyances.building_id', '=', 'buildings.id')->join('ubications', 'conveyances.ubication_id', '=', 'ubications.id')
                                       ->select('conveyances.*', 'elements.nameElement as nameElement', 'buildings.nameBuilding as nameBuilding', 'ubications.nameUbication as nameUbication',)
                                       ->get();

        // return $viewConveyances; //Depuración

        //Finalmente se retorna la vista con todos los atributos generados en esta función del contorlador.
        return view('admin.conveyances.index',compact('conveyances','buildings','ubications','viewConveyances'));

    }
}
