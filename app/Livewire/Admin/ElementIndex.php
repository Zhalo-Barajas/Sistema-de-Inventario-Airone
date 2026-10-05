<?php

namespace App\Livewire\Admin;

use App\Models\Building;
use App\Models\Category;
use App\Models\Element;
use App\Models\Fund;
use App\Models\Tag;
use App\Models\Ubication;
use Livewire\Component;
use Livewire\WithPagination; //Invocación a clase WithPagination de Livewire

//ESTE COMPONENTE DE LIVEWIRE SE ENCARGARÁ DE LA LÓGICA DE LA BARRA DE BÚSQUEDA DINÁMICA.

class ElementIndex extends Component
{

    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    //Con esto se declara que los estilos que usará la paginación seran de bootsrap, no tailwind

    //Variable para casilla de búsqueda de nombre de elemento
    public $search;

    //Variables del resto de casillas de búsqueda.
    public $searchCategory;
    public $searchUbication;
    public $searchBuilding;
    public $searchFund;
    public $searchStatus;
    public $searchTag;

    //Esta función nos regresa a la pagina inicial de la busqueda, esto es vital para que pueda mostrar los registros de posts.
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /*Esta función permanece en escucha de si ocurre una acción en este del select en la vista, al 
      momento de ocurrir un cambio en el select searchStatus se reiniciará la página para poder buscar
      todos los resultados de manera apropiada independientemente de la página de elementos que se 
      encuentre el usuario.*/
    public function updatedSearchStatus()
    {
        $this->resetPage();
    }

    public function updatedSearchUbication()
    {
        $this->resetPage();
    }

    public function updatedSearchBuilding()
    {
        $this->resetPage();
    }

    public function updatedSearchFund()
    {
        $this->resetPage();
    }

    public function updatedSearchTag()
    {
        $this->resetPage();
    }

    public function updatedSearchCategor()
    {
        $this->resetPage();
    }

    public function reloadSearch()
    {
        $this->search = '';
        $this->searchCategory = '';
        $this->searchUbication = '';
        $this->searchBuilding = '';
        $this->searchFund = '';
        $this->searchStatus = '';
        $this->searchTag = '';
    }

    public function render()
    {
        //Similar a un controlador

        //Recuperación de registros de las tablas y tratamiento para presentación en Select's
        $categories =  Category::pluck('nameCategory', 'id');
        $funds = Fund::pluck('nameFund', 'id');
        $tags = Tag::pluck('nameTag', 'id');
        $buildings = Building::pluck('nameBuilding', 'id');
        $ubications = Ubication::pluck('nameUbication', 'id');


        //Variable query que genera una consulta de la tabla elements en conjunto a sus registros respectivos de etiquetas, seguido de un join con atributos extra, en este caso nameBuilding, nameUbication, nameFund, nameCategory provenientes de sus respectivas tablas
        $query = Element::with('tags')->join('categories', 'elements.category_id', '=', 'categories.id')->join('buildings', 'elements.building_id', '=', 'buildings.id')->join('ubications', 'elements.ubication_id', '=', 'ubications.id')->join('funds', 'elements.fund_id', '=', 'funds.id')
            ->select('elements.*', 'buildings.nameBuilding as nameBuilding', 'ubications.nameUbication as nameUbication', 'categories.nameCategory as nameCategory', 'funds.nameFund as nameFund')
            ->where('nameElement', 'LIKE', '%' . $this->search . '%') //Con esto entra nuestra variable search, se declara en el where que buscara en la tabla name valores que contengan los escrito en search, ademas de cualquier cadena antes o despues de, evitando que sea la busqueda con el titulo exacto
            ->latest();

        // Se filtra la consulta recopilada en base a la categoria a la que pertenecen los elementos.
        if ($this->searchCategory) {
            $query = $query->where('category_id', $this->searchCategory);
        }

        // Se filtra la consulta recopilada en base al edificio al que pertenecen los elementos
        if ($this->searchBuilding) {
            $query = $query->where('building_id', $this->searchBuilding);
        }

        // Se filtra la consulta recopilada en base al fondo al que pertenecen los elementos
        if ($this->searchFund) {
            $query = $query->where('fund_id', $this->searchFund);
        }

        // Se filtra la consulta recopilada en base a la ubicación de los elementos
        if ($this->searchUbication) {
            $query = $query->where('ubication_id', $this->searchUbication);
        }

        // Se filtra la consulta recopilada en base a si los elementos están de alta o de baja.
        if ($this->searchStatus) {
            $query = $query->where('statusInv', $this->searchStatus);
        }

        //If que realizará una busqueda en caso de que se haya seleccionado una etiqueta
        if ($this->searchTag) {
            //el método whereRelation('tags', 'tag_id', $this->searchTag); permite agregar condiciones a una consulta basadas en relaciones entre tus modelos. En este caso se realiza con la tabla tags, donde se buscará en el atributo tag_id
            //// Este código realizará una consulta para obtener todos los Post que están relacionados con el Tag cuyo tag_id es igual a $this->searchTag.
            $query = $query->whereRelation('tags', 'tag_id', $this->searchTag);
        }

        //El metodo paginate solo debe de ejecutarse 1 Unica vez, o desplegará una excepción
        $elements = $query->paginate(30);


        //Variables de depuración
        // $depuracionCategory = $this->searchCategory;
        // $depuracionUbication = $this->searchUbication;
        // $depuracionBuilding = $this->searchBuilding;
        // $depuracionFund = $this->searchFund;
        // $depuracionTag = $this->searchTag;
        // $depuracionStatus = $this->searchStatus;

        //Return sin depuraciones
        return view('livewire.admin.element-index', compact('elements', 'categories', 'funds', 'tags', 'buildings', 'ubications'));

        //Return con depuraciones
        // return view('livewire.admin.element-index', compact('elements','categories','funds','tags','buildings','ubications','depuracionStatus','depuracionCategory','depuracionUbication','depuracionBuilding','depuracionFund','depuracionTag'));
    }
}
