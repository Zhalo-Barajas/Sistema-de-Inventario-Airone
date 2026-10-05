<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spatie\Permission\Models\Role; //Agregado el modelo Role de la libreria Spatie/Laravel Permissions
use Spatie\Permission\Models\Permission; //Agregado el modelo Permission de la libreria Spatie/Laravel Permissions
use Illuminate\Routing\Controllers\Middleware;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de unnn metodo constructor)
    {
        //Middleware para comprobar si un usuario puede acceder o no a la vista función de este controlador.
        return [
            
            new Middleware(middleware: 'can:admin.roles.index', only: ['index']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador
            new Middleware(middleware: 'can:admin.roles.create', only: ['create','store']),
            new Middleware(middleware: 'can:admin.roles.edit', only: ['edit','update']),
            new Middleware(middleware: 'can:admin.roles.destroy', only: ['destroy'])

        ];

        /*
            Ejemplo de comando de middleware de Laravel 10 a 11
            new Middleware(middleware: 'auth:sanctum', except: ['index', 'show']), //Laravel 11
            $this->middleware('auth:sanctum')->except(['index', 'show']); //Laravel 10
        */
    }

    public function index()
    {
        $roles = Role::all(); //Recopila todos los Roles existentes del modelo Role y los retorna junto a la vista create 
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all(); //Recopila todos los permisos creados y los envia junto a la vista create.
        return view('admin.roles.create',compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name', //Validacion de campo name, este debe ser obligatorio
        ], [ //Mensajes de error personalizados
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.string' => 'El nombre del rol debe ser una cadena de texto.',
            'name.max' => 'El nombre del rol no debe exceder los 50 caracteres.',
            'name.unique' => 'El nombre del rol ya existe.',
        ]);

        $role = Role::create($request->all()); //Creacion del rol en sí de acuerdo a los datos proporcionados en la variable $role

        $role->permissions()->sync($request->permissions); //Asignación de permisos al rol recien creado mediante la sincronización de estos

        return redirect()->route('admin.roles.edit', $role)->with('info', 'El rol se creó con éxito.'); //Redirección a la vista con el mensaje de existo.

    }

    public function show(Role $role)
    {
        //
        return view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        //
        $permissions = Permission::all();
        //Necesitamos de permissions en la funcion edit para poder usar los archivos partials de nuestra directiva de blade.
        return view('admin.roles.edit', compact('role','permissions'));

    }

    public function update(Request $request, Role $role)
    {
        //Lógica para retornar a index si es un permiso no modificable.
        if ($role->id <= 2) { 
            return redirect()->route('admin.roles.index', $role)->with('info2', 'Acción Prohibida.');
        }

        $request->validate([
            'name' => "required|string|max:50|unique:roles,name,$request->id", //Validacion de campo name
        ], [ //Mensajes de error personalizados
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.string' => 'El nombre del rol debe ser una cadena de texto.',
            'name.max' => 'El nombre del rol no debe exceder los 50 caracteres.',
            'name.unique' => 'El nombre del rol ya existe.',
        ]);

        $test = config('auth.defaults.guard');
        return $test;
        $role->update($request->all());
        
        $role->permissions()->sync($request->permissions); //Asignación de permisos al rol recien creado


        return redirect()->route('admin.roles.edit', $role)->with('info', 'El rol se actualizó con éxito.');

    }

    public function destroy(Role $role)
    {
        //Lógica para retornar a index si es un permiso no modificable.
        if ($role->id <= 2) {
            return redirect()->route('admin.roles.index')->with('info2', 'Acción Prohibida.');
        }
        //Se elimina el rol solicitado por el usuario con la petición.
        $role->delete();
        return redirect()->route('admin.roles.index')->with('info', 'El rol se eliminó con éxito.');

    }

}
