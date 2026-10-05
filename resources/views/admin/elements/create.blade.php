@extends('adminlte::page')

@section('title', 'Registro de Elemento')

@section('content_header')
    <div class="d-flex flex-row mb-1 pb-1">
        <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
        <h1 class=" mr-3 my-auto">Registro de Elemento</h1>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="form-group">


                {{-- Aqui se abre la etiqueta del form de Spatie/Laravel-HTML --}}
                {{-- Con form('post') mencionamos el metodo que va a utulizar el formulario, 
                    (Este metodo puede ser GET/HEAD,POST,PUT(Actualización),DELETE(Borrar)).
                    En route hacemos la Llamada a la ruta que vamos a utilizar, el metodo acceptsFiles()
                     es para habilitar que el formulario reciba archivos (En este caso Imágenes) y con open() abrimos el formulario en sí. --}}
                {{ html()->form('POST')->route('admin.elements.store')->attributes(['autocomplete' => 'off'])->id('elementsForm')->acceptsFiles()->open() }}
                {{-- Añadido deshabilitado de autocompletar --}}

                {{-- Con el método hidden, podemos generar y rellenar un apartado del 
                        formulario de manera discreta (Sin que el usuario tenga que insertar
                         datos de manera manual), en este caso lo que queromos decir en 
                         este metodo es que el atributo será para la columna user_id y su 
                         valor sera el id del usuario actual (valor el cual es recopilado del
                         conjunto de metodos siguiente manera: auth()->user()->id ) --}}
                {{-- {{ html()->hidden('user_id', auth()->user()->id) Esta acción del formulario fue deshabilita debido a que ya se está realizando en el Observer ElementObserver }} --}}

                {{-- El metodo label siver para generar insertar una etiqueta/texto dento del formulario --}}
                {{ html()->label('Nombre del elemento') }}
                {{-- En este apartado (text) mencionamos en el metodo text que insertaremos un valor para el campo nameElement,
                        el null quiere decir que no habra algún dato preestablecido en ese apartado, este será utilizado en vistas como edit.
                        el metodo placeholder nos permite mostrar un texto si no hay nada escrito en el form, addClass sirve para agregar a ese elemento del formulario clases de CSS (Pueden ser inclusive de bootstrap o más librerias) --}}
                {{ html()->text('nameElement', null)->placeholder('Ingrese el nombre del elemento')->addClass('form-control')->required('required')->attributes(['maxlength' => 50, 'autocomplete' => 'off']) }}
                {{--  con maxlength limitados el número de caracteres que puede tener la entrada po medio del frontend --}}

                {{-- DIrectiva de blade que captura errores si se detectan excepciones errores en el request --}}
                @error('nameElement')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

            </div>


            <div class="form-group">
                {{ html()->label('Slug') }}

                {{-- En esta ocación la casilla es unicamente para lectura (El usuario no puede modificarla,), esto es posible con el metodo isReadonly() --}}
                {{ html()->text('slug')->placeholder('Slug del elemento')->addClass('form-control')->isReadonly() }}
                @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- Desplegable con las categorias existentes --}}
            <div class="d-flex justify-content-around">
                {{ html()->label('Categoría') }}
                {{ html()->label('Fondo') }}
            </div>

            <div class="d-flex justify-content-around">
                {{-- Este campo del formulario es de selección desplegable, en este caso es para el campo category_id, usaremos la variable $categories (Variable generada desde el controlador) para desplegar los datos --}}
                {{ html()->select('category_id', $categories, null)->id('selectCategory_id')->addClass('form-control col-3')->placeholder('Selecciona una categoría') }}
                {{-- Añadido id 'selectCategory_id', será utilizado en el Javascript para leer la entrada de este input --}}
                {{ html()->select('fund_id', $funds, null)->addClass('form-control col-3')->placeholder('Selecciona un fondo') }}
            </div>

            <div class="d-flex justify-content-around">
                @error('category_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror

                @error('fund_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4"></div>

            {{-- Checkboxes con las etiquetas existentes --}}
            <div class="form-group">
                <p class="font-weight-bold">Etiquetas</p>
                {{-- Llamada a un directiva de blade para recorrer los valores de la variable $tags traida del controlador --}}
                @foreach ($tags as $tag)
                    <label class="mr-2">

                        {{-- EN este caso se abren las casillas para un checkbox, en el metodo checkbox 
                                 Al incluir [] al final del nombre de la variable, indica que el campo tags
                                 será tratado como un array cuando se envíe el formulario. en el lado de false 
                                 se determina si la casilla de verificación está marcada o no por defecto.  
                                 En $tag->id es el valor que se enviará al servidor si la casilla de 
                                 verificación está marcada. En este caso, el valor del ID del tag.  --}}
                        {{ html()->checkbox('tags[]', false, $tag->id) }}
                        {{-- En esta linea se imprime el nombre de cada etiqueta --}}
                        {{ $tag->nameTag }}
                    </label>
                @endforeach

                @error('tags')
                    <br>
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            {{-- Desplegable con las categorias existentes --}}
            <div class="d-flex justify-content-around">
                {{ html()->label('Edificio') }}
                {{ html()->label('Ubicación') }}
            </div>
            <div class="d-flex justify-content-around">
                {{ html()->select('building_id', $buildings, null)->addClass('form-control col-3')->placeholder('Selecciona un edificio') }}
                {{ html()->select('ubication_id', $ubications, null)->addClass('form-control col-3')->placeholder('Selecciona una ubicación') }}
                {{-- Desplegable con las ubicaciones existentes --}}
            </div>
            <div class="d-flex justify-content-around">
                @error('building_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('ubication_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4"></div>





            <div class="d-flex justify-content-around ml-4">
                {{ html()->label('Fecha de Adquisición') }}
                {{ html()->label('Fecha de último mantenimiento') }}
            </div>

            <div class="d-flex justify-content-around mb-3">
                {{-- Aqui es un campo de formulario para insertar una fecha --}}
                {{ html()->date('adquisitionDate', null, true)->addClass('form-control col-2') }}
                {{ html()->date('maintenanceDate', null, true)->addClass('form-control col-2') }}
            </div>

            <div class="d-flex justify-content-around mb-3">
                @error('adquisitionDate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('maintenanceDate')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                {{ html()->label('Descripción') }}
                {{ html()->textarea('description', null)->addClass('form-control')->attributes(['maxlength' => 2500, 'autocomplete' => 'off'])->placeholder('Ingrese una descripción del elemento ')->required('required') }}
                {{-- Añadido limite de caracteres a 4000 --}}

                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            {{-- Formularios para atributos adicionales --}}

            {{-- Fragmentos de formulario que se depslegarán de acuerdo a la categoria --}}
            <div id="FormularioParte1" style="display: none;">
                <div class="form-group">
                    {{ html()->label('Marca') }}
                    {{ html()->text('brand', null)->placeholder('Ingrese la marca del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                    @error('brand')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    {{ html()->label('Modelo') }}
                    {{ html()->text('model', null)->placeholder('Ingrese el modelo del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                    @error('model')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div id="FormularioParte2" style="display: none;">
                <div class="form-group">
                    {{ html()->label('Número de inventario') }}
                    {{ html()->text('invNumber', null)->placeholder('Ingrese el número de inventario del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                    @error('invNumber')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div id="FormularioParte3" style="display: none;">
                <div class="form-group">
                    {{ html()->label('Número de serie') }}
                    {{ html()->text('serialNumber', null)->placeholder('Ingrese el número de serie del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                    @error('serialNumber')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>


            <div id="FormularioParte4" style="display: none;">
                <div class="form-group">
                    {{ html()->label('Color') }}
                    {{ html()->text('color', null)->placeholder('Ingrese el color del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                </div>

                <div class="form-group">
                    {{ html()->label('Material') }}
                    {{ html()->text('material', null)->placeholder('Ingrese el material del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                </div>

                <div class="form-group">
                    {{ html()->label('Dimensiones') }}
                    {{ html()->text('dimensions', null)->placeholder('Ingrese las dimensiones del elemento')->addClass('form-control')->attributes(['maxlength' => 255, 'autocomplete' => 'off']) }}
                </div>
            </div>

            <div id="FormularioParte5" style="display: none;">
                <div class="form-group">
                    {{ html()->label('Estantes') }}
                    {{ html()->number('shelves', null, 0, 50)->placeholder('Ingrese las cantidad de estantes que tiene el elemento')->addClass('form-control') }}
                </div>

                <div class="form-group">
                    {{ html()->label('Puertas') }}
                    {{ html()->number('doors', null, 0, 50)->placeholder('Ingrese las cantidad de puertas que tiene el elemento')->addClass('form-control') }}
                </div>
            </div>

            <div id="FormularioParte6" style="display: none;">
                <div class="form-group">
                    {{ html()->label('Cantidad') }}
                    {{ html()->number('quantity', null, 0, 50000)->placeholder('Ingrese el Stock del elemento')->addClass('form-control') }}
                </div>
            </div>

            <div id="FormularioParte7" style="display: none;">
                <div class="form-group">
                    {{ html()->label('Tipo de extintor') }}
                    {{ html()->select('typeExt', ['N/A' => 'N/A', 'Agua' => 'Agua', 'Espuma' => 'Espuma', 'Dióxido de Carbono' => 'Dióxido de Carbono', 'PQS Clase ABC' => 'PQS Clase ABC', 'PQS Clase BC' => 'PQS Clase BC', 'Polvo Seco' => 'Polvo Seco', 'Químico Húmedo' => 'Químico Húmedo'], null)->placeholder('Ingrese el tipo de extintor')->id('selectExtintor')->addClass('form-control') }}
                </div>
            </div>
            <div id="capacity_view" style="display: none;">
                <div class="form-group">
                    {{ html()->label('Capacidad') }}
                    {{ html()->number('capacity', 0, 0, 40)->placeholder('Ingrese la Capacidad del extintor')->addClass('form-control') }}
                </div>
            </div>

            {{-- Fin formulario atributos adicionales --}}



            {{-- Grids de bootstrap --}}
            <div class="d-flex justify-content-around">
                {{ html()->label('Imagen del Elemento')->addClass('form-label mb-3 mx-auto') }}
            </div>

            <div class="d-flex justify-content-around">
                <div class="image-wrapper w-75 h-75 mx-auto my-auto">
                    {{-- Esta directiva de blade se encarga de comprobar si existe ya una imagen dentro de la tabla recopilada para el formulario, en caso de ser cierto la desplegará, de ser falso desplegará una imagen predeterminada genérica. --}}
                    @isset($element->image)
                        <img id="picture" class="rounded mx-auto d-block" src="{{ Storage::url($element->image->url) }}">
                    @else
                        <img id="picture" class="rounded mx-auto d-block" src="/../imagenes/luna.webp" alt="luna">
                    @endisset
                </div>

            </div>

            <div class="d-flex justify-content-around">
                {{-- comando de manejo de multimedia equivalente de {!! Form::file('file', ['class' =>'form-control-file', 'accept' => 'image/*']) !!} de Laravel Collective --}}
                {{ html()->file('file')->id('file')->addClass('btn btn-warning btn-block w-75 mb-3 mt-4')->acceptImage() }}
            </div>

            <div class="d-flex justify-content-around">
                <i>Asegúrate de que la imagen muestre las principales características del elemento.</i>
            </div>

            <div class="d-flex justify-content-around mb-3">
                @error('file')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <p class="font-weight-bold">Estado de Inventario</p>
                <label>
                    {{ html()->radio('statusInv', false, 1) }}
                    {{-- {!! Form::radio('status', 2) !!} --}}
                    Baja
                </label>

                <label>
                    {{ html()->radio('statusInv', false, 2) }}
                    {{-- {!! Form::radio('status', 1, true) !!} --}}
                    Alta
                </label>
                @error('statusInv')
                    <br>
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                {{-- Un Radio button solo permite la selecciond e 1 elemento, por eso su uso en el estado del post --}}
            </div>

            {{-- Botón para enviar el formulario Junto al mensaje y clases.  --}}
            {{ html()->submit('Crear Elemento')->addClass('btn btn-danger')->id('submitButton') }}

            {{-- Etiqueta de cierre del formulario creado. --}}
            {{ html()->form()->close() }}

            {{-- mini formulario para loggout, requerido debido a que la acción de logout requiere de un metodo POST y su respectivo token CSRF --}}
            <form method="POST" id="logout-form" action="{{ route('logout') }}">
                @csrf
            </form>

        </div>

    @stop

    @section('css')
        <style>
            .image-wrapper {
                position: relative;

            }

            .image-wrapper img {
                object-fit: cover;
                width: 100%;
                height: 100%;
            }

            ::file-selector-button {

                display: none;
            }
        </style>
        @vite(['resources/css/adminFormStyles.css'])

    @stop

    @section('js')
        @vite(['resources/js/themeTitleInyector.js'])
        {{-- Script Limitación de presionado de botones a 1 solo. --}}
        <script>
            document.getElementById('elementsForm').addEventListener('submit', function() {
                document.getElementById('submitButton').disabled = true;
            });
        </script>

        {{-- Este script hace una llamada a la libreria stringToSlug --}}
        <script src="{{ asset('vendor/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
        <script>
            //Script de JS que se encarga de  generar el slug en su respectivo espacio del formulario
            $(document).ready(function() {
                $("#nameElement").stringToSlug({
                    //En el #se insertará el nombre del espacio del formulario en este caso es name.
                    setEvents: 'keyup keydown blur',
                    getPut: '#slug',
                    // En esta parte se inserta en que parte del formulario se insertará lasalida de la conversion en el formulario, se le asigno el campo de slug
                    space: '-'
                });
            });
        </script>




        <script>
            //Script para actualizar de manera dinámica la imagen que subimos al formulario

            //El script se mantiene a la escucha de cualquier cambio hecho al input con el id file (Que se encuentra en nuestro formulario de Spatie/Laravel-HTML)
            document.getElementById("file").addEventListener('change', cambiarImagen);

            function cambiarImagen(event) {
                //Esta funcion convierte la imagen que subimos a base64
                var file = event.target.files[0];

                var reader = new FileReader();

                reader.onload = (event) => {
                    document.getElementById("picture").setAttribute('src', event.target.result);
                    //reemplaza el valor del atributo src por la imagen en formato base64
                };
                reader.readAsDataURL(file);
            }
        </script>



        {{-- Función de JavaScript, Su función es escuchar al botón del lado del sidebar para cerrar sesión --}}
        <script>
            function logoutFunction() {
                //llamada para subir formulario de cierre de sesión.
                document.getElementById('logout-form').submit();
            }
            //Escucha del click en el sidebar, si lo detecta ejecutará la función logoutFunction.
            document.getElementById("logout-form-click").addEventListener("click", logoutFunction);
        </script>









        {{-- Script de JS con la función de desplegar partes del formulario de acuerdo al JS --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                //Esta variable recopila el valor del elemento del formulario que tiene el identificador selectCategory_id  (El atributo category_id del formulario)
                const select = document.getElementById('selectCategory_id');
                //Esta variable recopila el valor del elemento del formulario que tiene el identificador selectExtintor (El atributo typeExt del formulario)
                const selectExt = document.getElementById('selectExtintor');

                //Estas variables corresponden a campos div los cuales se modificará su vista de acuerdo al valor .style.display (block o none)
                const capacity_view = document.getElementById('capacity_view');
                const FormularioParte1 = document.getElementById('FormularioParte1');
                const FormularioParte2 = document.getElementById('FormularioParte2');
                const FormularioParte3 = document.getElementById('FormularioParte3');
                const FormularioParte4 = document.getElementById('FormularioParte4');
                const FormularioParte5 = document.getElementById('FormularioParte5');
                const FormularioParte6 = document.getElementById('FormularioParte6');
                const FormularioParte7 = document.getElementById('FormularioParte7');

                //este switch se mantien a la escucha de cualquier cambio en la variable select (la que recopila el category_id del atributo en formulario), de acuerdo a su valor deplegará ciertos elementos de formulario de acuerdo a la categoria.
                select.addEventListener('change', function() {
                    switch (select.value) {
                        case '1':
                            FormularioParte1.style.display = 'block';
                            FormularioParte2.style.display = 'block';
                            FormularioParte3.style.display = 'block';
                            FormularioParte4.style.display = 'none';
                            FormularioParte5.style.display = 'none';
                            FormularioParte6.style.display = 'none';
                            FormularioParte7.style.display = 'none';
                            break;
                        case '2':
                            FormularioParte1.style.display = 'none';
                            FormularioParte2.style.display = 'block';
                            FormularioParte3.style.display = 'block';
                            FormularioParte4.style.display = 'block';
                            FormularioParte5.style.display = 'block';
                            FormularioParte6.style.display = 'none';
                            FormularioParte7.style.display = 'none';
                            break;
                        case '3':
                            FormularioParte1.style.display = 'none';
                            FormularioParte2.style.display = 'none';
                            FormularioParte3.style.display = 'none';
                            FormularioParte4.style.display = 'block';
                            FormularioParte5.style.display = 'none';
                            FormularioParte6.style.display = 'block';
                            FormularioParte7.style.display = 'none';
                            break;
                        case '4':
                            FormularioParte1.style.display = 'block';
                            FormularioParte2.style.display = 'block';
                            FormularioParte3.style.display = 'block';
                            FormularioParte4.style.display = 'none';
                            FormularioParte5.style.display = 'none';
                            FormularioParte6.style.display = 'none';
                            FormularioParte7.style.display = 'none';
                            break;
                        case '5':
                            FormularioParte1.style.display = 'block';
                            FormularioParte2.style.display = 'block';
                            FormularioParte3.style.display = 'block';
                            FormularioParte4.style.display = 'none';
                            FormularioParte5.style.display = 'none';
                            FormularioParte6.style.display = 'none';
                            FormularioParte7.style.display = 'none';
                            break;
                        case '6':
                            FormularioParte1.style.display = 'block';
                            FormularioParte2.style.display = 'block';
                            FormularioParte3.style.display = 'none';
                            FormularioParte4.style.display = 'none';
                            FormularioParte5.style.display = 'none';
                            FormularioParte6.style.display = 'none';
                            FormularioParte7.style.display = 'block';
                            break;
                        default:
                            FormularioParte1.style.display = 'none';
                            FormularioParte2.style.display = 'none';
                            FormularioParte3.style.display = 'none';
                            FormularioParte4.style.display = 'none';
                            FormularioParte5.style.display = 'none';
                            FormularioParte6.style.display = 'none';
                            FormularioParte7.style.display = 'none';

                    }

                    //Si el valor de category_id no es de equipo de seguridad se ocultará el elemento de formulario con la capacidad. (Con el fin de evitar que aparezca cuando no.)
                    if (select.value != '6') {
                        capacity_view.style.display = 'none';
                    }
                });

                //Este segundo listener escucha cuando un elemento de seguridad es un extintor, es decir cuando sea diferente el valor del select de N/A, se desplegará de acuerdo a esa condición la parte del formulario con la capcidad.
                selectExt.addEventListener('change', function() {
                    if (selectExt.value != 'N/A') {
                        capacity_view.style.display = 'block';

                    } else {
                        capacity_view.style.display = 'none';
                    }

                });
            });
        </script>

    @endsection
