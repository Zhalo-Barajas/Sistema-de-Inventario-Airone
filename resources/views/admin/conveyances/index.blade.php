@extends('adminlte::page')

@section('title', 'Registro de Traspasos')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Registro de Traspasos</h1>
    </div>
@stop

@section('content')

    <div class="card">

        <div class="card-body">
            @if ($viewConveyances->count())

                {{-- botón para crear categoría --}}

                <table class="table table-striped table-responsive">
                    {{-- Columnas donde se despliegan los titulos de los atributos de la tabla. --}}
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th width="400px">Elemento</th>
                            <th width="300px">Ubicación Anterior</th>
                            <th width="200px">Edificio Anterior</th>
                            <th width="300px">Nueva Ubicación</th>
                            <th width="200px">Nuevo Edificio</th>
                            <th width="200px">Fecha Traspaso</th>
                            <th colspan="20"></th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Esta directiva de ciclo foreach recorrerá todas las tuplas de categories y las desplegará en lista. --}}
                        @foreach ($viewConveyances as $conveyance)
                            <tr>
                                {{-- Despliegue de atributos de cada elemento --}}
                                <td>{{ $conveyance->id }}</td>
                                <td>{{ $conveyance->nameElement }}</td>
                                {{-- Este switch se encarga de generar, de acuerdo a el id que hay en oldBuilding_id desplegar el nombre respectivo del edificio --}}
                                @switch($conveyance->oldBuilding_id)
                                    @case(1)
                                        <td>{{ $buildings[0]->nameBuilding }}</td>
                                    @break

                                    @case(2)
                                        <td>{{ $buildings[1]->nameBuilding }}</td>
                                    @break

                                    @case(3)
                                        <td>{{ $buildings[2]->nameBuilding }}</td>
                                    @break

                                    @case(4)
                                        <td>{{ $buildings[3]->nameBuilding }}</td>
                                    @break

                                    @default
                                        <td>
                                            <p>N/A</p>
                                        </td>
                                @endswitch

                                {{-- Este switch se encarga de generar, de acuerdo a el id que hay en oldUbication_id desplegar el nombre respectivo de la ubicación --}}

                                @switch($conveyance->oldUbication_id)
                                    @case(1)
                                        <td>{{ $ubications[0]->nameUbication }}</td>
                                    @break

                                    @case(2)
                                        <td>{{ $ubications[1]->nameUbication }}</td>
                                    @break

                                    @case(3)
                                        <td>{{ $ubications[2]->nameUbication }}</td>
                                    @break

                                    @case(4)
                                        <td>{{ $ubications[3]->nameUbication }}</td>
                                    @break

                                    @case(5)
                                        <td>{{ $ubications[4]->nameUbication }}</td>
                                    @break

                                    @case(6)
                                        <td>{{ $ubications[5]->nameUbication }}</td>
                                    @break

                                    @case(7)
                                        <td>{{ $ubications[6]->nameUbication }}</td>
                                    @break

                                    @case(8)
                                        <td>{{ $ubications[7]->nameUbication }}</td>
                                    @break

                                    @case(9)
                                        <td>{{ $ubications[8]->nameUbication }}</td>
                                    @break

                                    @default
                                        <td>
                                            <p>N/A</p>
                                        </td>
                                @endswitch
                                {{-- //despliegue de atributos recopilados por medio del join para la iteración --}}
                                <td>{{ $conveyance->nameBuilding }}</td>
                                <td>{{ $conveyance->nameUbication }}</td>
                                <td>{{ $conveyance->conveyanceDate }}</td>

                                <td width='10px'>
                                </td>



                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="card-body">No existe ningún registro de Traspasos.</div>


            @endif
            {{-- mini formulario para loggout, requerido debido a que la acción de logout requiere de un metodo POST y su respectivo token CSRF --}}
            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                @csrf
            </form>
        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css">
     --}}
    <style>
        .table-responsive {
            /* En este CSS se añade un scrollbar a la tabla con los registros, se decla a partir de que distancia dse generará */
            max-height: 300px;
        }
    </style>
    @vite(['resources/css/adminFormStyles.css'])
@stop

@section('js')
    @vite(['resources/js/themeTitleInyector.js'])
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
