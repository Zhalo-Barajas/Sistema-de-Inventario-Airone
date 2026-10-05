<div>
    <div class="card mx-auto">
        <div class="card-header">
            <div class="input-group mb-3">
                <input wire:model.live="search" class="form-control"
                    placeholder="Ingrese el nombre o correo de un usuario.">
                <div class="input-group-append">
                    <button class="btn btn-outline-danger" type="button" wire:click="reloadSearch" data-toggle="tooltip"
                        data-placement="top" title="Reiniciar parámetros de búsqueda">
                        <i class="fas fa-plus" style="transform: rotate(45deg);"></i></button>
                    {{-- Can't believe this worked XD --}}
                </div>
            </div>
        </div>


        @if ($users->count())
            <div class="card-body">
                <table class="table table-stripe table-responsive">
                    <thead>
                        <tr>
                            {{-- Filas con los nombres de los atributos --}}
                            <th>ID</th>
                            <th width="630px">Nombre del Usuario</th>
                            <th width="630px">Correo Electrónico</th>
                            <th width="430px">Fecha de Creación de Usuario</th>
                            <th colspan="5"></th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($users as $user)
                            {{-- Recorrera la variable users, por cada registro que encuentre lo almacenara temporalmente en la variable user y desplegará sus datos según cada iteración. --}}

                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>&nbsp;</td>
                                <td width="10px">
                                    @can('admin.users.edit')
                                        <a class="btn btn-danger user-link" user-index="{{ $user->id }}"
                                            id="editLink-{{ $user->id }}"
                                            href="{{ route('admin.users.edit', $user) }}">Editar</a>
                                        {{-- <a id="deleteLink-{{ $index }}" href="{{ route('delete', $item->id) }}" data-index="{{ $index }}" class="delete-link">Eliminar</a> --}}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $users->links() }}

            </div>
        @else
            <div class="card-body">
                <strong>No hay registros.</strong>
            </div>
        @endif

        @section('js')
            {{-- Script Limitación de presionado de botones a 1 solo. --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Selecciona todos los enlaces que tienen la clase "delete-link"
                    var links = document.querySelectorAll('.user-link');

                    links.forEach(function(link) {
                        link.addEventListener('click', function(event) {
                            event.preventDefault(); // Previene el comportamiento por defecto del enlace
                            var index = link.getAttribute('user-index');

                            // Deshabilita el enlace
                            link.style.pointerEvents = 'none';
                            link.style.opacity =
                                '0.5'; // Opcional: Para dar una indicación visual de que el enlace está deshabilitado

                            // Redirige a la URL del enlace
                            window.location.href = link.href;
                        });
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


    </div>
</div>
