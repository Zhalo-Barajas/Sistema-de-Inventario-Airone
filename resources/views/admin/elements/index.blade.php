@extends('adminlte::page')
{{-- NOTA: TODAS LAS PAGINAS CREADAS/DERIVADAS DE ADMINLTE TRABAJAN CON BOOTSTRAP --}}
@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Lista de Elementos</h1>
    </div>

    @if (session('info'))
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

@stop

@section('content')

    @livewire('admin.element-index')
    {{-- mini formulario para loggout, requerido debido a que la acción de logout requiere de un metodo POST y su respectivo token CSRF --}}
    <form method="POST" id="logout-form" action="{{ route('logout') }}">
        @csrf
    </form>

@stop

@section('css')
    <style>
        .dropdown-menu {
            min-width: 60px !important;
        }

        .table-responsive {
            max-height: 4000px;
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
