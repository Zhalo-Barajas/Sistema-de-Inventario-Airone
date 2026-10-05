@extends('adminlte::page')

@section('title', 'Editar Registro de Elemento')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Editar Registro de Elemento</h1>
    </div>
@stop

@section('content')

    {{-- Este if se encarga de verifcar si el controlador retorno algun texto en la variable info. --}}
    @if (session('info'))
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="form-group">
                {{-- {{$element}} //depuración  --}}
                {{-- La directiva de blade @isset se encarga de comprobar que haya recibido la variable $atributes por medio del compact del controlador, de acuerdo a esa condición incluira o no los valores de $atributes (variable con todos los campos de variables adicionales recopilados antes de enviar un request) en el formulario --}}
                @isset($atributes)
                    {{ html()->form('PUT')->route('admin.elements.update', ['element' => $element, 'atributes' => $atributes])->attributes(['autocomplete' => 'off'])->id('elementsForm')->acceptsFiles()->open() }}
                @endisset
                {{ html()->form('PUT')->route('admin.elements.update', ['element' => $element])->attributes(['autocomplete' => 'off'])->id('elementsForm')->acceptsFiles()->open() }}
                {{-- Con la función ->acceptsFiles(), el formulario peritrá recibir archivos, en este caso, imagenes. --}}

                {{-- {{ html()->hidden('user_id', auth()->user()->id) }} --}}
                {{ html()->label('Nombre del elemento') }}
                {{ html()->text('nameElement', $element->nameElement)->placeholder('Ingrese el nombre del elemento')->required('required')->attributes(['maxlength' => 50])->addClass('form-control ') }}
                {{-- El metodo required evita que el usuario deje un area en blanco dentro del formulario a nivel de frontend --}}
                @error('nameElement')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>


            <div class="form-group">
                {{ html()->label('Slug') }}

                {{ html()->text('slug', $element->slug)->placeholder('Slug del elemento')->addClass('form-control')->isReadonly() }}
                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- Desplegable con las categorias existentes --}}
            <div class="d-flex justify-content-around">
                {{ html()->label('Categoría') }}
                {{ html()->label('Fondo') }}
            </div>

            <div class="d-flex justify-content-around">
                {{-- Este campo del formulario es de selección desplegable, en este caso es para el campo category_id, usaremos la variable $categories (Variable generada desde el controlador) para desplegar los datos --}}
                {{ html()->select('category_id', $categories, $element->category_id)->id('selectCategory_id')->addClass('form-control col-3')->placeholder('Selecciona una categoría') }}
                {{-- Añadido id 'selectCategory_id', será utilizado en el Javascript para leer la entrada de este input --}}
                {{ html()->select('fund_id', $funds, $element->fund_id)->addClass('form-control col-3')->placeholder('Selecciona un fondo') }}
            </div>

            <div class="d-flex justify-content-around">
                @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                @error('fund_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="mb-4"></div>




            {{-- Checkboxes con las etiquetas existentes --}}
            <div class="form-group">
                <p class="font-weight-bold">Etiquetas</p>
                @foreach ($tags as $tag)
                    <label class="mr-2">
                        {{-- Aquí, $element->tags && verifica que $element->tags no sea null 
                        antes de continuar con la llamada a in_array() y pluck(). 
                        Si $element->tags es null, la expresión se evaluará como false, 
                        evitando así la llamada a pluck().  --}}
                        {{-- $ubications->pluck('nombre', 'id') crea un array asociativo donde
                     la clave es el ID de la ubicación y el valor es el nombre de la ubicación. 
                     Esto es necesario para crear las opciones del select. --}}
                        {{ html()->checkbox('tags[]', $element->tags && in_array($tag->id, $element->tags->pluck('id')->toArray()), $tag->id) }}
                        {{-- {!! Form::checkbox('tags[]', $tag->id, null) !!} --}}
                        {{ $tag->nameTag }}
                    </label>
                @endforeach

                @error('tags')
                    <br>
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>


            {{-- Desplegable con las categorias existentes --}}
            <div class="d-flex justify-content-around">
                {{ html()->label('Edificio') }}
                {{ html()->label('Ubicación') }}
            </div>
            <div class="d-flex justify-content-around">
                {{ html()->select('building_id', $buildings, $element->building_id)->addClass('form-control col-3')->placeholder('Selecciona un edificio') }}
                {{ html()->select('ubication_id', $ubications, $element->ubication_id)->addClass('form-control col-3')->placeholder('Selecciona una ubicación') }}
            </div>
            <div class="d-flex justify-content-around">
                @error('building_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('ubication_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4"></div>


            <div class="d-flex justify-content-around ml-4">
                {{ html()->label('Fecha de Adquisición') }}
                {{ html()->label('Fecha de último mantenimiento') }}
            </div>

            <div class="d-flex justify-content-around mb-3">
                {{-- Aqui es un campo de formulario para insertar una fecha --}}
                {{ html()->date('adquisitionDate', $element->adquisitionDate, true)->addClass('form-control col-2') }}
                {{ html()->date('-', $element->maintenanceDate, true)->addClass('form-control col-2')->isReadonly() }}
            </div>

            <div class="d-flex justify-content-around mb-3">
                @error('adquisitionDate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('maintenanceDate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                {{ html()->label('Descripción') }}
                {{ html()->textarea('description', $element->description)->addClass('form-control')->attributes(['maxlength' => 2500, 'autocomplete' => 'off'])->required('required') }}

                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- Formularios para atributos adicionales --}}
            {{-- Fragmento del formulario con los elementos para la tabla ComputingAtribute --}}

            {{-- En este apartado de los formualrios adicionales se tiene el siguiente procediiento: primero mediante una directiva de blade if-else se
             comprueba el category_id del elemento a editar, si pertenece este identificador a una de la condiciones del fragmento del formulario 
             se desplegará esta resptiv parte del formulario al momento de cargar la pagina, en caso contrario se mantendrá oculto --}}
            @if (
                $element->category_id == 1 ||
                    $element->category_id == 4 ||
                    $element->category_id == 5 ||
                    $element->category_id == 6)
                <div id="FormularioParte1" style="display: block;">
                @else
                    <div id="FormularioParte1" style="display: none;">
            @endif
            <div class="form-group">
                {{ html()->label('Marca') }}
                {{-- Ls directiva de blade @isset se encarga de comprobar que exista la variable $atributes (Que contiene todos los atributos especificos) 
                    en caso de ser cierto rerecuperará el valor dentro del formulario listo para su edición, en caso contrario no se mostrará nada
                    esta metodologia se utilizará en todos los casos de esta parte del formulario --}}
                @isset($atributes)
                    {{ html()->text('brand', $atributes->brand)->placeholder('Ingrese la marca del elemento')->addClass('form-control')->attributes(['maxlength' => 255]) }}
                @else
                    {{ html()->text('brand', null)->placeholder('Ingrese la marca del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                @endisset
            </div>
            <div class="form-group">
                {{ html()->label('Modelo') }}
                @isset($atributes)
                    {{ html()->text('model', $atributes->model)->placeholder('Ingrese el modelo del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                @else
                    {{ html()->text('model', null)->placeholder('Ingrese el modelo del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                @endisset
            </div>
        </div>


        @if (
            $element->category_id == 1 ||
                $element->category_id == 2 ||
                $element->category_id == 4 ||
                $element->category_id == 5 ||
                $element->category_id == 6)
            <div id="FormularioParte2" style="display: block;">
            @else
                <div id="FormularioParte2" style="display: none;">
        @endif
        <div class="form-group">
            {{ html()->label('Número de inventario') }}
            @isset($atributes)
                {{ html()->text('invNumber', $atributes->invNumber)->placeholder('Ingrese el número de inventario del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
            @else
                {{ html()->text('invNumber', null)->placeholder('Ingrese el número de inventario del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
            @endisset
        </div>
    </div>

    @if (
        $element->category_id == 1 ||
            $element->category_id == 2 ||
            $element->category_id == 4 ||
            $element->category_id == 5)
        <div id="FormularioParte3" style="display: block;">
        @else
            <div id="FormularioParte3" style="display: none;">
    @endif
    <div class="form-group">
        {{ html()->label('Número de serie') }}
        @isset($atributes)
            {{ html()->text('serialNumber', $atributes->serialNumber)->placeholder('Ingrese el numero de serie del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
        @else
            {{ html()->text('serialNumber', null)->placeholder('Ingrese el numero de serie del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
        @endisset
    </div>
    </div>


    @if ($element->category_id == 2 || $element->category_id == 3)
        <div id="FormularioParte4" style="display: block;">
        @else
            <div id="FormularioParte4" style="display: none;">
    @endif
    <div class="form-group">
        {{ html()->label('Color') }}
        @isset($atributes)
            {{ html()->text('color', $atributes->color)->placeholder('Ingrese el color del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
        @else
            {{ html()->text('color', null)->placeholder('Ingrese el color del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
        @endisset
    </div>

    <div class="form-group">
        {{ html()->label('Material') }}
        @isset($atributes)
            {{ html()->text('material', $atributes->material)->placeholder('Ingrese el material del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
        @else
            {{ html()->text('material', null)->placeholder('Ingrese el material del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
        @endisset
    </div>

    <div class="form-group">
        {{ html()->label('Dimensiones') }}
        @isset($atributes)
            {{ html()->text('dimensions', $atributes->dimensions)->placeholder('Ingrese las dimensiones del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
        @else
            {{ html()->text('dimensions', null)->placeholder('Ingrese las dimensiones del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
        @endisset
    </div>
    </div>

    @if ($element->category_id == 2)
        <div id="FormularioParte5" style="display: block;">
        @else
            <div id="FormularioParte5" style="display: none;">
    @endif
    <div class="form-group">
        {{ html()->label('Estantes') }}
        @isset($atributes)
            {{ html()->number('shelves', $atributes->shelves, 0, 50)->placeholder('Ingrese las cantidad de estantes que tiene el elemento')->addClass('form-control') }}
        @else
            {{ html()->number('shelves', null, 0, 50)->placeholder('Ingrese las cantidad de estantes que tiene el elemento')->addClass('form-control') }}
        @endisset
    </div>

    <div class="form-group">
        {{ html()->label('Puertas') }}
        @isset($atributes)
            {{ html()->number('doors', $atributes->doors, 0, 50)->placeholder('Ingrese las cantidad de puertas que tiene el elemento')->addClass('form-control') }}
        @else
            {{ html()->number('doors', null, 0, 50)->placeholder('Ingrese las cantidad de puertas que tiene el elemento')->addClass('form-control') }}
        @endisset
    </div>
    </div>

    @if ($element->category_id == 3)
        <div id="FormularioParte6" style="display: block;">
        @else
            <div id="FormularioParte6" style="display: none;">
    @endif
    <div class="form-group">
        {{ html()->label('Cantidad') }}
        @isset($atributes)
            {{ html()->number('quantity', $atributes->quantity, 0, 50000)->placeholder('Ingrese el Stock del elemento')->addClass('form-control') }}
        @else
            {{ html()->number('quantity', null, 0, 50000)->placeholder('Ingrese el Stock del elemento')->addClass('form-control') }}
        @endisset
    </div>
    </div>

    @if ($element->category_id == 6)
        <div id="FormularioParte7" style="display: block;">
        @else
            <div id="FormularioParte7" style="display: none;">
    @endif
    <div class="form-group">
        {{ html()->label('Tipo de extintor') }}
        @isset($atributes)
            {{ html()->select('typeExt', ['N/A' => 'N/A', 'Agua' => 'Agua', 'Espuma' => 'Espuma', 'Dióxido de Carbono' => 'Dióxido de Carbono', 'PQS Clase ABC' => 'PQS Clase ABC', 'PQS Clase BC' => 'PQS Clase BC', 'Polvo Seco' => 'Polvo Seco', 'Químico Húmedo' => 'Químico Húmedo'], $atributes->typeExt)->placeholder('Ingrese el tipo de extintor')->id('selectExtintor')->addClass('form-control') }}
        @else
            {{ html()->select('typeExt', ['N/A' => 'N/A', 'Agua' => 'Agua', 'Espuma' => 'Espuma', 'Dióxido de Carbono' => 'Dióxido de Carbono', 'PQS Clase ABC' => 'PQS Clase ABC', 'PQS Clase BC' => 'PQS Clase BC', 'Polvo Seco' => 'Polvo Seco', 'Químico Húmedo' => 'Químico Húmedo'], null)->placeholder('Ingrese el tipo de extintor')->id('selectExtintor')->addClass('form-control') }}
        @endisset
    </div>
    </div>


    @if ($element->category_id == 6)
        @isset($atributes)
            @if ($atributes->typeExt != 'N/A')
                <div id="capacity_view" style="display: block;">
                @else
                    <div id="capacity_view" style="display: none;">
            @endif
        @endisset
    @else
        <div id="capacity_view" style="display: none;">
    @endif
    <div class="form-group">
        {{ html()->label('Capacidad') }}
        @isset($atributes)
            {{ html()->number('capacity', $atributes->capacity, 0, 40)->placeholder('Ingrese la Capacidad del extintor')->addClass('form-control') }}
        @else
            {{ html()->number('capacity', null, 0, 40)->placeholder('Ingrese la Capacidad del extintor')->addClass('form-control') }}
        @endisset
    </div>
    </div>

    {{-- Fin formulario atributos adicionales --}}

    {{-- Grids de bootstrap --}}
    <div class="d-flex justify-content-around">
        {{ html()->label('Imagen del Elemento')->addClass('form-label mb-3 mx-auto') }}
    </div>

    <div class="d-flex justify-content-around">
        <div class="image-wrapper w-75 h-75 mx-auto my-auto">
            @isset($element->image)
                <img id="picture" class="rounded mx-auto d-block" src="{{ Storage::url($element->image->url) }}">
            @else
                <img id="picture" class="rounded mx-auto d-block" src="/../imagenes/luna.webp" alt="luna">
            @endisset
        </div>
    </div>

    <div class="d-flex justify-content-around">
        {{-- comando de manejo de multimedia equivalente de {!! Form::file('file', ['class' =>'form-control-file', 'accept' => 'image/*']) !!} de Laravel Collective --}}
        {{ html()->file('file')->id('file')->addClass('btn btn-warning btn-block w-75 mb-3 mt-4')->acceptImage() }}
    </div>

    <div class="d-flex justify-content-around">
        <i>Asegúrate de que la imagen muestre las principales características del elemento.</i>
    </div>

    <div class="d-flex justify-content-around mb-3">
        @error('file')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>


    <div class="form-group">
        <p class="font-weight-bold">Estado de Inventario</p>
        <label>
            {{ html()->radio('statusInv', 1 == $element->statusInv)->value(1) }}
            {{-- {!! Form::radio('status', 2) !!} --}}
            Baja
        </label>

        <label>
            {{ html()->radio('statusInv', 2 == $element->statusInv)->value(2) }}
            {{-- {!! Form::radio('status', 1, true) !!} --}}
            Alta
        </label>
        @error('statusInv')
            <br>
            <small class="text-danger">{{ $message }}</small>
        @enderror
        {{-- Un Radio button solo permite la selecciond e 1 elemento, por eso su uso en el estado del post --}}
    </div>

    {{ html()->submit('Actualizar Elemento')->addClass('btn btn-danger')->id('submitButton') }}

    {{ html()->form()->close() }}

    {{-- mini formulario para loggout, requerido debido a que la acción de logout requiere de un metodo POST y su respectivo token CSRF --}}
    <form method="POST" id="logout-form" action="{{ route('logout') }}">
        @csrf
    </form>
    </div>
    </div>
@stop


@section('css')
    <style>
        <style>.image-wrapper {
            position: relative;

        }

        .image-wrapper img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        ::file-selector-button {

            display: none;
        }
    </style>
    @vite(['resources/css/adminFormStyles.css'])

    </style>
@stop

@section('js')
    @vite(['resources/js/themeTitleInyector.js'])
    <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>


    {{-- Script Limitación de presionado de botones a 1 solo. --}}
    <script>
        document.getElementById('elementsForm').addEventListener('submit', function() {
            document.getElementById('submitButton').disabled = true;
        });
    </script>


    <script>
        //Script de conversión y generación de Slug
        $(document).ready(function() {
            $("#nameElement").stringToSlug({
                //En el #se insertará el nombre del espacio del forumlario en estee caso es name.
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                // En esta parte se inserta en que parte del formulario se insertará lasalida de la conversion en el formulario, se le asigno el campo de slug
                space: '-'
            });
        });
    </script>

    <script>
        //Script para actualizar de manera dinámica la imagen que subimos al formulario

        //El script se mantiene a la escucha de cualquier cambio hecho al input con el id file (Que se encuentra en nuestro formulario de Spatie/Laravel-HTML)
        document.getElementById("file").addEventListener('change', cambiarImagen);

        function cambiarImagen(event) {
            //Esta funcion convierte la imagen que subimos a base64
            var file = event.target.files[0];

            var reader = new FileReader();

            reader.onload = (event) => {
                document.getElementById("picture").setAttribute('src', event.target.result);
                //reemplaza el valor del atributo src por la imagen en formato base64
            };
            reader.readAsDataURL(file);
        }
    </script>

    {{-- Función de JavaScript, Su función es escuchar al botón del lado del sidebar para cerrar sesión, --}}
    <script>
        function logoutFunction() {
            //llamada para subir formulario de cierre de sesión.
            document.getElementById('logout-form').submit();
        }
        //Escucha del click en el sidebar, si lo detecta ejecutará la función logoutFunction.
        document.getElementById("logout-form-click").addEventListener("click", logoutFunction);
    </script>

    <script>
        //Este script de JS funciona de manera identica al de create
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('selectCategory_id');
            const selectExt = document.getElementById('selectExtintor');
            const capacity_view = document.getElementById('capacity_view');

            const FormularioParte1 = document.getElementById('FormularioParte1');
            const FormularioParte2 = document.getElementById('FormularioParte2');
            const FormularioParte3 = document.getElementById('FormularioParte3');
            const FormularioParte4 = document.getElementById('FormularioParte4');
            const FormularioParte5 = document.getElementById('FormularioParte5');
            const FormularioParte6 = document.getElementById('FormularioParte6');
            const FormularioParte7 = document.getElementById('FormularioParte7');

            select.addEventListener('change', function() {
                switch (select.value) {
                    case '1':
                        FormularioParte1.style.display = 'block';
                        FormularioParte2.style.display = 'block';
                        FormularioParte3.style.display = 'block';
                        FormularioParte4.style.display = 'none';
                        FormularioParte5.style.display = 'none';
                        FormularioParte6.style.display = 'none';
                        FormularioParte7.style.display = 'none';
                        break;
                    case '2':
                        FormularioParte1.style.display = 'none';
                        FormularioParte2.style.display = 'block';
                        FormularioParte3.style.display = 'block';
                        FormularioParte4.style.display = 'block';
                        FormularioParte5.style.display = 'block';
                        FormularioParte6.style.display = 'none';
                        FormularioParte7.style.display = 'none';
                        break;
                    case '3':
                        FormularioParte1.style.display = 'none';
                        FormularioParte2.style.display = 'none';
                        FormularioParte3.style.display = 'none';
                        FormularioParte4.style.display = 'block';
                        FormularioParte5.style.display = 'none';
                        FormularioParte6.style.display = 'block';
                        FormularioParte7.style.display = 'none';
                        break;
                    case '4':
                        FormularioParte1.style.display = 'block';
                        FormularioParte2.style.display = 'block';
                        FormularioParte3.style.display = 'block';
                        FormularioParte4.style.display = 'none';
                        FormularioParte5.style.display = 'none';
                        FormularioParte6.style.display = 'none';
                        FormularioParte7.style.display = 'none';
                        break;
                    case '5':
                        FormularioParte1.style.display = 'block';
                        FormularioParte2.style.display = 'block';
                        FormularioParte3.style.display = 'block';
                        FormularioParte4.style.display = 'none';
                        FormularioParte5.style.display = 'none';
                        FormularioParte6.style.display = 'none';
                        FormularioParte7.style.display = 'none';
                        break;
                    case '6':
                        FormularioParte1.style.display = 'block';
                        FormularioParte2.style.display = 'block';
                        FormularioParte3.style.display = 'none';
                        FormularioParte4.style.display = 'none';
                        FormularioParte5.style.display = 'none';
                        FormularioParte6.style.display = 'none';
                        FormularioParte7.style.display = 'block';
                        break;
                    default:
                        FormularioParte1.style.display = 'none';
                        FormularioParte2.style.display = 'none';
                        FormularioParte3.style.display = 'none';
                        FormularioParte4.style.display = 'none';
                        FormularioParte5.style.display = 'none';
                        FormularioParte6.style.display = 'none';
                        FormularioParte7.style.display = 'none';

                }

                if (select.value != '6') {
                    capacity_view.style.display = 'none';
                }
            });

            selectExt.addEventListener('change', function() {
                if (selectExt.value != 'N/A') {
                    capacity_view.style.display = 'block';

                } else {
                    capacity_view.style.display = 'none';
                }

            });
        });
    </script>

@endsection
