<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Category; //Invocación al modelo Category
use App\Models\Element; //Invocación al modelo Element
use App\Models\Fund;
use App\Models\Tag; //Invocación al modelo Tag
use App\Models\Ubication;
use App\Models\computingAtribute;
use App\Models\Conveyance;
use App\Models\furnitureAtribute;
use App\Models\infrastructureAtribute;
use App\Models\labEquipAtribute;
use App\Models\machineryAtribute;
use App\Models\secEquipAtribute;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; //llamada del facade para poder realizar el almacenamiento de las imagenes en la carpeta public
use App\Http\Requests\ElementRequest; //Llamada al store request con nuestras reglas de validacion
use App\Http\Requests\UpdateElementRequest;
//Llamadas a modelos de tablas de atributos adicionales


//Invocación de libreria Carbon (Encargada de facilitar el tratamiento de Fecha y hora asi como su recopilación.)
use Carbon\Carbon;



use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; //Invocación de controladores para middleware
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class ElementController extends Controller implements HasMiddleware // Es necesario para poder utilizar middleware declarar en nuestra clase del controlador "implements HasMiddleware" a partir de laravel 11

{
    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de unnn metodo constructor)
    {
        return [
            
            new Middleware(middleware: 'can:admin.elements.index', only: ['index','show']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador
            new Middleware(middleware: 'can:admin.elements.create', only: ['create','store']),
            new Middleware(middleware: 'can:admin.elements.edit', only: ['edit','update']),
            new Middleware(middleware: 'can:admin.elements.destroy', only: ['destroy'])
      

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
        
        //Retorno a vista principal de menu de CRUD de elementos.
        return view('admin.elements.index');

    }

    public function create()
    {

        $categories = Category::pluck('nameCategory', 'id'); //pluck va a generar un array pero solo tomara el atributo name de los objetos/tuplas, agregamos el id para poder hacer un formato compatible de los datos con laravel collective (o en este caso) Spatie/Laravel-HTML (El formato es: "1: 'Titulo'")
        //Se requiere de pluck y ese formato porque en el apartado del formulario se van a desplegar los nombres de la categorias y estas estarán relacionadas al ID, son todos los datos que necesitamos recopilar de la tabla categories.
        $tags = Tag::all(); // Se recopilan todas la tuplas de la tabla tags, sera utilizada en los checkboxes de los formularios.

        $ubications = Ubication::pluck('nameUbication','id'); //Misma metodología/uso y tratamiento que la tabla categories.
        $buildings = Building::pluck('nameBuilding','id'); //Misma metodología/uso y tratamiento que la tabla categories.
        $funds = Fund::pluck('nameFund','id'); //Misma metodología/uso y tratamiento que la tabla categories.
        return view('admin.elements.create',compact('categories','tags','ubications','buildings','funds')); //Por la parte del compact se está enviando a la vista los datos recopilados de los modelos para ser utilizados en el formulario
    }

    public function show(Element $element)
    {
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
        }
        //En esta consulta se retoma a $element y por medio de JOIN's se realiza una inyección de atributos con la cuál el elemento podra desplegar directamente atributos como el nombre del edificio, categoria, etiquetas, etc.
        $element = Element::where('elements.id', $element->id)->with('tags')->join('categories', 'elements.category_id', '=', 'categories.id')->join('buildings', 'elements.building_id', '=', 'buildings.id')->join('ubications', 'elements.ubication_id', '=', 'ubications.id')->join('funds', 'elements.fund_id', '=', 'funds.id')
        ->select('elements.*', 'buildings.nameBuilding as nameBuilding', 'ubications.nameUbication as nameUbication', 'categories.nameCategory as nameCategory','funds.nameFund as nameFund')->first();
        return view('admin.elements.show', compact('element','atributes'));
        // Element::find($element->id)
        
    }

    public function store(ElementRequest $request) //En este apartado hacemos una llamada a ElementRequest, este archivo fue creado con el comando "php artisan make:request ElementRequest", de este archivo se recupera la variable $request
    {
        return DB::transaction(function () use ($request) { 
        $element = new Element();
        $element->nameElement = $request->nameElement;
        //Se registra el slug base en esta linea (slug de base, ejemplo: test-elemento)
        $element->slug = $request->slug;
        $element->adquisitionDate = $request->adquisitionDate;
        $element->statusInv = $request->statusInv;
        $element->maintenanceDate = $request->maintenanceDate;
        $element->description = $request->description;
        $element->ubication_id = $request->ubication_id;
        $element->category_id = $request->category_id;
        $element->user_id = $request->user_id;
        $element->fund_id = $request->fund_id;
        $element->building_id = $request->building_id;
        //Una vez se recopilaron todos los atributos del request se guardarán finalmente en la BDD, con el fin de generar el id de este elemento recien creado.
        $element->save();
        //Una vez generado el id con la primer llamada del metodo save se sobrescribirá el slug a un nuevo formato (Slug nuevo formato, ejemplo: test-elemento-112)
        //Este nuevo slug tiene el propósito de evitar que haya un conflicto por crear elementos de nombre identico, así como poder diferenciar estos entre sí, una vez hecho este cambio se guardará la tupla de nuevo.
        $element->slug = ($element->slug)."-".$element->id;
        $element->save();


        /* ///// El proposito de este switch es de acuerdo al category_id de la petición del usuario ($request) crear 
                 un registro de atributos especificos, si no se pertenece alguno de estos casos del switch se continuará
                 la ejecución normalmente, sin crear una tupla/registro de atributo especifico naturalmente*/
        switch ($request->category_id) {
            case "1":
                $computingAtribute = new computingAtribute();
                $computingAtribute->brand = $request->brand;
                $computingAtribute->model = $request->model;
                $computingAtribute->serialNumber = $request->serialNumber;
                $computingAtribute->invNumber = $request->invNumber;
                $computingAtribute->element_id = $element->id;
                $computingAtribute->save();
                break;
            case "2":
                $furnitureAtribute = new furnitureAtribute();
                $furnitureAtribute->color = $request->color;
                $furnitureAtribute->material = $request->material;
                $furnitureAtribute->dimensions = $request->dimensions;
                $furnitureAtribute->shelves = $request->shelves;
                $furnitureAtribute->doors = $request->doors;
                $furnitureAtribute->serialNumber = $request->serialNumber;
                $furnitureAtribute->invNumber = $request->invNumber;
                $furnitureAtribute->element_id = $element->id;
                $furnitureAtribute->save();
                break;
            case "3":
                $infrastructureAtribute = new infrastructureAtribute();
                $infrastructureAtribute->material = $request->material;
                $infrastructureAtribute->color = $request->color;
                $infrastructureAtribute->quantity = $request->quantity;
                $infrastructureAtribute->dimensions = $request->dimensions;
                $infrastructureAtribute->element_id = $element->id;
                $infrastructureAtribute->save();
                break;
            case "4":
                $labEquipAtribute = new labEquipAtribute();
                $labEquipAtribute->brand = $request->brand;
                $labEquipAtribute->model = $request->model;
                $labEquipAtribute->invNumber = $request->invNumber;
                $labEquipAtribute->serialNumber = $request->serialNumber;
                $labEquipAtribute->element_id = $element->id;
                $labEquipAtribute->save();
                break;
            case "5":
                $machineryAtribute = new machineryAtribute(); 
                $machineryAtribute->brand = $request->brand;
                $machineryAtribute->model = $request->model;
                $machineryAtribute->invNumber = $request->invNumber;
                $machineryAtribute->serialNumber = $request->serialNumber;
                $machineryAtribute->element_id = $element->id;
                $machineryAtribute->save();
                break;
            case "6":
                $secEquipAtribute = new secEquipAtribute();
                $secEquipAtribute->brand = $request->brand;
                $secEquipAtribute->model = $request->model;
                $secEquipAtribute->invNumber = $request->invNumber;
                $secEquipAtribute->typeExt = $request->typeExt;
                $secEquipAtribute->capacity = $request->capacity;
                $secEquipAtribute->element_id = $element->id;
                $secEquipAtribute->save();
                break;
            default:
                
                break;
        }
        
        // Este if se encarga de verificar si se encuentra una imagen dentro del envio/Request de elements, como no es un valor obligatorio se requiere este if para no ejecutar siempre el guardado de la imagen (Evitando errores/excepciones dentro de laravel.)
        if ($request->file('file')){

            $url = Storage::put('public/elements', $request->file('file'));
            
            //Creación de registro con relación polimorfica a partir del atributo de URL
            $element->image()->create([
                'url' => $url
            ]);
            // Llamamos a element con la relacion polimórfica image y la creacion del registro en la base de datos
        }

        if($request->tags){ //Condicional la cual verifica si estamos mandando informacion de etiquetas (o más explicitamente, comprueba si nuesta petición contiene valores para relación muchos a muchos con tags)
            $element->tags()->attach($request->tags); 

        }

            return redirect()->route('admin.elements.edit', $element)->with('info', 'El elemento se ha creado con éxito');
        });
    }


    public function edit(Element $element)
    {

        //Invocacion de nuestro metodo "author" creado en ElementPolicy, va a recibir a la variable $element
        // $this->authorize('author', $element);

        //Esta función realiza practicamente la misma metodologia que el metodo create de este mismo controlador, pero se hace una llamada al modelo Elements para recopilar los datos de la tupla/registro a editar.
        $categories = Category::pluck('nameCategory', 'id'); //pluck va a generar un array pero solo tomara el atributo name de los objetos/tuplas, agregamos el id para poder hacer un formato compatible de los datos con laravel collective (o en este caso) Spatie/Laravel-HTML (El formato es: "1: 'Titulo'")
        $tags = Tag::all();
        $ubications = Ubication::pluck('nameUbication','id');
        $buildings = Building::pluck('nameBuilding','id');
        $funds = Fund::pluck('nameFund','id');

        ///// El siguiente Switch tiene la función de retornar de acuerdo al category_id que tenga el elemento que solicitó el usuario en el frontend la variable $atributes, esta variable contiene los valores de los atributos espcificos del elemento, en caso de que su category_id no pertenezca a ninguna categoria con atributos extra se retornará la vista con los valores basicos para el formulario.


        switch ($element->category_id){
            case "1":
                $atributes = computingAtribute::where('element_id', $element->id)->first();
                return view('admin.elements.edit',compact('element','categories','tags','ubications','buildings','funds', 'atributes' )); //Por la parte del compact se está enviando a la vista los datos recopilados de los modelos para ser utilizados en el formulario, ademas de los datos de la tupla a editar (con element)
                break;
            case "2":
                $atributes = furnitureAtribute::where('element_id', $element->id)->first();
                return view('admin.elements.edit',compact('element','categories','tags','ubications','buildings','funds', 'atributes' )); //Por la parte del compact se está enviando a la vista los datos recopilados de los modelos para ser utilizados en el formulario, ademas de los datos de la tupla a editar (con element)
                break;   
            case "3":
                $atributes = infrastructureAtribute::where('element_id', $element->id)->first();
                return view('admin.elements.edit',compact('element','categories','tags','ubications','buildings','funds', 'atributes' )); //Por la parte del compact se está enviando a la vista los datos recopilados de los modelos para ser utilizados en el formulario, ademas de los datos de la tupla a editar (con element)
                break; 
            case "4":
                $atributes = labEquipAtribute::where('element_id', $element->id)->first();
                return view('admin.elements.edit',compact('element','categories','tags','ubications','buildings','funds', 'atributes' )); //Por la parte del compact se está enviando a la vista los datos recopilados de los modelos para ser utilizados en el formulario, ademas de los datos de la tupla a editar (con element)
                break; 
            case "5":
                $atributes = machineryAtribute::where('element_id', $element->id)->first();
                return view('admin.elements.edit',compact('element','categories','tags','ubications','buildings','funds', 'atributes' )); //Por la parte del compact se está enviando a la vista los datos recopilados de los modelos para ser utilizados en el formulario, ademas de los datos de la tupla a editar (con element)
                break; 
            case "6":
                $atributes = secEquipAtribute::where('element_id', $element->id)->first();
                return view('admin.elements.edit',compact('element','categories','tags','ubications','buildings','funds', 'atributes' )); //Por la parte del compact se está enviando a la vista los datos recopilados de los modelos para ser utilizados en el formulario, ademas de los datos de la tupla a editar (con element)
                break;  
        }
        /////

        return view('admin.elements.edit',compact('element','categories','tags','ubications','buildings','funds')); //Por la parte del compact se está enviando a la vista los datos recopilados de los modelos para ser utilizados en el formulario, ademas de los datos de la tupla a editar (con element)
    }

    public function update(UpdateElementRequest $request, Element $element)
    {
        return DB::transaction(function () use ($request,$element) { /// La llamada a DB::transaction encapsula todas las funciones como beginTransaction, rollback y commit


           /* El siguiente fragmento de código es una función, la función consiste de un switch el
            cuál de acuerdo al category_id se eliminará la tupla/registro de la tabla específica que coincida 
            con el element_id de la del elemento a utilizar, $vale la pena recalcar que element_id 
            en el momento que es invocado el valor del elemento antes de ser actualizado
        */
        function deleteAtribute(Element $element){
            switch($element->category_id){
                case "1":
                    /*De acuerdo a la category_id del elemento (NO el de la petición, sino el del registro recopilado con el modelo element)
                      utilizar ese valor en un switch el cual de acuerdo a la categoria a la que pertenez eliminar ese registro de la BD     
                    */
                    $deleted = computingAtribute::where('element_id',$element->id)->delete();
                    break;
                case "2":
                    $deleted = furnitureAtribute::where('element_id',$element->id)->delete();
                    break;
                case "3":
                    $deleted = infrastructureAtribute::where('element_id',$element->id)->delete();
                        break;
                case "4":
                    $deleted = labEquipAtribute::where('element_id',$element->id)->delete();
                        break;
                case "5":
                    $deleted = machineryAtribute::where('element_id',$element->id)->delete();
                        break;
                case "6":
                    $deleted = secEquipAtribute::where('element_id',$element->id)->delete();
                        break;
                //En este caso el default existe dentro de este switch para cuando se cumple la condición de ejecuciónd e esta función por una categoria ajena a las de los cases no realice otra acción.
                default:
                        break;
            }
        }
        //Invocacion de nuestro metodo creado en ElementPolicy, va a recibir a la variable element
        // $this->authorize('author', $element);


        //return $element; //Depuración

        // $element->update($request->all());
        // return $request; //Depuración



        /* Este switch tiene como función de acuerdo al ID de la categoria de la petición 
           actualizar el respectivo atributo*/
        switch ($request->category_id) {
            case "1":
                /* el if dentro de este case se encarga de corroborar si el category_id de la petición es diferente al que tiene actualmente. Si es verdadera la condición
                   se ejecutará la función deleteAtribute */
                if ($element->category_id != $request->category_id ){
                    //En la función unicamente se realiza la tarea de eliminar el registro de la BD de la tabla del atributo en especifico de acuerdo al category_id de $element
                    deleteAtribute($element);
                    //Una vez eliminado el registro se creará el nuevo registro de atributos especificos, en este caso de computerAtribute
                    $computingAtribute = new computingAtribute();
                    $computingAtribute->brand = $request->brand;
                    $computingAtribute->model = $request->model;
                    $computingAtribute->serialNumber = $request->serialNumber;
                    $computingAtribute->invNumber = $request->invNumber;
                    $computingAtribute->element_id = $element->id;
                    $computingAtribute->save();

                    //Finalmente estas 2 lineas del if se asegura de actualizar el registro de la tabla elements a su nuevo id de categoria.
                    $element->category_id = $request->category_id; 
                    $element->save();
                }
                else{
                     //Este if existe con el fin de comprobar que el elemento existe, en caso contrario va acrearlo en lugar de actualizarlo. (ESTO PUEDE OCURRIR AL MOMENTO DE IMPORTAR DATOS CON UN XLSX A CAUSA DEL USUARIO).
                    $computingAtribute = computingAtribute::where('element_id', $element->id)->first();
                    // return $computingAtribute;
                    if($computingAtribute == null){
                        
                        $computingAtribute = new computingAtribute();
                        $computingAtribute->brand = $request->brand;
                        $computingAtribute->model = $request->model;
                        $computingAtribute->serialNumber = $request->serialNumber;
                        $computingAtribute->invNumber = $request->invNumber;
                        $computingAtribute->element_id = $element->id;
                        $computingAtribute->save();
                        
                    }else{

                    $computingAtribute->brand = $request->brand;
                    $computingAtribute->model = $request->model;
                    $computingAtribute->serialNumber = $request->serialNumber;
                    $computingAtribute->invNumber = $request->invNumber;
                    $computingAtribute->save();
                    }
                }
                break;
            case "2":
                if ($element->category_id != $request->category_id ){
                    //En la función unicamente se realiza la tarea de eliminar el registro de la BD de la tabla del atributo en especifico de acuerdo al category_id de $element
                    deleteAtribute($element);
                    $furnitureAtribute = new furnitureAtribute();
                    $furnitureAtribute->color = $request->color;
                    $furnitureAtribute->material = $request->material;
                    $furnitureAtribute->dimensions = $request->dimensions;
                    $furnitureAtribute->shelves = $request->shelves;
                    $furnitureAtribute->doors = $request->doors;
                    $furnitureAtribute->serialNumber = $request->serialNumber;
                    $furnitureAtribute->invNumber = $request->invNumber;
                    $furnitureAtribute->element_id = $element->id;
                    $furnitureAtribute->save();

                    $element->category_id = $request->category_id; 
                    $element->save();
                    }
                else{
                    
                    
                    $furnitureAtribute = furnitureAtribute::where('element_id', $element->id)->first();

                    //Este if al comprobar que no existe un elemento dentro de la base de datos generará un registro nuevo (Derivado de un importación con errores), en caso contrario actualizará el elemento.
                    if($furnitureAtribute == null){
                        $furnitureAtribute = new furnitureAtribute();
                        $furnitureAtribute->element_id = $element->id;
                        $furnitureAtribute->color = $request->color;
                        $furnitureAtribute->material = $request->material;
                        $furnitureAtribute->dimensions = $request->dimensions;
                        $furnitureAtribute->shelves = $request->shelves;
                        $furnitureAtribute->doors = $request->doors;
                        $furnitureAtribute->serialNumber = $request->serialNumber;
                        $furnitureAtribute->invNumber = $request->invNumber;
                        $furnitureAtribute->save();
                    }else{
                        $furnitureAtribute->color = $request->color;
                        $furnitureAtribute->material = $request->material;
                        $furnitureAtribute->dimensions = $request->dimensions;
                        $furnitureAtribute->shelves = $request->shelves;
                        $furnitureAtribute->doors = $request->doors;
                        $furnitureAtribute->serialNumber = $request->serialNumber;
                        $furnitureAtribute->invNumber = $request->invNumber;
                        $furnitureAtribute->save();
                    }
                }
                break;
            case "3":
                if ($element->category_id != $request->category_id){
                    //En la función unicamente se realiza la tarea de eliminar el registro de la BD de la tabla del atributo en especifico de acuerdo al category_id de $element
                    deleteAtribute($element);
                    $infrastructureAtribute = new infrastructureAtribute();
                    $infrastructureAtribute->material = $request->material;
                    $infrastructureAtribute->color = $request->color;
                    $infrastructureAtribute->quantity = $request->quantity;
                    $infrastructureAtribute->dimensions = $request->dimensions;
                    $infrastructureAtribute->element_id = $element->id;
                    $infrastructureAtribute->save();

                    $element->category_id = $request->category_id; 
                    $element->save();
                }
                else{
                    //El metodo where recupera los valores como una colección, esto no es compatible con el metodo save() (debido a que este metodo unicamente trabaja con una tupla), con el metodo first solo se recuperará la primera tupla que cumpla la condicón, algo idioneo ya que solo buscamos a 1 única coincidencia dentro de un atributo el cuál no es una llave primaria.

                    //NOTA: find()/findOrFail() unicamente actua sobre la llave primaria, no otro atributo.
                    // return $element; //Depuración
                    /* La variable request no contiene ninguna id (llamese id o element id), solo los atributos a actualizar. */

                    $infrastructureAtribute = infrastructureAtribute::where('element_id',$element->id)->first(); 
                    if($infrastructureAtribute == null){
                        $infrastructureAtribute = new infrastructureAtribute();
                        $infrastructureAtribute->material = $request->material;
                        $infrastructureAtribute->color = $request->color;
                        $infrastructureAtribute->quantity = $request->quantity;
                        $infrastructureAtribute->dimensions = $request->dimensions;
                        $infrastructureAtribute->element_id = $element->id;
                        $infrastructureAtribute->save();
                    }
                    else{
                        $infrastructureAtribute->material = $request->material;
                        $infrastructureAtribute->color = $request->color;
                        $infrastructureAtribute->quantity = $request->quantity;
                        $infrastructureAtribute->dimensions = $request->dimensions;
                        $infrastructureAtribute->save();
                    }
                }
                break;
            case "4":
                if ($element->category_id != $request->category_id ){
                    //En la función unicamente se realiza la tarea de eliminar el registro de la BD de la tabla del atributo en especifico de acuerdo al category_id de $element
                    deleteAtribute($element);
                    $labEquipAtribute = new labEquipAtribute();
                    $labEquipAtribute->brand = $request->brand;
                    $labEquipAtribute->model = $request->model;
                    $labEquipAtribute->invNumber = $request->invNumber;
                    $labEquipAtribute->serialNumber = $request->serialNumber;
                    $labEquipAtribute->element_id = $element->id;
                    $labEquipAtribute->save();

                    $element->category_id = $request->category_id; 
                    $element->save();
                }
                else{
                    $labEquipAtribute = labEquipAtribute::where('element_id', $element->id)->first();
                    if($labEquipAtribute == null){
                        $labEquipAtribute = new labEquipAtribute();
                        $labEquipAtribute->brand = $request->brand;
                        $labEquipAtribute->model = $request->model;
                        $labEquipAtribute->invNumber = $request->invNumber;
                        $labEquipAtribute->serialNumber = $request->serialNumber;
                        $labEquipAtribute->element_id = $element->id;
                        $labEquipAtribute->save();
                    }else{
                        $labEquipAtribute->brand = $request->brand;
                        $labEquipAtribute->model = $request->model;
                        $labEquipAtribute->invNumber = $request->invNumber;
                        $labEquipAtribute->serialNumber = $request->serialNumber;
                        $labEquipAtribute->save();
                    }
                }
                break;
            case "5":
                if ($element->category_id != $request->category_id ){
                    //En la función unicamente se realiza la tarea de eliminar el registro de la BD de la tabla del atributo en especifico de acuerdo al category_id de $element
                    deleteAtribute($element);
                    $machineryAtribute = new machineryAtribute(); 
                    $machineryAtribute->brand = $request->brand;
                    $machineryAtribute->model = $request->model;
                    $machineryAtribute->invNumber = $request->invNumber;
                    $machineryAtribute->serialNumber = $request->serialNumber;
                    $machineryAtribute->element_id = $element->id;
                    $machineryAtribute->save();

                    $element->category_id = $request->category_id; 
                    $element->save();
                }
                else{

                    $machineryAtribute = machineryAtribute::where('element_id', $element->id)->first();
                    if($machineryAtribute == null){
                        $machineryAtribute = new machineryAtribute(); 
                        $machineryAtribute->brand = $request->brand;
                        $machineryAtribute->model = $request->model;
                        $machineryAtribute->invNumber = $request->invNumber;
                        $machineryAtribute->serialNumber = $request->serialNumber;
                        $machineryAtribute->element_id = $element->id;
                        $machineryAtribute->save();
                    }
                    else{                    
                        $machineryAtribute->brand = $request->brand;
                        $machineryAtribute->model = $request->model;
                        $machineryAtribute->invNumber = $request->invNumber;
                        $machineryAtribute->serialNumber = $request->serialNumber;
                        $machineryAtribute->save();
                    }
                }
                break;
            case "6":
                if ($element->category_id != $request->category_id){
                    //En la función unicamente se realiza la tarea de eliminar el registro de la BD de la tabla del atributo en especifico de acuerdo al category_id de $element
                    deleteAtribute($element);
                    $secEquipAtribute = new secEquipAtribute();
                    $secEquipAtribute->brand = $request->brand;
                    $secEquipAtribute->model = $request->model;
                    $secEquipAtribute->invNumber = $request->invNumber;
                    $secEquipAtribute->typeExt = $request->typeExt;
                    $secEquipAtribute->capacity = $request->capacity;
                    $secEquipAtribute->element_id = $element->id;
                    $secEquipAtribute->save();

                    $element->category_id = $request->category_id; 
                    $element->save();
                }
                else{

                    $secEquipAtribute = secEquipAtribute::where('element_id', $element->id)->first();
                    if($secEquipAtribute == null){
                        $secEquipAtribute = new secEquipAtribute();
                        $secEquipAtribute->brand = $request->brand;
                        $secEquipAtribute->model = $request->model;
                        $secEquipAtribute->invNumber = $request->invNumber;
                        $secEquipAtribute->typeExt = $request->typeExt;
                        $secEquipAtribute->capacity = $request->capacity;
                        $secEquipAtribute->element_id = $element->id;
                        $secEquipAtribute->save();
                    }else{
                        $secEquipAtribute->brand = $request->brand;
                        $secEquipAtribute->model = $request->model;
                        $secEquipAtribute->invNumber = $request->invNumber;
                        $secEquipAtribute->typeExt = $request->typeExt;
                        $secEquipAtribute->capacity = $request->capacity;
                        $secEquipAtribute->save(); 
                    }
                }
                break;
            default:
             /**Dentro del default (Es decir, en el caso de que la actualización de category_id sea una categoria sin atributos especificos)
              * se genera una condicional, la cual corrobora con $element si pertenecia a una categoria con atributos especificos,
              En caso de ser verdadero se eliminará la tupla correspondiente de la tabla de atributos especificos a la que tenia un registro el elemento 
              
              En otros casos no se ejecutará nada (Como un cambio de categoria sin atributos a otra cateogira sin atributos por ejemplo.*/
                if($element->category_id <= 6){
                    deleteAtribute($element);
                }
                break;
                
        }

        ///// Creación de registro de traspasos.

        //El if se encarga de comprobar si se ha actualizado el id de edificio o ubicación, en caso de que sea diferente el valor de la petición con el del registro ($request y $element) se generará el registro de traspaso.
        if ($element->building_id != $request->building_id || $element->ubication_id != $request->ubication_id ) {
            $conveyance = new Conveyance(); 
            $conveyance->conveyanceDate =  Carbon::now();
            $conveyance->oldBuilding_id = $element->building_id;
            $conveyance->oldUbication_id = $element->ubication_id;
            $conveyance->ubication_id = $request->ubication_id;
            $conveyance->building_id = $request->building_id;
            $conveyance->element_id = $element->id;
            $conveyance->save();
        }
        /////



     /** Una vez realizadas todas las comprobaciones del switch se generará la actualzación del elemento en su respectiva tabla elements. */
        $element->nameElement = $request->nameElement;
        // $element->slug = $request->slug;
        $element->adquisitionDate = $request->adquisitionDate;
        $element->statusInv = $request->statusInv;
        $element->description = $request->description;
        $element->ubication_id = $request->ubication_id;
        $element->category_id = $request->category_id;
        $element->fund_id = $request->fund_id;
        $element->building_id = $request->building_id;
        //Este if se encarga de corroborar si hubo un cambio en el slug del elemento, si no lo hubo se guardará normamente toda la tupla/registro
        if($element->slug == $request->slug){
            $element->save();
        }
        else{
        //En este caso donde los Slugs son diferentes se generará uno nuevo con los valores de la variable $request, agregando el respectivo id del elemento.
            $element->slug = $request->slug;
            $element->slug = ($element->slug)."-".$element->id;
            $element->save();
        }

        if($request->file('file')){

        $url = Storage::put('public/elements', $request->file('file'));


            //Este if comprueba si ya existe una imagen creada en el element, si es verdadero borra la foto anterior y la actualzia con una nueva, en caso contrario solo se realiza de nuevo la relacion para actualziar los datos.
            if($element->image){
                Storage::delete($element->image->url);

                $element->image->update([
                    'url' => $url
                ]);
            }else{
                $element->image()->create([
                    'url' => $url
                ]);
            }
        }

        if($request->tags){ //Condicional la cual verifica si estamos mandando informacion de etiquetas 
            $element->tags()->sync($request->tags); //Aqui con tags() recuperamos la relacion  de muchos a mucho, con attach podemos insertar  un array con las ids de tags disponibles, en este caso  $request->tags incluye todos nuestros tags
            //Se usa el metodo sync para evitar etiquetas duplicadas, ademas de eliminar las etiquetas que nos son seleccionadas
        }

        return redirect()->route('admin.elements.edit', $element)->with('info', 'El elemento se ha actualizado con éxito');
         
        });
    }

    public function destroy(Element $element)
    {
        //Invocacion de nuestro metodo creado en ElementPolicy, va a recibir a la variable element
        $this->authorize('author', $element);

        //La invocación de este switch tiene como proposito eliminar la tabla de atributos extra del elemento en caso de tenerlo
        switch($element->category_id){
            case "1":
                /*De acuerdo a la category_id del elemento (NO el de la petición, Sino el del registro recopilado con el modelo element)
                  utilizar ese valor en un switch el cual de acuerdo a la categoria a la que pertenece eliminar ese registro de la BD     
                */
                $deleted = computingAtribute::where('element_id',$element->id)->delete();
                break;
            case "2":
                $deleted = furnitureAtribute::where('element_id',$element->id)->delete();
                break;
            case "3":
                $deleted = infrastructureAtribute::where('element_id',$element->id)->delete();
                    break;
            case "4":
                $deleted = labEquipAtribute::where('element_id',$element->id)->delete();
                    break;
            case "5":
                $deleted = machineryAtribute::where('element_id',$element->id)->delete();
                    break;
            case "6":
                $deleted = secEquipAtribute::where('element_id',$element->id)->delete();
                    break;
            //En este caso el default existe dentro de este switch para cuando se cumple la condición de ejecuciónd e esta función por una categoria ajena a las de los cases no realice otra acción.
            default:
                    break;
        }

        $element->delete();
        return redirect()->route('admin.elements.index')->with('info', 'El elemento se ha eliminado con éxito');

    }
}
