@extends('adminlte::page')
{{-- NOTA: TODAS LAS PAGINAS CREADAS/DERIVADAS DE ADMINLTE TRABAJAN CON BOOTSTRAP --}}
@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Lista de fondos</h1>
    </div>
@stop

@section('content')

    {{-- Este if se encarga de comprobar si existe un mensaje de retorno por parte del controlador, en caso de que si, lo despliegará. --}}
    @if (session('info'))
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif



    <div class="card">
        <div class="card-header">
            {{-- botón para crear nuevo fondo --}}
            @can('admin.funds.create')
                <a class="btn btn-warning" id="createButton" href="{{ route('admin.funds.create') }}">Agregar Fondo</a>
            @endcan
        </div>
        <div class="card-body">



            <table class="table table-striped">
                {{-- Columnas donde se despliegan los titulos de los atributos de la tabla. --}}
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre del Fondo</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>

                <tbody>
                    {{-- Esta directiva de ciclo foreach recorrerá todas las tuplas de funds y las desplegará en lista. --}}
                    @foreach ($funds as $fund)
                        <tr>
                            {{-- Despliegue de atributos de cada elemento --}}
                            <td>{{ $fund->id }}</td>
                            <td>{{ $fund->nameFund }}</td>
                            <td width='10px'>

                                @canany(['admin.categories.edit', 'admin.categories.destroy'])
                                    @if ($fund->id <= 7)
                                <td width='10px'>
                                </td>
                            @else
                                <td width='10px'>
                                    <div class="dropdown">
                                        <a class="btn-sm btn-danger dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Acción
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            @can('admin.categories.edit')
                                                <a href="{{ route('admin.funds.edit', $fund) }}" class="dropdown-item">Editar</a>
                                            @endcan


                                            @can('admin.funds.destroy')
                                                <form action="{{ route('admin.funds.destroy', $fund) }}"
                                                    id="deleteForm-{{ $fund->id }}" method="POST">
                                                    @csrf {{-- Directiva de Blade para utilizar un token CRSF, necesario para realizar ciertas acciones en la Base de datos. --}}
                                                    @method('delete') {{-- Directiva para llamar al metodo delete (Este va a sustituir al metodo POST para realizar la transacción) --}}
                                                    <button type="button" class="dropdown-item" data-toggle="modal"
                                                        data-target="#Modal-{{ $fund->id }}">Eliminar</button>
                                                    {{-- en data-target="#Modal-{{$fund->id}}" se inserta la id de categoría para poder intercambiar entre modales creado durante el foreach y desplegar correctamente el nombre de la categoria en el POPUP --}}
                                                    {{-- Al hacer click estamos invocando al modal, el modal es un POPUP el cuál contendra la advertencia respectiva antes de elmiminar una categoria. --}}


                                            </div>
                                        </div>
                                    </td>


                                    {{-- Invocación de directiva de blade Can, con esta se comprueba si el usuario posee de permisos para comprobar si un usuario puede realizar una 
                                acción o, en este caso, apreciar un botón, en este caso se está utilziando la directiva con el permiso admin.cateogries.edit creado, si 
                                se posee de este categoria se podrá acceder al botón de edición, en caso contrario, no aparecerá. --}}
                                    {{-- @can('admin.categories.edit')
                                <a href="{{route('admin.categories.edit', $fund)}}" id="editButton" class="btn btn-primary btn-sm">Editar</a> 
                            @endcan --}}

                                    {{-- //Los enlaces solo pueden manejar peticiones get --}}
                                    </td>
                                    <td width='10px'>

                                        {{-- Llamada a directiva blade can para botón  de eliminación de categoria --}}



                                        <!-- Modal -->
                                        <div class="modal fade" id="Modal-{{ $fund->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="ModalLabel" aria-hidden="true"> {{-- en id="Modal-{{$fund->id}}" se inserta la id de categoría para poder intercambiar entre modales creado durante el foreach y desplegar correctamente el nombre de la categoria en el POPUP --}}
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="ModalLabel">Advertencia.</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{-- Llamada al nombre de la categoria --}}
                                                        <p>¿Estás seguro de eliminar el fondo {{ $fund->nameFund }}? Esta acción
                                                            tambien eliminará todos los elementos registrados pertenecientes a este
                                                            fondo.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancelar</button>
                                                        {{-- Botón con el tipo submit, Este botón ejecutará la acción de eliminar la clase. --}}
                                                        <button type="submit" class="btn btn-danger"
                                                            id="deleteButton-{{ $fund->id }}">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        </form>
                                    @endcan
                        @endif
                    @endcanany
                    </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            {{-- mini formulario para loggout, requerido debido a que la acción de logout requiere de un metodo POST y su respectivo token CSRF --}}
            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                @csrf
            </form>
        </div>
    </div>
@stop

@section('css')
    <style>
        .dropdown-menu {
            min-width: 60px !important;
        }
    </style>

    @vite(['resources/css/adminFormStyles.css'])
@stop

@section('js')
    @vite(['resources/js/themeTitleInyector.js'])
    <script>
        document.getElementById('createButton').addEventListener("click", function() {
            var element = document.getElementById("createButton");
            element.classList.add("disabled");
            setTimeout(function() {
                element.classList.remove("disabled");
            }, 1000);

        });

        ///Lo que se realiza en esta parte del script es recopilar todos las etiquetas con una id exclusiva del elemente, y se corresponderá de ,anera exclusiva el inhabilitado, así no se romperá si existe más de 1 1 botón eliminar.
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona todos los formularios que tienen el id que empieza con "deleteForm-"
            var forms = document.querySelectorAll('form[id^="deleteForm-"]');

            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    // Obtiene el índice del formulario del id del formulario
                    var formId = form.id.split('-')[1];
                    // Deshabilita el botón correspondiente
                    document.getElementById('deleteButton-' + formId).disabled = true;
                });
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
@stop
