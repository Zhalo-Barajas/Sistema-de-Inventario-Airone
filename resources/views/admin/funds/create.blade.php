@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Crear Nuevo Fondo</h1>
    </div>
@stop

@section('content')
    {{-- Debido a que Laravel Collective fue descontinuado ya no es compatible con Laravel 11, en su lugar se usará Spatie/Laravel-html para el desarrollo de los formularios --}}
    {{-- Laravel Collective nos permite trabajar con todas las etiquetas de un formulario con logica, es decir que automaticamente prepara todos los datos de los formularios, tambien la informacion restaurada, tambien recopila información de las relaciones de bases de datos --}}
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                {{ html()->form('POST')->route('admin.funds.store')->id('fundsForm')->open() }}

                {{ html()->label('Nombre del fondo') }}

                {{ html()->text('nameFund')->placeholder('Ingrese el nombre del fondo')->addClass('form-control')->attributes(['maxlength' => 60, 'autocomplete' => 'off'])->required('required') }}
                @error('nameFund')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">

                {{ html()->label('Slug') }}

                {{ html()->text('slug')->placeholder('Slug del fondo')->addClass('form-control')->isReadonly() }}

                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{ html()->submit('Crear fondo')->addClass('btn btn-danger')->id('submitButton') }}

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
@stop
@section('js')
    @vite(['resources/js/themeTitleInyector.js'])
    {{-- Script Limitación de presionado de botones a 1 solo. --}}
    <script>
        document.getElementById('fundsForm').addEventListener('submit', function() {
            document.getElementById('submitButton').disabled = true;
        });
    </script>

    <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#nameFund").stringToSlug({
                //En el #se insertará el nombre del espacio del forumlario en estee caso es name.
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                // En esta parte se inserta en que parte del formulario se insertará lasalida de la conversion en el formulario, se le asigno el campo de slug
                space: '-'
            });
        });
    </script>
    {{-- SCRIPTS PARA BOTONES DE SIDEBAR --}}
    <script>
        //Script para realizar acción de cambiar de modo claro a oscuro en el panel administrativo. (Traba con el id que tiene el boton de cambio de tema la sidebar de AdminLTE)
        document.getElementById('toggle-dark-mode').addEventListener('click', function() {
            var body = document.body;
            body.classList.toggle('dark-mode');
            //Esta linea agrega o remueve la clase dark-mode de la página, realizando el cambio de tema..
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
