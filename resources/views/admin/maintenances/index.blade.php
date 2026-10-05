@extends('adminlte::page')
{{-- NOTA: TODAS LAS PAGINAS CREADAS/DERIVADAS DE ADMINLTE TRABAJAN CON BOOTSTRAP --}}
@section('title', 'Dashboard')

@section('content_header')

    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Listado de mantenimientos</h1>
    </div>

    @if (session('info'))
        <div class="alert alert-success mt-3">
            <i class="fas fa-check"></i>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

@stop

@section('content')

    <div class="card">

        <div class="card-body">

            @if ($viewMaintenances->count())

                <table class="table table-striped table-responsive">
                    {{-- Columnas donde se despliegan los titulos de los atributos de la tabla. --}}
                    <thead>
                        <tr>
                            <th>ID Registro</th>
                            <th>ID Elemento</th>
                            <th width="550px">Elemento</th>
                            <th width="350px">Fecha de Mantenimiento Anterior</th>
                            <th width="350px">Fecha de Mantenimiento</th>
                            {{-- <th>Descripción Mantenimiento</th> --}}
                            @can('admin.maintenances.print')
                                <th>Generar Documento</th>
                            @else
                                <th width="200px">&nbsp;</th>
                            @endcan
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Esta directiva de ciclo foreach recorrerá todas las tuplas de categories y las desplegará en lista. --}}
                        @isset($viewMaintenances)
                            @foreach ($viewMaintenances as $viewMaintenance)
                                <tr>
                                    {{-- Despliegue de atributos de cada elemento --}}
                                    <td>{{ $viewMaintenance->id }}</td>
                                    <td>{{ $viewMaintenance->element_id }}</td>
                                    <td>{{ $viewMaintenance->nameElement }}</td>
                                    <td>{{ $viewMaintenance->oldMaintenanceDate }}</td>
                                    <td>{{ $viewMaintenance->maintenanceDate }}</td>
                                    <td width='20px'>
                                        @can('admin.maintenances.print')
                                            <a href="{{ route('admin.maintenances.print', ['maintenance' => $viewMaintenance]) }}"
                                                id="printLink-{{ $viewMaintenance->id }}" print-index="{{ $viewMaintenance->id }}"
                                                target="_blank" class="btn btn-danger btn-sm print-link"><i
                                                    class="fas fa-print"></i>Imprimir</a>
                                        @endcan
                                    </td>
                                    <td width='10px'></td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            @else
                <div class="card-body">No existe ningún registro de Mantenimientos.</div>


            @endif
            {{-- mini formulario para loggout, requerido debido a que la acción de logout requiere de un metodo POST y su respectivo token CSRF --}}
            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                @csrf
            </form>


        </div>
    </div>
@stop

@section('css')
    <style>
        .table-responsive {
            max-height: 2000px;
        }
    </style>
@stop

@section('js')
    @vite(['resources/js/themeTitleInyector.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los enlaces que tienen la clase "delete-link"
            var links = document.querySelectorAll('.print-link');

            // Función para habilitar todos los enlaces
            function enableLinks() {
                links.forEach(function(link) {
                    link.style.pointerEvents = '';
                    link.style.opacity = '';
                });
            }

            // Verifica el estado de los enlaces al cargar la página
            if (sessionStorage.getItem('linksDisabled')) {
                sessionStorage.removeItem('linksDisabled');
                enableLinks();
            }

            links.forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Previene el comportamiento por defecto del enlace

                    var index = link.getAttribute('print-index');

                    // Deshabilita el enlace
                    link.style.pointerEvents = 'none';
                    link.style.opacity =
                        '0.5'; // Opcional: Para dar una indicación visual de que el enlace está deshabilitado

                    // Guarda el estado en sessionStorage
                    sessionStorage.setItem('linksDisabled', 'true');

                    // Redirige a la URL del enlace
                    window.open(link.href, '_blank');

                    setTimeout(function() {
                        console.log('waos');
                        enableLinks();
                    }, 2000); // 3000 milliseconds = 3 seconds
                });
            });

            // // Rehabilita los enlaces si el usuario regresa a la página
            // window.addEventListener('pageshow', function(event) {
            //     if (event.persisted) {
            //         enableLinks();
            //     }
            // });
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
