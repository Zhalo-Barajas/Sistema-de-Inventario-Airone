@extends('adminlte::page')

@section('title', 'Listado de Usuarios')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Listado de Usuarios</h1>
    </div>
@stop

@section('content')
    @livewire('admin.users-index')
    {{-- llamada a componente de livewire users-index creado, esta es la barra de busqueda --}}
@stop

@section('css')
    @vite(['resources/css/adminFormStyles.css'])
@stop

@section('js')
    @vite(['resources/js/themeTitleInyector.js'])
@stop
