<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; //Invocación de controladores para middleware


class CategoryController extends Controller implements HasMiddleware // Es necesario para poder utilizar middleware declarar en nuestra clase del controlador "implements HasMiddleware" a partir de laravel 11

{
    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de unnn metodo constructor)
    {
        return [
            
            new Middleware(middleware: 'can:admin.categories.index', only: ['index']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador
            new Middleware(middleware: 'can:admin.categories.create', only: ['create','store']),
            new Middleware(middleware: 'can:admin.categories.edit', only: ['edit','update']),
            new Middleware(middleware: 'can:admin.categories.destroy', only: ['destroy'])

        ];


    }

    public function index()
    {
        //Llamada al modelo categories, recopilará todas las tuplas de la tabla categories y las guardará en la variable $categories
        $categories = Category::all();
        //Retorna la vista admin.categories.index en conjunto a la variable $categories recién creada.
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        //Esta función retorna la vista con la interfaz para crear una nueva categoria.
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        //Esta función se encarga de almacenar un nuevo registro para la tabla categories


        //En este apartado la variable $request (La cuál contiene los datos de la petición/categoria capturada por el Form.)
        $request->validate([
            'nameCategory' => 'required|string|max:50', //En este campo se dice que el apartado nameCategory debe ser obligaorio (No debe ser nulo.)
            'slug' => 'required|string|unique:categories' //En este campo se dice que el slug debe de ser requerido y su nombre debe ser único, pero unicamente en la tabla categories
        ], [ //Mensajes de error personalizados
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.string' => 'El nombre de la categoría debe ser una cadena de texto.',
            'name.max' => 'El nombre de la categoría no debe exceder los 50 caracteres.',
            'slug.required' => 'El Slug de la categoría es obligatorio.',
            'slug.string' => 'El slug de la categoría debe ser una cadena de texto.',
            'slug.unique' => 'El nombre de la categoría ya existe.',
        ]);

        /*Una vez la petición ha pasado por todas las validaciones se creará una variable denominada $category la cual contendra los valores de la tupla del registro recien aceptado
        Ademas, en el apartado Category::create($request->all()); se añade la tupla de la petición a la base de datos. */
        $category = Category::create($request->all());

        //Finalmente una vez finalizado este procedimiento se redirecciona a la vista edit del CRUD de categorias (resources\views\admin\categories\edit.blade.php) con la variable $category (La cual contiene los datos de la tupla recien registrada y un mensaje que se desplegará donde se haya declarado en la vista.)
        return redirect()->route('admin.categories.edit', $category)->with('info', 'La categoría se ha creado con éxito');
        //El método with() se encarga de retornar un token de retorno el cuál en nuestro codigo de página se verificará y retornará el mensaje declarado en este controlador y variable

    }

    public function edit(Category $category)
    {
        //Condicional con el proposito de evaluar si la categoria a editar no es una de las categorias principales del sistema.
        if($category->id <= 6){
            return redirect()->route('admin.categories.index', $category)->with('error', 'Acción Prohibida.');

        }
        return view('admin.categories.edit', compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        // return $request;
        //Esta función tiene la función de borrar una tupla/categoria de la base de datos.
        $request->validate([
            'nameCategory' => 'required|string|max:50',
            'slug' => "required|string|unique:categories,slug,$category->id"
             //En este campo se dice que slug debe de ser requerido y tambien sus campos unicos, pero unicamente en la tabla categories
             //Ademas con el ,slug,$category->id y el uso de comillas dobles ignorara el slug de la categoria que vamos a actualizar, si no realizazmos esta regla será literalmente  imposible actualizar la categoria, al menos no con el nombre que tiene actualmente.
        ], [ //Mensajes de error personalizados
            'name.required' => 'El nombre de la categoría es obligatorio.',
            'name.string' => 'El nombre de la categoría debe ser una cadena de texto.',
            'name.max' => 'El nombre de la categoría no debe exceder los 50 caracteres.',
            'slug.required' => 'El Slug de la categoría es obligatorio.',
            'slug.string' => 'El slug de la categoría debe ser una cadena de texto.',
            'slug.unique' => 'El nombre de la categoría ya existe.',
            //Añadir validación del slug con regex para cumplir patrón de Slug
        ]);

        //Condicional con el proposito de evaluar si la categoria a editar no es una de las categorias principales del sistema.
        if($category->id <= 6){
            return redirect()->route('admin.categories.index', $category)->with('error', 'Acción Prohibida.');
        }

        if($category->nameCategory == $request->nameCategory){
            return redirect()->route('admin.categories.edit', $category)->with('info2', 'El nuevo nombre de la categoría es idéntico, prueba uno diferente.');
        }

        //Una vez realizadas todas las verificaciones con exito la tupla será actualiza con esta llamada al metodo update, 
        //La variable category invocará al metodo update con los parametros de la variable $request (Nuestra petición/datos actualizados)
        $category->update($request->all());

        return redirect()->route('admin.categories.edit', $category)->with('info', 'La categoría se ha actualizado con éxito.');
        //El método with() se encarga de retornar un token de retorno el cuál en nuestro código de página se verificará y retornará el mensaje declarado en este controlador y variable
    }

    public function destroy(Category $category)
    {

        //Condicional con el proposito de evaluar si la categoria a eliminar no es una de las categorias principales del sistema.
        if($category->id <= 6){
            return redirect()->route('admin.categories.index')->with('error', 'Acción Prohibida.');
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('info', 'La categoría se ha eliminado con éxito');
        //El método with() se encarga de retornar un token de retorno el cual en nuestro codigo de página se verificará y retornará el mensaje declarado en este controlador y variable

    }
}
