<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag; //Importar al modelo tag

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; //Invocación de controladores para middleware


class TagController extends Controller implements HasMiddleware // Es necesario para poder utilizar middleware declarar en nuestra clase del controlador "implements HasMiddleware" a partir de laravel 11

{
    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de unnn metodo constructor)
    {
        return [
            
            new Middleware(middleware: 'can:admin.tags.index', only: ['index']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador
            new Middleware(middleware: 'can:admin.tags.create', only: ['create','store']),
            new Middleware(middleware: 'can:admin.tags.edit', only: ['edit','update']),
            new Middleware(middleware: 'can:admin.tags.destroy', only: ['destroy'])

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
        //Invoca a todas las tuplas que existen en tags mediante una llamada al modelo Tag y las almacena en la variable $tags
        $tags = Tag::all();
        //Retorna´ra el controlador la vista index          con la variable $tags mediante el metodo compact.
        return view('admin.tags.index',compact('tags')); //Retornar todas las tags
    }

    public function create()
    {
        //Colores para las etiquetas.
        $colors = [
            'red' => 'Color Rojo',
            'yellow' => 'Color Amarillo',
            'green' => 'Color Verde',
            'blue' => 'Color Azul',
            'indigo' => 'Color Indigo',
            'purple' => 'Color Morado',
            'pink' => 'Color Rosado',
            'brown' => 'Color Café',
            'aquamarine' => 'Color Aguamarina',
            'beige' => 'Color Beige',
            'fuchsia' => 'Color Fuchsia',
            'greenYellow' => 'Color VerdeAmarillo',
            'orange' => 'Color Naranja',
            'mintcream' => 'Color Menta',
            'lightsteelblue' => 'Color AceroAzul',
            'lightsalmon' => 'Color Salmón',
            'palevioletred' => 'Color Violeta Pálido',
            'cyan' => 'Color Cyan',
            'lightpink' => 'Color Rosa Claro'

            
        ];
        return view('admin.tags.create',compact('colors'));
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'nameTag' => 'required|string|max:50',
            'slug' => 'required|string|unique:tags',
            'color' => 'required|in:red,yellow,green,blue,indigo,purple,pink,brown,aquamarine,beige,fuchsia,greenYellow,orange,mintcream,lightsteelblue,lightsalmon,palevioletred,cyan,lightpink',
        ], [
            'nameTag.required' => 'El nombre de la etiqueta es obligatorio.',
            'nameTag.string' => 'El nombre de la etiqueta debe ser una cadena de texto.',
            'nameTag.max' => 'El nombre de la etiqueta no debe exceder los 50 caracteres.',
            'slug.required' => 'El slug de la etiqueta es obligatorio.',
            'slug.string' => 'El slug de la etiqueta debe ser una cadena de texto.',
            'slug.unique' => 'El nombre de la etiqueta ya existe.',
            'color.required' => 'El color de la etiqueta es obligatorio.',
            'color.in' => 'El color de la etiqueta no es válido.',
        ]
    );
        $tag = Tag::create($request->all());
        return redirect()->route('admin.tags.edit', compact('tag'))->with('info','La etiqueta se creó con éxito');
    }


    public function edit(Tag $tag)
    {
        //Colores para las etiquetas.
        $colors = [
            'red' => 'Color Rojo',
            'yellow' => 'Color Amarillo',
            'green' => 'Color Verde',
            'blue' => 'Color Azul',
            'indigo' => 'Color Indigo',
            'purple' => 'Color Morado',
            'pink' => 'Color Rosado',
            'brown' => 'Color Café',
            'aquamarine' => 'Color Aguamarina',
            'beige' => 'Color Beige',
            'fuchsia' => 'Color Fuchsia',
            'greenYellow' => 'Color VerdeAmarillo',
            'orange' => 'Color Naranja',
            'mintcream' => 'Color Menta',
            'lightsteelblue' => 'Color AceroAzul',
            'lightsalmon' => 'Color Salmón',
            'palevioletred' => 'Color Violeta Pálido',
            'cyan' => 'Color Cyan',
            'lightpink' => 'Color Rosa Claro'
  
        ];
        return view('admin.tags.edit', compact('tag', 'colors'));
    }

    public function update(Request $request, Tag $tag)
    {

        $request->validate([
            'nameTag' => 'required|string|max:50',
            'slug' => "required|string|unique:tags,slug,$tag->id",
            'color' => 'required|in:red,yellow,green,blue,indigo,purple,pink,brown,aquamarine,beige,fuchsia,greenYellow,orange,mintcream,lightsteelblue,lightsalmon,palevioletred,cyan,lightpink',
        ], [
            'nameTag.required' => 'El nombre de la etiqueta es obligatorio.',
            'nameTag.string' => 'El nombre de la etiqueta debe ser una cadena de texto.',
            'nameTag.max' => 'El nombre de la etiqueta no debe exceder los 50 caracteres.',
            'slug.required' => 'El slug de la etiqueta es obligatorio.',
            'slug.string' => 'El slug de la etiqueta debe ser una cadena de texto.',
            'slug.unique' => 'El nombre de la etiqueta ya existe.',
            'color.required' => 'El color de la etiqueta es obligatorio.',
            'color.in' => 'El color de la etiqueta no es válido.',
        ]);

        //Condicional encargado de detectar si una es identica al momento de actualizar el registro se retornará al formualrio de nuevo con un mensaje.
        if($tag->nameTag == $request->nameTag && $tag->color == $request->color){
            return redirect()->route('admin.tags.edit', $tag)->with('info2', 'El nuevo nombre y color de la etiqueta es idéntico, prueba con valores diferentes.');
        }
    
        $tag->update($request->all());
        return redirect()->route('admin.tags.edit',$tag)->with('info','La etiqueta se actualizó con éxito');
    }

    public function destroy(Tag $tag)
    {
        //
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('info', 'La etiqueta se ha eliminado con éxito');
    
    }
}
