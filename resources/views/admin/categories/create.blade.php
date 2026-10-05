@extends('adminlte::page')

@section('title', 'Crear Categoría')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Crear Categoría</h1>
    </div>
@stop

@section('content')
    {{-- Debido a que Laravel Collective fue descontinuado ya no es compatible con Laravel 11, en su lugar se usará Spatie/Laravel-html para el desarrollo de los formularios --}}
    {{-- Laravel Collective nos permite trabajar con todas las etiquetas de un formulario con logica, es decir que automaticamente prepara todos los datos de los formularios, tambien la informacion restaurada, tambien recopila información de las relaciones de bases de datos --}}
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                {{ html()->form('POST')->route('admin.categories.store')->id('categoriesForm')->open() }}

                {{ html()->label('Nombre de la categoría') }}

                {{ html()->text('nameCategory')->placeholder('Ingrese el nombre de la categoría')->addClass('form-control')->attributes(['maxlength' => 50, 'autocomplete' => 'off'])->required('required') }}
                @error('nameCategory')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">

                {{ html()->label('Slug') }}

                {{ html()->text('slug')->placeholder('Slug de la categoría')->addClass('form-control')->isReadonly() }}

                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{ html()->submit('Crear categoría')->addClass('btn btn-danger')->id('submitButton') }}

            {{ html()->form()->close() }}

            {{-- mini formulario para loggout, requerido debido a que la acción de logout requiere de un metodo POST y su respectivo token CSRF --}}
            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                @csrf
            </form>

        </div>
    </div>
@stop

@section('css')
    @vite(['resources/css/adminFormStyles.css'])
@endsection

@section('js')
    @vite(['resources/js/themeTitleInyector.js'])
    {{-- Script Limitación de presionado de botones a 1 solo. --}}
    <script>
        //Recupera al elemento con id categoriesForm (El elemento que inicia el formulario), a este elemento se "escuchará" el momento en el que se realice un submit en el formulario
        //En caso de que haya ocurrido se ejecutará una función anonima la cual inahbilitará el botón con el id submitButton
        document.getElementById('categoriesForm').addEventListener('submit', function() {
            document.getElementById('submitButton').disabled = true;
        });
    </script>

    <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#nameCategory").stringToSlug({
                //En el #se insertará el nombre del espacio del forumlario en estee caso es name.
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                // En esta parte se inserta en que parte del formulario se insertará la salida de la conversion en el formulario, se le asigno el campo de slug
                space: '-'
            });
        });
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
@endsection
