<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use Illuminate\Http\Request;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; //Invocación de controladores para middleware


class FundController extends Controller implements HasMiddleware // Es necesario para poder utilizar middleware declarar en nuestra clase del controlador "implements HasMiddleware" a partir de laravel 11

{
    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de unnn metodo constructor)
    {
        return [
            
            new Middleware(middleware: 'can:admin.funds.index', only: ['index']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador
            new Middleware(middleware: 'can:admin.funds.create', only: ['create','store']),
            new Middleware(middleware: 'can:admin.funds.edit', only: ['edit','update']),
            new Middleware(middleware: 'can:admin.funds.destroy', only: ['destroy'])

        ];

        /*
            Ejemplo de comando de middleware de Laravel 10 a 11
            new Middleware(middleware: 'auth:sanctum', except: ['index', 'show']), //Laravel 11
            $this->middleware('auth:sanctum')->except(['index', 'show']); //Laravel 10
        */
    }
        /*
            El metodo middleware realiza la acción de llamar al middleware encargado de verificar si un usuario tiene los permisos.
            Para acceder a la pagina de admin.users.index con el metodo only se epecifica que se verificará el permiso unicamente 
            a las paginas especificadas dentro del only
        */
    
    public function index()
    {
        //Llamada al modelo funds, recopilará todas las tuplas de la tabla funds y las guardará en la variable $funds
        $funds = Fund::all();
        //Retorna la vista admin.funds.index en conjunto a la variable $funds recién creada.
        return view('admin.funds.index', compact('funds'));
    }

    public function create()
    {
        //Esta función retorna la vista con la interfaz para crear una nueva categoria.
        return view('admin.funds.create');
    }

    public function store(Request $request)
    {
        //Esta función se encarga de almacenar un nuevo registro para la tabla funds


        //En este apartado la variable $request (La cuál contiene los datos de la petición/categoria capturada por el Form.)
        $request->validate([
            'nameFund' => 'required|string|max:60', //En este campo se dice que el apartado namefund debe ser obligaorio (No debe ser nulo.)
            'slug' => 'required|string|unique:funds' //En este campo se dice que el slug debe de ser requerido y su nombre debe ser único, pero unicamente en la tabla funds
        ], [
            'nameFund.required' => 'El nombre del fondo es obligatorio.',
            'nameFund.string' => 'El nombre del fondo debe ser una cadena de texto.',
            'nameFund.max' => 'El nombre del fondo no debe exceder los 60 caracteres.',
            'slug.required' => 'El Slug del fondo es obligatorio.',
            'slug.string' => 'El slug del fondo debe ser una cadena de texto.',
            'slug.unique' => 'El nombre del fondo ya existe.', //Mensaje de error personalizado
        ]
        );

        /*Una vez la petición ha pasado por todas las validaciones se creará una variable denominada $fund la cual contendra los valores de la tupla del registro recien aceptado
        Ademas, en el apartado fund::create($request->all()); se añade la tupla de la petición a la base de datos. */
        $fund = Fund::create($request->all());

        //Finalmente una vez finalizado este procedimiento se redirecciona a la vista edit del CRUD de categorias (resources\views\admin\funds\edit.blade.php) con la variable $fund (La cual contiene los datos de la tupla recien registrada y un mensaje que se desplegará donde se haya declarado en la vista.)
        return redirect()->route('admin.funds.edit', $fund)->with('info', 'El fondo se ha creado con éxito');
        //El método with() se encarga de retornar un token de retorno el cuál en nuestro codigo de página se verificará y retornará el mensaje declarado en este controlador y variable

    }


    public function show(Request $request)
    {
        //Sin uso--??
        return view('admin.funds.show', compact('fund'));

    }


    public function edit(Fund $fund)
    {
        //Muestra la vista con la pagina para editar una vista.
        return view('admin.funds.edit', compact('fund'));
    }


    public function update(Request $request, Fund $fund)
    {
        //Esta función tiene la función de borrar una tupla/categoria de la base de datos.
        $request->validate([
            'nameFund' => 'required|string|max:60',
            'slug' => "required|string|unique:funds,slug,$fund->id"
             //En este campo se dice que slug debe de ser requerido y tambien sus campos unicos, pero unicamente en la tabla funds
             //Ademas con el ,slug,$fund->id y el uso de comillas dobles ignorara el slug de la categoria que vamos a actualizar, si no realizazmos esta regla será literalmente  imposible actualizar la categoria, al menos no con el nombre que tiene actualmente.
        ], [
            'nameFund.required' => 'El nombre del fondo es obligatorio.',
            'nameFund.string' => 'El nombre del fondo debe ser una cadena de texto.',
            'nameFund.max' => 'El nombre del fondo no debe exceder los 60 caracteres.',
            'slug.required' => 'El Slug del fondo es obligatorio.',
            'slug.string' => 'El slug del fondo debe ser una cadena de texto.',
            'slug.unique' => 'El nombre del fondo ya existe.', //Mensaje de error personalizado
        ]
    );

        //Condicional encargado de detectar si una es identica al momento de actualizar el registro se retornará al formualrio de nuevo con un mensaje.
        if($fund->nameFund == $request->nameFund){
            return redirect()->route('admin.funds.edit', $fund)->with('info2', 'El nuevo nombre del fondo es idéntico, prueba uno diferente.');
        }

        //Una vez realizadas todas las verificaciones con exito la tupla será actualiza con esta llamada al metodo update, 
        //La variable fund invocará al metodo update con los parametros de la variable $request (Nuestra petición/datos actualizados)
        $fund->update($request->all());

        return redirect()->route('admin.funds.edit', $fund)->with('info', 'El fondo se ha actualizado con éxito');
        //El método with() se encarga de retornar un token de retorno el cuál en nuestro código de página se verificará y retornará el mensaje declarado en este controlador y variable
    }

    public function destroy(Fund $fund)
    {
        // Esta función se encarga de borrar las categoria/tupla seleccionada.
        $fund->delete();
        return redirect()->route('admin.funds.index')->with('info', 'El fondo se ha eliminado con éxito');
        //El método with() se encarga de retornar un token de retorno el cual en nuestro codigo de página se verificará y retornará el mensaje declarado en este controlador y variable
    }
}
