@extends('adminlte::page')

@section('title', 'Registro de mantenimiento')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Registro de mantenimiento</h1>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            {{-- {{$element}} Depuración --}}
            <div class="form-group">
                {{ html()->form('POST')->route('admin.maintenances.store')->id('maintenancesForm')->open() }}

                {{ html()->label('Nombre del elemento') }}

                {{ html()->text('nameElement', $element->nameElement)->addClass('form-control')->isReadonly() }}
            </div>

            <div class="form-group">
                {{ html()->label('Fecha de Ultimo Mantenimiento') }}

                {{ html()->date('oldMaintenanceDate', $element->maintenanceDate, true)->addClass('form-control')->isReadonly() }}
                @error('oldMaintenanceDate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                {{ html()->label('Fecha de Mantenimiento') }}

                {{ html()->date('maintenanceDate', null, true)->addClass('form-control')->required() }}
                @error('maintenanceDate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                {{ html()->label('Descripción del mantenimiento') }}

                {{ html()->textarea('maintenanceDescription')->placeholder('Ingrese la descripción del mantenimiento')->addClass('form-control')->attributes(['maxlength' => 2000, 'autocomplete' => 'off'])->required() }}
                @error('maintenanceDescription')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{ html()->hidden('element_id', $element->id) }}


            {{ html()->submit('Crear Registro')->addClass('btn btn-danger')->id('submitButton') }}

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
        document.getElementById('maintenancesForm').addEventListener('submit', function() {
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
                // En esta parte se inserta en que parte del formulario se insertará lasalida de la conversion en el formulario, se le asigno el campo de slug
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
