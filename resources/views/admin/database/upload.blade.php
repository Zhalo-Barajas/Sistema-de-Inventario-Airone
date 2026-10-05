@extends('adminlte::page')
{{-- NOTA: TODAS LAS PAGINAS CREADAS/DERIVADAS DE ADMINLTE TRABAJAN CON BOOTSTRAP --}}
@section('title', 'Importación de Elementos')

@section('content_header')

    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Importación de Elementos</h1>
    </div>

@stop

@section('content')

    {{-- Este if se encarga de verifcar si el controlador retorno algun texto en la variable info. --}}
    @if (session('info'))
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    @if (session('infoError'))
        <div class="alert alert-danger mt-2">
            <i class="fas fa-times"></i>
            <strong>{{ session('infoError') }}</strong>
        </div>
    @endif

    {{-- Debido a que Laravel Collective fue descontinuado ya no es compatible con Laravel 11, en su lugar se usará Spatie/Laravel-html para el desarrollo de los formularios --}}
    {{-- Laravel Collective nos permite trabajar con todas las etiquetas de un formulario con logica, es decir que automaticamente prepara todos los datos de los formularios, tambien la informacion restaurada, tambien recopila información de las relaciones de bases de datos --}}
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                @can('admin.database.import')
                    {{ html()->label('Seleccione el archivo a importar:') }}

                    <form action="{{ route('admin.database.import') }}" method="POST" id="uploadForm"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- <input class="btn btn-primary " type="file" name="import" required> --}}
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="import" id="customFile"
                                accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" required>
                            <label class="custom-file-label" for="customFile">Seleccionar archivo .XLSX</label>
                        </div>
                        @error('import')
                            <br>
                            <small class="text-danger">{{ $message }}</small>
                            <br>
                        @enderror
                    @endcan
                    <button class="btn btn-danger mt-2" id="submitButton" type="submit">Subir archivo</button>
                </form>




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
            document.getElementById('uploadForm').addEventListener('submit', function() {
                document.getElementById('submitButton').disabled = true;
            });
        </script>

        <script>
            document.querySelector('.custom-file-input').addEventListener('change', function(e) {
                var fileName = document.getElementById("customFile").files[0].name;
                var nextSibling = e.target.nextElementSibling;
                nextSibling.innerText = fileName;
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
