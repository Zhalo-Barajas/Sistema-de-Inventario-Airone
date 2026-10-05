<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\computingAtribute;
use App\Models\Maintenance;
use App\Models\Ubication;
use App\Models\Element;
use App\Models\furnitureAtribute;
use App\Models\infrastructureAtribute;
use App\Models\labEquipAtribute;
use App\Models\machineryAtribute;
use App\Models\secEquipAtribute;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class MaintenanceController extends Controller implements HasMiddleware
{
    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de un metodo constructor)
    {
        //Middleware para comprobar si un usuario puede acceder o no a la vista función de este controlador.
        return [
            
            new Middleware(middleware: 'can:admin.maintenances.index', only: ['index']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador
            new Middleware(middleware: 'can:admin.maintenances.create', only: ['create','store']),
            new Middleware(middleware: 'can:admin.maintenances.print', only: ['print']),

        ];

    }


    public function index()
    {
        //Creación de variable con JOIN que recopilará todos los registros de mantenimiento y el nombre los elementos.
        $viewMaintenances = Maintenance::join('elements', 'maintenances.element_id', '=', 'elements.id')
        ->select('maintenances.*', 'elements.nameElement as nameElement')
        ->get();

        $maintenances = Maintenance::all();

        //retorno a la vista index con la variable $viewMaintenances
        return view('admin.maintenances.index',compact('viewMaintenances'));
    }

    public function create(Request $request)
    {
        //vista para crear un  registro de mantenimiento, esta vista podra ser accesida desde la vista de listado de lementos en el sistema.
        $element = Element::findOrFail($request->id);
        return view('admin.maintenances.create',compact('element'));
    }

    public function store(Request $request)
    {
        //Reglas de validación para el registro de mantenimiento
        $request->validate([
            'maintenanceDescription' => 'required|string|max:2000',
            'maintenanceDate' => 'required|date|after_or_equal:oldMaintenanceDate',  //la regla after_or_equal:oldMaintenanceDate se encarga de corroborar que la fecha NO sea anterior a la de la fecha de mantenimiento anterior.
            'oldMaintenanceDate' => 'required|date', //before_or_equal
            'element_id' => 'required',
        ], [
            'maintenanceDescription.required' => 'La descripción del mantenimiento es obligatoria.',
            'maintenanceDescription.string' => 'La descripción del mantenimiento debe ser una cadena de texto.',
            'maintenanceDescription.max' => 'La descripción del mantenimiento no debe exceder los 2000 caracteres.',
            'maintenanceDate.required' => 'La fecha del mantenimiento es obligatoria.',
            'maintenanceDate.date' => 'La fecha del mantenimiento debe ser una fecha válida.',
            'maintenanceDate.after_or_equal' => 'La fecha del mantenimiento no puede ser anterior a la fecha del último mantenimiento.',
            'oldMaintenanceDate.required' => 'La fecha del último mantenimiento es obligatoria.',
            'oldMaintenanceDate.date' => 'La fecha del último mantenimiento debe ser una fecha válida.',
            'element_id.required' => 'El elemento es obligatorio.',
        ]
        );


        $element = Element::find($request->element_id);
        $element->maintenanceDate = $request->maintenanceDate;
        $element->save();


        //creación del nuevo registro  de mantenimiento
        $maintenance = new Maintenance();
        $maintenance->maintenanceDescription = $request->maintenanceDescription;
        $maintenance->maintenanceDate = $request->maintenanceDate;
        $maintenance->oldMaintenanceDate = $request->oldMaintenanceDate;
        $maintenance->element_id = $request->element_id;
        $maintenance->save();

        

        // return $maintenance;

        //Retorno a vista index de mantenimientos con mensaje de éxito.
        return redirect()->route('admin.maintenances.index')->with('info', 'El registro se ha creado con éxito');

    }

    //nota: Laravel de manera automatica al momento de declarar el modelo utilizará el id de la petición que enviamos para recuperar la variable.
    public function print(Maintenance $maintenance)
    {
        //Recuperación de registro en tabla elementes con el ID
        $element = Element::find($maintenance->element_id);

        //Recopilación de datos de ubicaicones y edificios.
        $buildings = Building::all();
        $ubications = Ubication::all();

        //Switch case encargado de recopilar atributos adicionales en caso de existir.
        switch ($element->category_id){
            case "1":
                $atributes = computingAtribute::where('element_id', $element->id)->first();
                break;
            case "2":
                $atributes = furnitureAtribute::where('element_id', $element->id)->first();
                break;   
            case "3":
                $atributes = infrastructureAtribute::where('element_id', $element->id)->first();
                break; 
            case "4":
                $atributes = labEquipAtribute::where('element_id', $element->id)->first();
                break; 
            case "5":
                $atributes = machineryAtribute::where('element_id', $element->id)->first();
                break; 
            case "6":
                $atributes = secEquipAtribute::where('element_id', $element->id)->first();
                break; 
            default:
                break;    
        }

        //Llamada a localización en español para Carbon
        setlocale(LC_TIME, 'es_ES');
        //Recopilación de la fecha actual y del mes (En letras y español, para el documento).
        $month = Carbon::now()->locale('es_ES')->monthName;
        
        //llamada a vista con el codigo HTML para desplegar página con el documento.
        $pdf = PDF::loadView('admin.maintenances.print',['element'=>$element,'maintenance'=>$maintenance, 'atributes'=>$atributes, 'buildings' =>$buildings,'ubications' =>$ubications, 'month' => $month])->setPaper('letter');
        // $pdf -> loadHTML('{{$element}}');
        //Retorno de pagina de previsualización del documento.
        //Retorno del documento para imprimir con el nombre dentro del paréntesis
        return $pdf->stream('Reporte_Elemento_'.$element->id.'.pdf');
        // return view('admin.maintenances.print',compact('element','maintenance'));
    }
}
