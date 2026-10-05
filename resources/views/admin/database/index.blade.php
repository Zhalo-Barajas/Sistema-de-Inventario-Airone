@extends('adminlte::page')
{{-- NOTA: TODAS LAS PAGINAS CREADAS/DERIVADAS DE ADMINLTE TRABAJAN CON BOOTSTRAP --}}
@section('title', 'Importación/Exportación y Respaldos')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Importación/Exportación y Respaldos</h1>
    </div>
@stop

@section('content')

    {{-- Este if se encarga de comprobar si existe un mensaje de retorno por parte del controlador, en caso de que si, lo despliegará. --}}
    {{-- Este if se encarga de verifcar si el controlador retorno algun texto en la variable info. --}}
    @if (session('info'))
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="card w-75 mx-auto">
        <div class="card-body mx-auto">
            {{-- <h1>Administración de base de datos</h1> --}}
            <h2 class="text-center">Exportación e Importación con archivos .XLSX</h2>
            <div class="d-flex justify-content-center mb-4">
                @can('admin.database.export')
                    <a class="btn btn-danger mt-3" id="exportButton" href="{{ route('admin.database.export') }}">Exportar
                        registros de elementos</a>
                @endcan
                @can('admin.database.import')
                    <a class="btn btn-warning ml-4 mt-3" id="importButton" id="importLink" import-index="1"
                        class="btn btn-danger btn-sm import-link" href="{{ route('admin.database.upload') }}">Importar registros
                        de elementos</a>
                @endcan
            </div>
            <h2 class="text-center">Exportación de la base de datos en archivo .SQL</h2>
            <div class="d-flex justify-content-center">
                @can('admin.database.dump')
                    <a class="btn btn-secondary mt-3 mb-3" id="sqlButton" href="{{ route('admin.database.dump') }}">Exportar
                        base de datos (Respaldo)</a>
                @endcan
            </div>
        </div>
    </div>
@stop

@section('css')
    @vite(['resources/css/adminFormStyles.css'])
@stop

@section('js')
    @vite(['resources/js/themeTitleInyector.js'])

    <script>
        document.getElementById('importButton').addEventListener("click", function() {
            var element = document.getElementById("importButton");
            element.classList.add("disabled");
            setTimeout(function() {
                element.classList.remove("disabled");
            }, 1000);

        });

        document.getElementById('exportButton').addEventListener("click", function() {
            var element = document.getElementById("exportButton");
            element.classList.add("disabled");
            setTimeout(function() {
                element.classList.remove("disabled");
            }, 1000);

        });

        document.getElementById('sqlButton').addEventListener("click", function() {
            var element = document.getElementById("sqlButton");
            element.classList.add("disabled");
            setTimeout(function() {
                element.classList.remove("disabled");
            }, 1000);

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
@stop
