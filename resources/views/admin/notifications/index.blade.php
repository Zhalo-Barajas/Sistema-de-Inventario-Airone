@extends('adminlte::page')
{{-- NOTA: TODAS LAS PAGINAS CREADAS/DERIVADAS DE ADMINLTE TRABAJAN CON BOOTSTRAP --}}
@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Generación de Notificaciones</h1>
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
        <div class="card-body">


            {{ html()->form('POST')->route('admin.notifications.send')->id('notificationForm')->open() }}

            {{-- {{ html()->submit('Enviar notificación')->addClass('btn btn-primary') } --}}
            {{-- Mensaje será enviado hacia el grupo --}}
            {{ html()->hidden('chat_id', '-1002217220233') }}
            {{ html()->label('Ingrese el mensaje que desea difundir en el grupo.') }}
            {{-- Mensaje será enviado a mí --}}
            {{-- {{ html()->hidden('chat_id', "5486344722") }} --}}
            {{ html()->textarea('message', null)->placeholder('Inserte el mensaje a publicar. MAX: 2000 caracteres.')->addClass('form-control mb-3')->required('required')->attributes(['maxlength' => 2000, 'autocomplete' => 'off']) }}
            {{ html()->submit('Enviar notificación')->addClass('btn btn-danger')->id('submitButton') }}


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
        document.getElementById('notificationForm').addEventListener('submit', function() {
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
