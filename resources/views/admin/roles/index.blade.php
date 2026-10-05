@extends('adminlte::page')

@section('title', 'Listado de Roles')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Listado de Roles</h1>
    </div>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    {{-- notificación de acción prohibida --}}
    @if (session('info2'))
        <div class="alert alert-danger">
            <i class="fas fa-times"></i>
            <strong>{{ session('info2') }}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            @can('admin.roles.create')
                <a href="{{ route('admin.roles.create') }}" id="createButton" class="btn btn-warning">Crear un nuevo rol</a>
            @endcan
        </div>
        <div class="card-body ">

            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th width="450px">ID</th>
                        <th width="630px">Nombre del Rol</th>
                        <th width="630px">Fecha de Creación del rol</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>

                <tbody>

                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->created_at }}</td>
                            <td width='10px'>
                                @if ($role->id <= 2)
                            <td width='10px'>
                            </td>
                        @else
                            @canany(['admin.roles.edit', 'admin.roles.destroy'])
                                <td width='10px'>
                                    <div class="dropup">
                                        <a class="btn-sm btn-danger dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Acción
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            @can('admin.roles.edit')
                                                <a href="{{ route('admin.roles.edit', $role) }}" class="dropdown-item">Editar</a>
                                            @endcan


                                            @can('admin.roles.destroy')
                                                <form action="{{ route('admin.roles.destroy', $role) }}"
                                                    id="deleteForm-{{ $role->id }}" method="POST">
                                                    @method('delete') {{-- Directiva para llamar al metodo delete (Este va a sustituir al metodo POST para realizar la transacción) --}}
                                                    @csrf {{-- Directiva de Blade para utilizar un token CRSF, necesario para realizar ciertas acciones en la Base de datos. --}}

                                                    <button type="button" class="dropdown-item" data-toggle="modal"
                                                        data-target="#Modal-{{ $role->id }}">Eliminar</button>
                                                    {{-- en data-target="#Modal-{{$tag->id}}" se inserta la id de categoría para poder intercambiar entre modales creado durante el foreach y desplegar correctamente el nombre de la categoria en el POPUP --}}
                                                    {{-- Al hacer click estamos invocando al modal, el modal es un POPUP el cuál contendra la advertencia respectiva antes de elmiminar una categoria. --}}

                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="Modal-{{ $role->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="ModalLabel" aria-hidden="true"> {{-- en id="Modal-{{$tag->id}}" se inserta la id de categoría para poder intercambiar entre modales creado durante el foreach y desplegar correctamente el nombre de la categoria en el POPUP --}}
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
                                                        <p>¿Estás seguro de eliminar el rol {{ $role->nameRole }}?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancelar</button>
                                                        {{-- Botón con el tipo submit, Este botón ejecutará la acción de eliminar la clase. --}}
                                                        <button type="submit" class="btn btn-danger"
                                                            id="deleteButton-{{ $role->id }}">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    @endcan
                                @endcanany

                                {{-- ///////////////////////////////////////////////////// --}}
                    @endif
                    @endforeach
                </tbody>
            </table>

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
