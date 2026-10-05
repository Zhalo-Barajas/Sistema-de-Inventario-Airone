<?php

namespace App\Http\Controllers\Admin;

use App\Models\Element;
use App\Models\User;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Conveyance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Este controlador redireccionará a la pagina index de administración (resources\views\admin\index.blade.php)
    public function index() {
        //Variables que contienen registros de estadisticas globales
        $elementsNumber = Element::all()->count();
        $usersNumber = User::all()->count();
        $maintenancesNumber = Maintenance::all()->count();
        $conveyancesNumber = Conveyance::all()->count();

        //Variables que contienen la fecha inicial y final del mes presente.
        $beginMonth = Carbon::now()->startOfMonth()->toDateString();
        $endMonth = Carbon::now()->endOfMonth()->toDateString();

        //Variables que contienen registros de estadisticas mensaules, utilizando las 2 variable anteriores.
        $elementsMonth = Element::whereBetween('created_at', [$beginMonth, $endMonth])->count();
        // $usersMonth = User::whereBetween('created_at', [$beginMonth, $endMonth])->count();
        $maintenancesMonth = Maintenance::whereBetween('created_at', [$beginMonth, $endMonth])->count();
        $conveyancesMonth = Conveyance::whereBetween('created_at', [$beginMonth, $endMonth])->count();

        //Retorno a la vista principal del panel de administración en conjunto a las variables con estadísticas.
        return view('admin.index', compact('elementsNumber','usersNumber','maintenancesNumber','conveyancesNumber','elementsMonth','maintenancesMonth','conveyancesMonth'));
        
    }
}
