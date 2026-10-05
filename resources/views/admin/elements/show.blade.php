@extends('adminlte::page')
{{-- NOTA: TODAS LAS PAGINAS CREADAS/DERIVADAS DE ADMINLTE TRABAJAN CON BOOTSTRAP --}}
@section('title', 'Detalles de Registro')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Detalles del elemento</h1>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h2 class="text-justify">{{ $element->nameElement }}</h2>
        </div>
        <div class="card-body">
            @isset($element->image)
                <div class="d-flex justify-content-around">
                    <img id="picture" class=" rounded mx-auto d-block img-fluid"
                        src="{{ Storage::url($element->image->url) }}">
                </div>
            @else
                <div class="d-flex justify-content-around">
                    <img id="picture" class="img-fluid" src="/../imagenes/luna.webp" alt="luna">
                </div>

                <p class="mt-3 text-center">El elemento no tiene una imagen, puede añadir una <a
                        href="{{ route('admin.elements.edit', $element) }}" style="color: #B91116"> aquí.</a></p>
            @endisset
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="text-center mb-3 mt-4">Descripción del elemento:</h2>
            <p>{{ $element->description }}</p>
        </div>
        <div class="card-body">
            <div class="card-body">
                <h2 class="text-center mb-4">Atributos del elemento:</h2>
                <table class="table table-striped table-responsive ">
                    <tbody>
                        <tr>
                            <th style="width: 10%">ID del elemento:</th>
                            {{-- <td>{{$element->id}}</td> --}}
                        </tr>
                        <tr>
                            <td>{{ $element->id }}</td>
                        </tr>
                        <tr>
                            <th>Nombre del elemento:</th>
                            {{-- <td>{{$element->id}}</td> --}}
                        </tr>
                        <tr>
                            <td>{{ $element->nameElement }}</td>
                        </tr>
                        <tr>
                            <th>Status de Inventario:</th>
                            {{-- <td>{{$element->id}}</td> --}}
                        </tr>
                        <tr>
                            @if ($element->statusInv == 2)
                                <td>Alta</td>
                            @else
                                <td>Baja</td>
                            @endif
                            {{-- <td>{{$element->nameElement}}</td> --}}
                        </tr>
                        <tr>
                            <th>Fecha de Adquisición:</th>
                        </tr>
                        <tr>
                            <td>{{ $element->adquisitionDate }}</td>
                            {{-- <td>{{$element->id}}</td> --}}
                        </tr>
                        <tr>
                            <th>Fecha de Último Mantenimiento:</th>
                        </tr>
                        <tr>
                            <td>{{ $element->maintenanceDate }}</td>
                            {{-- <td>{{$element->id}}</td> --}}
                        </tr>
                        <tr>
                            <th>Edificio donde se encuentra el elemento:</th>
                        </tr>
                        <tr>
                            <td>{{ $element->nameBuilding }}</td>
                        </tr>
                        <tr>
                            <th>Ubicación dentro del edificio donde se encuentra el elemento:</th>
                        </tr>
                        <tr>
                            <td>{{ $element->nameUbication }}</td>
                        </tr>
                        <tr>
                            <th>Fondo del elemento:</th>
                        </tr>
                        <tr>
                            <td>{{ $element->nameFund }}</td>
                        </tr>
                        <tr>
                            <th>Categoría a la que pertenece el elemento:</th>
                        </tr>
                        <tr>
                            <td>{{ $element->nameCategory }}</td>
                        </tr>
                        <tr>
                            <th>Etiquetas a la que pertenece el elemento:</th>
                        </tr>
                        <tr>
                            <td>
                                @if ($element->tags != '[]')
                                    @foreach ($element->tags as $tag)
                                        <div class="w-25 text-center">
                                            <p class="text-light text-center mb-1 mt-1"
                                                style="font-size: 15px; border-radius: 5px; background-color: {{ $tag->color }}">
                                                {{ $tag->nameTag }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <p>El elemento no tiene etiquetas, puede añadirlas <a
                                            href="{{ route('admin.elements.edit', $element) }}" style="color: #B91116">
                                            aquí.</a></p>
                                @endif

                            </td>
                        </tr>
                        @isset($atributes)
                            @switch($element->category_id)
                                @case(1)
                                    <tr>
                                        <th>Marca del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->brand }}</td>
                                    </tr>
                                    <tr>
                                        <th>Modelo del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->model }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de Serie del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->serialNumber }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de Inventario del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->invNumber }}</td>
                                    </tr>
                                @break

                                @case(2)
                                    <tr>
                                        <th>Número de Serie del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->serialNumber }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de Inventario del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->invNumber }}</td>
                                    </tr>
                                    <tr>
                                        <th>Color del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->color }}</td>
                                    </tr>
                                    <tr>
                                        <th>Material del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->material }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dimensiones del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->dimensions }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de estantes del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->shelves }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de puertas del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->shelves }}</td>
                                    </tr>
                                @break

                                @case(3)
                                    <tr>
                                        <th>Color del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->color }}</td>
                                    </tr>
                                    <tr>
                                        <th>Material del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->material }}</td>
                                    </tr>
                                    <tr>
                                        <th>Dimensiones del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->dimensions }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de unidades de este elemento (Stock):</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->quantity }}</td>
                                    </tr>
                                @break

                                @case(4)
                                    <tr>
                                        <th>Marca del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->brand }}</td>
                                    </tr>
                                    <tr>
                                        <th>Modelo del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->model }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de Serie del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->serialNumber }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de Inventario del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->invNumber }}</td>
                                    </tr>
                                @break

                                @case(5)
                                    <tr>
                                        <th>Marca del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->brand }}</td>
                                    </tr>
                                    <tr>
                                        <th>Modelo del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->model }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de Serie del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->serialNumber }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de Inventario del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->invNumber }}</td>
                                    </tr>
                                @break

                                @case(6)
                                    <tr>
                                        <th>Marca del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->brand }}</td>
                                    </tr>
                                    <tr>
                                        <th>Modelo del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->model }}</td>
                                    </tr>
                                    <tr>
                                        <th>Número de Inventario del elemento:</th>
                                    </tr>
                                    <tr>
                                        <td>{{ $atributes->invNumber }}</td>
                                    </tr>
                                    @if ($atributes->typeExt != 'N/A')
                                        <tr>
                                            <th>Tipo de Extintor:</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $atributes->typeExt }}</td>
                                        </tr>
                                        <tr>
                                            <th>Capacidad:</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $atributes->capacity }}</td>
                                        </tr>
                                    @endif
                                @break

                                @default
                                @break
                            @endswitch
                        @else
                            <td><b>El elemento no contiene un registro de atributos adicionales, edita el elemento<a
                                        href="{{ route('admin.elements.edit', $element) }}" style="color: #B91116">
                                        aquí.</a></b></td>
                        @endisset

                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <form method="POST" id="logout-form" action="{{ route('logout') }}">
        @csrf
    </form>

@stop

@section('css')
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
