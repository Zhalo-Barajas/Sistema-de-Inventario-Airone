@extends('adminlte::page')

@section('title', 'Asignación de Roles')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Asignación de roles</h1>
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
        <div class="card-body">
            <p class="h5">Nombre del usuario:</p>
            <p class="form-control disabled">{{ $user->name }}</p>


            <h2 class="h5">Listado de roles</h2>
            {{-- Creación de formilario para actualización de roles a un usuario. --}}
            {{ html()->form('PUT')->route('admin.users.update', ['user' => $user])->id('rolesForm')->open() }}
            {{-- Ciclo dedicado a desplegar todos los roles disponibles --}}
            @foreach ($roles as $role)
                <div class="d-flex align-content-around flex-wrap">
                    <label>
                        {{-- Checkbox del formulario, en este se despliega en un arreglo los roles existentes, 
                                en la segunda condición si el usuario a modificar posee del rol se marcará la 
                                casilla respectiva, y enviará cada checkbox el id del rol para la labor de 
                                actualización/sincronicación en el controlador.  --}}

                        {{ html()->checkbox('roles[]', $user->hasRole($role->name), $role->id) }}
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
            {{-- botón para subir formulario  --}}
            {{ html()->submit('Asignar rol')->addClass('btn btn-danger mt-2')->id('submitButton') }}
            {{ html()->form()->close() }}


        </div>
    </div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
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
