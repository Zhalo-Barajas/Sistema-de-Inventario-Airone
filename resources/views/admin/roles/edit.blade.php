@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Editar Rol</h1>
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

            {{ html()->form('PUT')->route('admin.roles.update', ['role' => $role])->id('rolesForm')->open() }}

            <div class="form-group">
                {{ html()->label('Nombre del Rol') }}
                {{ html()->text('name', $role->name)->placeholder('Ingrese el nombre del rol')->addClass('form-control')->attributes(['maxlength' => 50, 'autocomplete' => 'off'])->required('required') }}

                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>
        </div>
        <div class="card-body">
            <h2 class="h3 text-center mb-3"> Lista de permisos</h2>

            <h4>Acceso al Panel de administración</h4>
            @foreach ($permissions as $permission)
                <div>
                    <label>
                        {{-- Aquí, $role->permissions && verifica que $role->permissions no sea null 
                        antes de continuar con la llamada a in_array() y pluck(). 
                        Si $role->permissions  es null, la expresión se evaluará como false, 
                        evitando así la llamada a pluck().  --}}
                        {{-- $role->permissions->pluck('id') crea un array asociativo donde
                     la clave es el ID del permiso esto es necesario para crear las opciones del select. --}}
                        @if ($permission->id == 2)
                            <h4 class="mt-3 mb-3">Administración de Categorías</h4>
                        @endif
                        @if ($permission->id == 6)
                            <h4 class="mt-3 mb-3">Administración de Elementos</h4>
                        @endif
                        @if ($permission->id == 10)
                            <h4 class="mt-3 mb-3">Administración de Etiquetas</h4>
                        @endif
                        @if ($permission->id == 14)
                            <h4 class="mt-3 mb-3">Administración de Fondos</h4>
                        @endif
                        @if ($permission->id == 18)
                            <h4 class="mt-3 mb-3">Administración de Roles y Usuarios</h4>
                        @endif
                        @if ($permission->id == 24)
                            <h4 class="mt-3 mb-3">Administración de Mantenimientos y visibilidad de Traspasos</h4>
                        @endif
                        @if ($permission->id == 28)
                            <h4 class="mt-3 mb-3">Administración de Importaciones/Exportaciones</h4>
                        @endif
                        @if ($permission->id == 32)
                            <h4 class="mt-3 mb-3">Administración de Calendario de eventos y Notificaciones</h4>
                        @endif
                        {{ html()->checkbox('permissions[]', $role->permissions && in_array($permission->id, $role->permissions->pluck('id')->toArray()), $permission->id)->addClass('mr-1mt-3 ') }}
                        {{-- {!! Form::checkbox('permissions[]', , null, ['class' => 'mr-1']) !!} --}}
                        {{ $permission->description }}
                    </label>
                </div>
            @endforeach

            {{ html()->submit('Crear rol')->id('submitButton')->addClass('btn btn-danger btn-block w-25 mt-4') }}

            {{ html()->form()->close() }}
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
        document.getElementById('rolesForm').addEventListener('submit', function() {
            document.getElementById('submitButton').disabled = true;
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
