<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// }); //LLevará a la vista welcome esta linea.

//Rutas para Landing controller, indice y acerca de.
Route::get('/', [LandingController::class, 'index'])->middleware('auth')->name('landing.index'); //creacion de la ruta para la vista index, esta ruta será la primera pagina que aparecera al momento de loggear al sistema
Route::get('/about', [LandingController::class, 'about'])->name('landing.about'); //creacion de la ruta para la vista index, esta ruta será la primera pagina que aparecera al momento de loggear al sistema




//Ruta de panel de administración
//Con esta ruta laravel reconoce al archivo recien creado (admin.php) como una nueva ruta.
//Esta ruta será dedicada para las paginas del panel de administración de Laravel, en laravel 10 se configuraba este en archivo en ROuteServiceProvider, en Laravel 11 Ya no existe ese archivo.

//Ya no se requiere llamar al middleware 'web' ya que viene implicito en los archivos routes\web.php (Este archivo) y routes\api.php 
//Con el middleware auth se realiza la verificacion en donde se comprueba si el usuario esta logeado o no, en caso de que no se le redirigirá a la pagina de login,

Route::middleware('auth')
                //Con el método prefix asigna el nombre del prefijo de todas de la ruta.
                ->prefix('admin')
                
                /*En Laravel, el método group() se utiliza para agrupar un conjunto de rutas bajo un mismo prefijo de URL,
                 middleware o configuración de nombres de ruta. El método base_path() es una función que devuelve la ruta
                  base del directorio de la aplicación Laravel. */
                ->group(base_path('routes/admin.php'));





//Pagina a la que se redirigirá el sistema una vez el usario haya hehco un login con exito.
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //Sustituido por la pagina de landing
    Route::get('/landing', function () {
        return view('landing');
    })->name('landing');
});
