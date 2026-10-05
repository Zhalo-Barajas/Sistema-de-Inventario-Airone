@extends('adminlte::page')

@section('title', 'Listado de Etiquetas')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Listado de Etiquetas</h1>
    </div>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            @can('admin.tags.create')
                <a class="btn btn-warning" id="createButton" href="{{ route('admin.tags.create') }}">Agregar Etiqueta</a>
            @endcan
        </div>
        <div class="card-body">

            {{-- Directiva blade can para desplegar botón agregar categoria según el permiso del usuario. --}}

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre de la Etiqueta</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($tags as $tag)
                        <tr>
                            <td>{{ $tag->id }}</td>
                            <td>{{ $tag->nameTag }}</td>
                            <td width='10px'>

                                @canany(['admin.tags.edit', 'admin.tags.destroy'])
                                <td width='10px'>
                                    <div class="dropup">
                                        <a class="btn-sm btn-danger dropdown-toggle" href="#" role="button"
                                            id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Acción
                                        </a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                            @can('admin.tags.edit')
                                                <a href="{{ route('admin.tags.edit', $tag) }}" class="dropdown-item">Editar</a>
                                            @endcan


                                            @can('admin.tags.destroy')
                                                <form action="{{ route('admin.tags.destroy', $tag) }}"
                                                    id="deleteForm-{{ $tag->id }}" method="POST">
                                                    @csrf {{-- Directiva de Blade para utilizar un token CRSF, necesario para realizar ciertas acciones en la Base de datos. --}}
                                                    @method('delete') {{-- Directiva para llamar al metodo delete (Este va a sustituir al metodo POST para realizar la transacción) --}}
                                                    <button type="button" class="dropdown-item" data-toggle="modal"
                                                        data-target="#Modal-{{ $tag->id }}">Eliminar</button>
                                                    {{-- en data-target="#Modal-{{$tag->id}}" se inserta la id de categoría para poder intercambiar entre modales creado durante el foreach y desplegar correctamente el nombre de la categoria en el POPUP --}}
                                                    {{-- Al hacer click estamos invocando al modal, el modal es un POPUP el cuál contendra la advertencia respectiva antes de elmiminar una categoria. --}}

                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="Modal-{{ $tag->id }}" tabindex="-1" role="dialog"
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
                                                        <p>¿Estás seguro de eliminar la etiqueta {{ $tag->nameTag }}?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancelar</button>
                                                        {{-- Botón con el tipo submit, Este botón ejecutará la acción de eliminar la clase. --}}
                                                        <button type="submit" class="btn btn-danger"
                                                            id="deleteButton-{{ $tag->id }}">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    @endcan
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
    {{-- Script Limitación de presionado de botones a 1 solo. --}}
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
