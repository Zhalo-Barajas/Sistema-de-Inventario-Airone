<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;// Importacion del modelo User
use Spatie\Permission\Models\Role; //Importacion de modelo de roles de Spatie, necesario para recopilar los roles.


use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware; //Invocación de controladores para middleware

class UserController extends Controller implements HasMiddleware // Es necesario para poder utilizar middleware declarar en nuestra clase del controlador "implements HasMiddleware" a partir de laravel 11
{
     
    public static function middleware(): array //Nueva función dedicada para utilizar middleware en (Antes en laravel 10 era por medio de unnn metodo constructor)
    {
        return [
            
            new Middleware(middleware: 'can:admin.users.index', only: ['index']), //Nueva forma de declarar middleware de laravel 11 dentro del controlador
            new Middleware(middleware: 'can:admin.users.edit', only: ['edit','update']),
            new Middleware(middleware: 'can:admin.users.destroy', only: ['destroy']),
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
        //Retorno a la pagina indice de usuarios (Donde se mostrarán los elementos listados.)
        return view('admin.users.index');
    }

    public function edit(User $user)
    {
        //la variable $roles recopilará todos los roles que existen dentro de la BDD 
        $roles = Role::all();

        // Los retornará a la vista edit, en conjunto a la variable $user recopilada en la invocación de esta función
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles); //llamadas a la tabla roles, se realzará una sincronización con los datos de la petición con el fin de actualizar particularmente el rol del usuario de la petición.

        return redirect()->route('admin.users.edit', $user)->with('info', 'Se asignaron los roles correctamente');
    }
}
