<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ConveyanceController;
use App\Http\Controllers\Admin\DatabaseController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\ElementController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FundController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;


// Con esta ruta del archivo admin denominamos que la pagina /admin/
// Estamos apoyandonos del Homecontroller (app\Http\Controllers\Admin\HomeController.php) y le estamos haciendo una peticion a la función index

Route::get('', [HomeController::class, 'index'])->middleware('can:admin.home')->name('admin.home'); //Todas la rutas declaradas en este archivo tendran el prefijo "admin", el get ya tiene implicito el prefijo admin (Esto fue declarado en el archivo RouterServiceProvider)
// el middleware se encarga de revisar mediante el equivalente a una directiva can con 'can:' si el usuario que está entrando a la ruta tiene los permisos para acceder a admin.home

//Todas la rutas declaradas en este archivo tendran el prefijo "admin", el get ya tiene implicito el prefijo admin (Esto fue declarado en el archivo RouterServiceProvider)

// Route::get('Categorias', [HomeController::class, 'categorias'])->name('admin.categorias'); //Todas la rutas declaradas en este archivo tendran el prefijo "admin", el get ya tiene implicito el prefijo admin (Esto fue declarado en el archivo RouterServiceProvider)

Route::resource('categories', CategoryController::class)->except('show')->names('admin.categories');
//Con except señalamos que no se desea crear la ruta con el siguiente nombre

//Creación de la serie de rutas categories dentro de la carpeta admin en conjunto a su respectivo con el controlador CategoryController
//En resumen: Crea multiples rutas para manejar una variedad de acciones en el recurso (En este caso, controlador)


Route::resource('tags', TagController::class)->except('show')->names('admin.tags');

//Creación de la serie de rutas tags dentro de la carpeta admin en conjunto a su respectivo con el controlador TagController
//En resumen: Crea multiples rutas para manejar una variedad de acciones en el recurso (En este caso, controlador)

//NO contiene ahora ningun except, se están utilizando todas las vistas proporcionadas por el Route::resource
Route::resource('elements', ElementController::class)->names('admin.elements');

Route::resource('funds', FundController::class)->except('show')->names('admin.funds');

Route::resource('users', UserController::class)->only(['index','edit','update'])->names('admin.users');
//Con el metodo only solo se indica que se van a generar las vistas/rutas para las paginas index, edit y update

Route::resource('roles', RoleController::class)->names('admin.roles');
//creación de serie de rutas para CRUD de roles

Route::resource('conveyances', ConveyanceController::class)->only(['index'])->names('admin.conveyances');
//creación de ruta de index (Con listado) de traspasos


/////Rutas para vistas de mantenimiento.

Route::resource('maintenances', MaintenanceController::class)->only(['index','create','store'])->names('admin.maintenances');
//creación de serie de rutas para la interfaz de mantenimientos

//Route:resource unicamente crea las rutas necesarias para un crud (Al crear un controlador con el modificador -r generará las funciones para responder a cada una de estas.)


//Lista de rutas que usará el controlador y vista al momento de retornar o ir a la respectiva vista, esta ruta será utilziada para invocar a la vista print (admin/maintenances/print)
Route::controller(MaintenanceController::class)->group(function () {
    Route::get('/maintenances/print/{maintenance}','print')->name('admin.maintenances.print');
    // Route::post('/orders', 'store');
});


//Lista de rutas que usará el controlador y vista al momento de retornar o ir a la respectiva vista, esta ruta será utilziada para invocar a la vista print (admin/maintenances/print)
Route::controller(DatabaseController::class)->group(function () {
    Route::get('/database','index')->name('admin.database.index');
    Route::get('/database/export','export')->name('admin.database.export');
    Route::post('/database/import','import')->middleware('can:admin.database.import')->name('admin.database.import');
    Route::get('/database/upload','upload')->name('admin.database.upload');
    Route::get('/database/dump','dump')->name('admin.database.dump');
    
});

//Lista de rutas para pruebas de notificaciones
Route::controller(NotificationController::class)->group(function(){
    Route::get('/notifications','index')->name('admin.notifications.index');
    Route::post('/notifications/send','send')->name('admin.notifications.send');
    
});


// Route::resource('events', EventController::class)->names('admin.events'); 
Route::controller(EventController::class)->group(function(){
    // Route::get('/event', 'index')->name('admin.event.index'); //Ruta temporal de prueba
    Route::post('/event/ajax', 'ajax')->name('admin.event.ajax'); // Esta ruta con método POST será utilziada para las solicitudes con AJAX.
    Route::get('/event/fetch', 'fetch')->name('admin.event.fetch'); //Esta ruta es utilizada por el calendario para por medio de una solicitud GET recopile los eventos creados desde un modelo en la base de datos.
});

// Declaración individual de ruta
// Route::get('maintenances/print', [Maintenancecontroller::class, 'print'])->name('admin.maintenances.print');
/////

?>