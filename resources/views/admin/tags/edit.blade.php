@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Editar etiqueta</h1>
    </div>
@stop

@section('content')

    @if (session('info'))
        <div class="alert alert-success">
            <i class="fas fa-check"></i>
            <strong>{{ session('info') }}</strong>
        </div>
    @endif

    @if (session('info2'))
        <div class="alert alert-info">
            <i class="fas fa-info"></i>
            <strong>{{ session('info2') }}</strong>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            {{-- Aqui se abre la etiqueta del form de laravel collectiva --}}
            {{ html()->form('PUT')->route('admin.tags.update', ['tag' => $tag])->id('tagsForm')->open() }}
            {{-- Llamada a los ruta que vamos a utilizar --}}
            {{-- de manera implicita si no asignamos el metodo de retorno usará POST --}}
            {{-- Para los metodos edit se invocará a la variable $tag asi: ['tag' => $tag] --}}
            <div class="form-group">
                {{ html()->label('Nombre de la etiqueta') }}
                {{ html()->text('nameTag', $tag->nameTag)->placeholder('Ingrese el nombre de la etiqueta')->addClass('form-control ')->attributes(['maxlength' => 50, 'autocomplete' => 'off'])->required('required') }}

                @error('nameTag')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>


            <div class="form-group">
                {{ html()->label('Slug') }}
                {{ html()->text('slug', $tag->slug)->placeholder('Slug de la categoría')->addClass('form-control')->isReadonly() }}

                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{ html()->label('Color de la etiqueta') }}
            {{ html()->select('color', $colors, $tag->color)->addClass('form-control') }}
            {{-- {!! Form::select('color', $colors, null, ['class' => 'form-control']) !!} --}}
            {{-- Este form generara un recuadro automaticamente de acuerdo a un arreglo del controlador (Arreglo $colors) --}}
            @error('color')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            <br>
            {{ html()->submit('Actualizar Etiqueta')->addClass('btn btn-danger')->id('submitButton') }}

            {{ html()->form()->close() }}

            {{-- mini formulario para loggout, requerido debido a que la acción de logout requiere de un metodo POST y su respectivo token CSRF --}}
            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                @csrf
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
        document.getElementById('tagsForm').addEventListener('submit', function() {
            document.getElementById('submitButton').disabled = true;
        });
    </script>

    <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#nameTag").stringToSlug({
                //En el #se insertará el nombre del espacio del forumlario en estee caso es name.
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                // En esta parte se inserta en que parte del formulario se insertará lasalida de la conversion en el formulario, se le asigno el campo de slug
                space: '-'
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
@endsection
