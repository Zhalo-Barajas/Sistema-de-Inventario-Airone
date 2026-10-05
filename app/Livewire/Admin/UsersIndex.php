<?php

namespace App\Livewire\Admin;

use Livewire\Component;


use App\Models\User; // Importación del modelo User
//Siempre que se trabaje paginaciuon con livewire importar la siguiente libreria:
use Livewire\WithPagination;


class UsersIndex extends Component
{

    //Llamada de paginación con estos elementos 
    use WithPagination;
    public $search;  //Variable publica que alojará los datos de busqueda (palabras) que haya insertado el usuario  
    protected $paginationTheme = "bootstrap"; //Con esto el tema que usará la paginacion con tailwind sera renderizada con Bootstrap.            

    //Esta función nos regresa a la pagina inicial de la busqueda, esto es vital para que pueda mostrar los registros de elementos, ya que si no se encuentra en la pagina 1, no mostrará todas las coincidencias de la busqueda..
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function reloadSearch()
    {
        $this->search = '';
    }

    //Función encargada de realizar la busqueda y retornarla en la vista.
    public function render()
    {

        $users = User::where('name', 'LIKE', '%' . $this->search . '%') //Recopilará todas las tuplas del modelo User (tabla users) donde haya una similaridad con lo que haya en la variable $search (entrada del usuario)
            ->orWhere('email', 'LIKE', '%' . $this->search . '%') //Se realziará la misma consulta pero ahora en la tabla de email, se desplegará en la tabla el resultado de ambas busquedas
            ->paginate(); //Listado de los elementos de usuario, con esto mencionamos que los resultados se muestren en apginas..

        //Retorna los datos a la invocación del componente de livewire, tambien se retorna ña variable $users (Variable la cuál contiene las coincidencias)
        return view('livewire.admin.users-index', compact('users'));
    }
}
