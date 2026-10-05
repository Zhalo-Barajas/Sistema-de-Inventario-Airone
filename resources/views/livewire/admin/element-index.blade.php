<div>

    <div class="card">
        <div class="card-header">
            <h2 class="text-center">Buscador</h2>
        </div>
        <div class="card-body">
            {{-- <input wire:model.live="search" class="form-control" placeholder="Ingrese el nombre del elemento" type="text"> --}}
            {{-- La propiedad wire:model se sincroniza con la variable del conector ElementIndex (app\Http\Controllers\Admin\ElementController.php) ($search) --}}
            {{-- IMPORTANTE, AGREGAR A NUESTRO WIRE:MODEL LA PROPIEDAD .LIVE PARA QUE NO REQUIERA DE UN BOTON PARA ACTUALIZAR LOS DATOS  --}}
            {{-- <h1>{{$search}}</h1> depuracion --}}
            <div class="d-flex justify-content-around">
                {{ html()->label('Nombre del Elemento') }}
            </div>
            <div class="d-flex justify-content-around">

                <div class="input-group mb-3">
                    <input type="text" name="nameElement" maxlength="60" class="form-control"
                        placeholder="Ingrese el nombre del elemento a buscar" wire:model.live="search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-danger" type="button" wire:click="reloadSearch"
                            data-toggle="tooltip" data-placement="top" title="Reiniciar parámetros de búsqueda">
                            <i class="fas fa-plus" style="transform: rotate(45deg);"></i></button>
                        {{-- Can't believe this worked XD --}}
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-around">
                {{ html()->label('Categoría') }}
                {{ html()->label('Fondo') }}
                {{ html()->label('Etiqueta') }}
            </div>
            <div class="d-flex justify-content-around mb-3">
                {{ html()->select('category_id', $categories, null)->addClass('form-control col-3')->attribute('wire:model.live', 'searchCategory')->placeholder('Selecciona una categoría') }}
                {{ html()->select('fund_id', $funds, null)->addClass('form-control col-3')->attribute('wire:model.live', 'searchFund')->placeholder('Selecciona un fondo') }}
                {{ html()->select('tag', $tags, null)->addClass('form-control col-3')->attribute('wire:model.live', 'searchTag')->placeholder('Selecciona una etiqueta') }}
            </div>
            <div class="d-flex justify-content-around">
                {{ html()->label('Edificio') }}
                {{ html()->label('Ubicación') }}
                {{ html()->label('Status') }}
            </div>
            <div class="d-flex justify-content-around">
                {{ html()->select('building_id', $buildings, null)->addClass('form-control col-3')->attribute('wire:model.live', 'searchBuilding')->placeholder('Selecciona un edificio') }}
                {{ html()->select('ubication_id', $ubications, null)->addClass('form-control col-3')->attribute('wire:model.live', 'searchUbication')->placeholder('Selecciona una ubicación') }}
                {{ html()->select('statusInv', [1 => 'Baja', 2 => 'Alta'], null)->addClass('form-control col-3')->attribute('wire:model.live', 'searchStatus')->placeholder('N/A') }}
            </div>

        </div>
    </div>

    <div class="card">
        {{-- Close your eyes. Count to one. That is how long forever feels. --}}

        {{-- <div class="card-header">
        <p>Depuración de Categorias: {{$depuracionCategory}}</p>
        <p>Depuración de Fondos: {{$depuracionFund}}</p>
        <p>Depuración de Etiquetas: {{$depuracionTag}}</p>
        <p>Depuración de Edificios: {{$depuracionBuilding}}</p>
        <p>Depuración de Ubicaciones: {{$depuracionUbication}}</p>
        <p>Depuración de Status: {{$depuracionStatus}}</p>
    </div> --}}
        @if ($elements->count())
            {{-- Este if comprueba si se retornaron elements, en caso contrario el else imprimira el mensaje --}}

            <div class="row justify-content-center">
                <div class="col-auto">
                    <div class="card-body">
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID</th>
                                    <th>Nombre del Elemento</th>
                                    <th>Edificio</th>
                                    <th>Ubicación</th>
                                    <th>Fondo</th>
                                    <th>Categoría</th>
                                    <th>Status</th>
                                    <th>Fecha de Registro</th>
                                    <th>Etiquetas</th>
                                    {{-- <th>Edificio 2</th> --}}
                                    {{-- <th colspan="2"></th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($elements as $element)
                                    <tr>

                                        @canany(['admin.elements.edit', 'admin.elements.destroy',
                                            'admin.maintenances.create'])
                                            <td width='10px'>
                                                <div class="dropup">
                                                    <a class="btn-sm btn-danger dropdown-toggle" href="#"
                                                        role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        Acción
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        @can('admin.elements.edit')
                                                            <a href="{{ route('admin.elements.edit', $element) }}"
                                                                class="dropdown-item">Editar</a>
                                                            {{-- //Los enlaces solo pueden manejar peticiones get --}}
                                                        @endcan

                                                        @can('admin.elements.destroy')
                                                            {{-- Usar un form para poder retornar los otros tipos de rutas como delete o update --}}
                                                            <form action="{{ route('admin.elements.destroy', $element) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="dropdown-item">Eliminar</button>
                                                            </form>
                                                        @endcan


                                                        @can('admin.maintenances.create')
                                                            <form action="{{ route('admin.maintenances.create') }}"
                                                                method="PUT">
                                                                @csrf
                                                                {{ html()->hidden('id', $element->id) }}
                                                                {{-- {{$element->id}} --}}
                                                                <button type="submit"
                                                                    class="dropdown-item">Mantenimiento</button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </td>
                                        @endcanany




                                        <td>{{ $element->id }}</td>
                                        <td><a class="text-danger"
                                                href="{{ route('admin.elements.show', $element) }}">{{ $element->nameElement }}</a>
                                        </td>
                                        {{-- Se está utilizando los valores de columnas recopilados con el JOIN. --}}
                                        <td>{{ $element->nameBuilding }}</td>
                                        <td>{{ $element->nameUbication }}</td>
                                        <td>{{ $element->nameFund }}</td>
                                        <td>{{ $element->nameCategory }}</td>
                                        @if ($element->statusInv == 2)
                                            <td>Alta</td>
                                        @else
                                            <td>Baja</td>
                                        @endif

                                        <td width="150px">{{ $element->created_at->format('Y-m-d') }}</td>

                                        <td>
                                            @foreach ($element->tags as $tag)
                                                <p class="text-light text-center mb-1 mt-1"
                                                    style="font-size: 12px; border-radius: 5px; background-color: {{ $tag->color }}">
                                                    {{ $tag->nameTag }}</p>
                                            @endforeach
                                        </td>




                                        <td colspan="10px"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

            <div class="card-footer">
                {{ $elements->links() }}
            </div>
            {{-- Mantener codigo limpio, evitar que se filtren directivas de blade no utilizadas --}}
            {{-- El contenido de todo este componente de livewire se debe de encontrar en un div padre --}}
        @else
            <div class="card-body">No existe ningún registro con los parámetros proporcionados.</div>

        @endif


    </div>
</div>
