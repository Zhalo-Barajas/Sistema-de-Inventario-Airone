 @extends('adminlte::page')

 @section('title', 'Dashboard')

 @section('content_header')
     <div class="d-flex flex-row mb-1 pb-1">
         <img src="/../logotipos/garza2.png" width="50px" height="50px" class="my-auto mr-2" alt="garza">
         <h1 class=" mr-3 my-auto">Dashboard</h1>
     </div>

     {{-- Apartado de tarjetas con estadísticas --}}
     <div class="card mt-8">
         <div class="card-header">
             <h1 class="text-center mt-2">Estadísticas Globales</h1>
             <hr class="mt-2 mb-4 w-25 mx-auto bg-orange">

             <div class="d-flex justify-content-around mb-3">
                 @can('admin.elements.index')
                     <a href="{{ route('admin.elements.index') }}" data-toggle="tooltip" data-placement="top"
                         title="Acceder a listado de Elementos">
                         <div class="small-box bg-info bg-warning">
                             <div class="inner">
                                 <h3 class="mb-3">{{ $elementsNumber }}</h3>
                                 <p class="mt-4">Elementos registrados en total.</p>
                             </div>
                             <div class="icon">
                                 <i class="fas fa-scroll"></i>
                             </div>
                         </div>
                     </a>
                 @else
                     <div class="small-box bg-info bg-danger">
                         <div class="inner">
                             <h3 class="mb-3">{{ $elementsNumber }}</h3>
                             <p class="mt-4">Elementos registrados en total.</p>
                         </div>
                         <div class="icon">
                             <i class="fas fa-scroll"></i>
                         </div>
                     </div>
                 @endcan

                 @can('admin.users.index')
                     <a href="{{ route('admin.users.index') }}" data-toggle="tooltip" data-placement="top"
                         title="Acceder a listado de usuarios">
                         <div class="small-box bg-info bg-danger">
                             <div class="inner">
                                 <h3 class="mb-3">{{ $usersNumber }}</h3>
                                 <p class="mt-4">Usuarios registrados en total.</p>
                             </div>
                             <div class="icon">
                                 <i class="fas fa-users"></i>
                             </div>

                         </div>
                     </a>
                 @else
                     <div class="small-box bg-info bg-warning">
                         <div class="inner">
                             <h3 class="mb-3">{{ $usersNumber }}</h3>
                             <p class="mt-4">Usuarios registrados en total.</p>
                         </div>
                         <div class="icon">
                             <i class="fas fa-users"></i>
                         </div>
                     </div>
                 @endcan

                 @can('admin.maintenances.index')
                     <a href="{{ route('admin.maintenances.index') }}" data-toggle="tooltip" data-placement="top"
                         title="Acceder a listado de mantenimientos">
                         <div class="small-box bg-olive">
                             <div class="inner">
                                 <h3 class="mb-3">{{ $maintenancesNumber }}</h3>
                                 <p class="mt-4">Mantenimientos realizados.</p>
                             </div>
                             <div class="icon">
                                 <i class="fas fa-tools"></i>
                             </div>
                         </div>
                     </a>
                 @else
                     <div class="small-box bg-success">
                         <div class="inner">
                             <h3 class="mb-3">{{ $maintenancesNumber }}</h3>
                             <p class="mt-4">Mantenimientos realizados.</p>
                         </div>
                         <div class="icon">
                             <i class="fas fa-tools"></i>
                         </div>
                     </div>
                 @endcan

                 @can('admin.conveyances.index')
                     <a href="{{ route('admin.conveyances.index') }}" data-toggle="tooltip" data-placement="top"
                         title="Acceder a listado de traspasos">
                         <div class="small-box bg-teal">
                             <div class="inner">
                                 <h3 class="mb-3">{{ $conveyancesNumber }}</h3>
                                 <p class="mt-4">Traspasos realizados.</p>
                             </div>
                             <div class="icon">
                                 <i class="fas fa-exchange-alt"></i>
                             </div>
                         </div>
                     </a>
                 @else
                     <div class="small-box bg-info">
                         <div class="inner">
                             <h3 class="mb-3">{{ $conveyancesNumber }}</h3>
                             <p class="mt-4">Traspasos realizados.</p>
                         </div>
                         <div class="icon">
                             <i class="fas fa-exchange-alt"></i>
                         </div>
                     </div>
                 @endcan
             </div>
         </div>

         <div class="card-body">
             <h1 class="text-center">Estadísticas Mensuales</h1>
             <hr class="mt-2 mb-4 w-25 mx-auto bg-orange">
             <div class="d-flex justify-content-around mb-3">
                 <div class="small-box bg-info bg-warning">
                     <div class="inner">
                         <h3 class="mb-3">{{ $elementsMonth }}</h3>
                         <p class="mt-4">Elementos registrados en este mes.</p>
                     </div>
                     <div class="icon">
                         <i class="fas fa-scroll"></i>
                     </div>
                 </div>

                 <div class="small-box bg-olive">
                     <div class="inner">
                         <h3 class="mb-3">{{ $maintenancesMonth }}</h3>
                         <p class="mt-4">Mantenimientos realizados este mes.</p>
                     </div>
                     <div class="icon">
                         <i class="fas fa-tools"></i>
                     </div>
                 </div>

                 <div class="small-box bg-teal">
                     <div class="inner">
                         <h3 class="mb-3">{{ $conveyancesMonth }}</h3>
                         <p class="mt-4">Traspasos realizados este mes.</p>
                     </div>
                     <div class="icon">
                         <i class="fas fa-exchange-alt"></i>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 @stop

 {{-- Invocación de plugin de fullcalendar y cuerpo vista. --}}
 @section('content')
 @section('plugins.FullCalendar', true)
 <div class="card">
     <div class="ml-16 ">
         <p style="font-size: xx-large;" class="text-center mt-4 mb-2">Calendario de actividades</p>
         <hr class="mt-2 mb-4 w-50 mx-auto bg-orange">
     </div>
     <div id='calendar' class="mb-4 w-75 mx-auto"></div>
 </div>

 {{-- Si el usuario tiene permisos para modificar el calendario por medio de AJAX se cargarán los modales necesarios para interectuar con el calendario. --}}
 @can('admin.event.ajax')
     <!-- Modal para crear/editar evento -->
     <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel"
         aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="eventModalLabel">Crear evento</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <form id="eventForm">
                         <div class="form-group">
                             <label for="eventTitle" class="col-form-label">Nombre del evento:</label>
                             {{-- Caracteres máximos del nombre del evento: 255., Rellenarlo es obligatorio --}}
                             <input type="text" class="form-control"
                                 style="border-radius: 5px; form-control-color: lightgray" id="eventTitle"
                                 maxlength="255" autocomplete="off" required>
                         </div>
                     </form>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                     <button type="button" class="btn btn-danger" id="saveEvent">Crear</button>
                 </div>
             </div>
         </div>
     </div>

     <!-- Modal para confirmar eliminación de evento -->
     <div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog"
         aria-labelledby="deleteEventModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="deleteEventModalLabel">Eliminar evento</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     ¿Estás seguro de eliminar el evento? Esta acción es <b class="text-danger">Irreversible</b>.
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                     <button type="button" class="btn btn-danger" id="deleteEvent">Eliminar</button>
                 </div>
             </div>
         </div>
     </div>
 @endcan

@stop


@section('css')
 @vite(['resources/css/appAdminIndex.css', 'resources/css/adminFormStyles.css'])
@stop


@section('js')
 {{-- Importación de modulos y scripts JS con el uso de laravel Vite. --}}
 @vite(['resources/js/app.js'])
 @vite(['resources/js/themeTitleInyector.js'])


 {{-- Generación de un token CSRF dentro de la etiqueta meta --}}
 <meta name="csrf-token" content="{{ csrf_token() }}">


 @if (auth()->user()->can('admin.event.ajax'))
     {{-- Si el usuario tiene permisos para manipular eventos se ejecutará este script con el cuál podra realizar
         las solicitudes por medio de AJAX para crear, editar y eliminar eventos.  --}}


     <script type="text/javascript">
         document.addEventListener('DOMContentLoaded', function() {
             var SITEURL =
                 "{{ url('/') }}"; // Dentro de esta variable se define la URL base para todas las peticiones de AJAX (Es decir, por ejemplo 127.0.0.1:8000 o si adoptase una IP/dominio)
             var csrfToken = $('meta[name="csrf-token"]').attr(
                 'content'); // Se recupera el Token CSRF de la etiqueta meta dentro del apartado de código HTML
             var calendarEl = document.getElementById('calendar'); // Se recupera el elemento DOM con el calendario.
             // Variable para almacenar el evento seleccionado en el calendario para ser eliminado.
             var selectedEvent = null;
             const sidebarButton = document.querySelector('[data-widget="pushmenu"]');
             sidebarButton.addEventListener("click", resizeCalendar);

             function resizeCalendar() {
                 setTimeout(() => {
                     calendar.render();
                 }, 270); // 2000 milliseconds = 2 seconds
             }

             //Inicialización del calendario.
             var calendar = new FullCalendar.Calendar(calendarEl, {
                 headerToolbar: {
                     left: 'prev today', //declaración de los botones de navegación dentro del calendario
                     center: 'title', //Aqui se despliegan las fechas en las que se encuentra el calendario
                     right: 'next' // FOrmatear el calendario a meses, semanas o dias.
                 },
                 editable: true, // Este modificador permite que los eventos sean arrastrados/alterados de tamaño

                 //Esta variable (events) realiza la tareas de recuperar a través de un método GET en la URL /admin/event/fetch los eventos existentes en la Base de datos., en caso de fallar retornará un error en forma de ALert.
                 events: {
                     url: SITEURL + "/admin/event/fetch", // URL de la cual recopilará los eventos.
                     method: 'GET', // Metodo/tipo de solicitud que usará para recopilar estos datos, en este caso será un GET.
                     failure: function() {
                         alert(
                             'Ocurrió un error al momento de recopilar los registros!'
                         ); //Alerta en caso de que ociurriera un error al recopilar los registros.
                     }
                 },
                 selectable: true, // Con este modificador se permite seleccionar conjuntos de fechas (Acción de arrastras y seleccionar varias fechas).
                 locale: "es", //Con esto se solicita que los textos e iconos se muestren en español.
                 //Color de los eventos
                 eventColor: '#B91116', //Color de los iconos de eventos
                 longPressDelay: 4, //Retraso (En segundos) para que el botón se vuelva seleccionable (EXLUSIVO DE MOVIL Y DISPOSITIVOS TOUCH)
                 //Color del texto
                 // eventTextColor: '',

                 // eventDidMount: function(info) {
                 //     info.el.style.borderRadius = '0px';
                 //     info.el.style.borderWidth = '4px';
                 // },

                 // Dentro dentro de select (Es decir al momento de hacer click en una fecha se generará se trabajará con una función la cual tiene la variable info, esta variable tiene la fecha inicial y final del evento a crear.
                 select: function(info) {
                     $('#eventModal').modal('show'); //Al momento de hacer click se desplegará el modal 

                     //Rehabilitación en caso de que hayan presionado varios clicks seguidos (No interfiere con la naturaleza de la transacción AJAX y la habilitación/dehabilitación de los botones en esa transacción).
                     saveEvent.disabled = false;

                     //# Este es un manejador de eventos para el botón "Save" del modal de creación. (Más especificamente cuando el usuario realiza click en el botón Guardar)
                     $('#saveEvent').off('click').on('click', function() {
                         var title = $('#eventTitle')
                             .val(); //Recupera el titulo del evento de la entrada del modal con la id eventTitle

                         //Recopilación dentro de una variable de JS del botón dedicado al guardado del registro de evento
                         var saveEvent = this;
                         //Se inhabilita el botón hasta el final de la transacción.
                         saveEvent.disabled = true;

                         const now = new Date();

                         // Opciones de formato para la zona horaria de Ciudad de México
                         const options = {
                             timeZone: "America/Mexico_City",
                             year: "numeric",
                             month: "2-digit",
                             day: "2-digit",
                             hour12: false
                         };

                         // Usamos Intl.DateTimeFormat para asegurar la zona horaria
                         const formatter = new Intl.DateTimeFormat("en-CA", options);
                         const parts = formatter.formatToParts(now);

                         // Reconstruimos la fecha y hora
                         const dateToday =
                             `${parts.find(p => p.type === "year").value}-${parts.find(p => p.type === "month").value}-${parts.find(p => p.type === "day").value}`;


                         if (info.startStr < dateToday) {
                             //Correción if, para que la condición sea menor o igual
                             console.log(dateToday);
                             errorMessage = displayErrorMessage(
                                 "No se pueden crear eventos en fechas anteriores a la fecha actual."
                             );

                             //Rehabilitado del botón para guardar registros.

                             setTimeout(() => {
                                 saveEvent.disabled = false;
                             }, 3000); // 2000 milliseconds = 2 seconds
                             // alert('No se pueden crear eventos en fechas anteriores o equivalentes a la fecha actual.');
                             calendar.unselect();
                             return;
                         }

                         if (title) {
                             var start = info.startStr;
                             //Recopila la fecha de inicio del evento de la variable info
                             var end = info.endStr;
                             //Recopila la fecha de finalización del evento info

                             //Generación de solicitud AJAX al servidor para en este caso generar un registro de evento, la función $.ajax es parte de la libreria jQuery
                             $.ajax({
                                 url: SITEURL +
                                     "/admin/event/ajax", // URL a la que se enviará la petición
                                 data: { //creación del concentrado de datos que se guardarán con el usando el caso del controlador ajax
                                     title: title,
                                     start: start,
                                     end: end,
                                     type: 'add' //Con el uso de este dato el controlador reconocerá la operación que va a realziar con el resto de datos, en este caso con 'add' se creará un registro de evento.
                                 },
                                 type: "POST", //Método de la solicitud, en este caso será un metodo POST ya que se están enviando datos de formulario.
                                 headers: {
                                     'X-CSRF-TOKEN': csrfToken //Añadida a la cabecera de la solicitud el Token CSRF
                                 },
                                 ////Se realiza el siguiente método (success) en caso de la solicitud haya tenido éxito.
                                 success: function(data) {
                                     if (data.id) {
                                         //Generación de mensaje de éxito
                                         displayMessage(
                                             "Evento creado con éxito"
                                         ); //Generación de la variable message que se desplegará en la función "function displayMessage(message)"
                                         // calendar.addEvent({ 
                                         //   id: data.id,
                                         //   title: title,
                                         //   start: start,
                                         //   end: end,
                                         //   allDay: info.allDay //Se añade de manera manual el registro en el calendario. // DESCARTADO, reemplazado por calendar.refetchEvents()
                                         // });
                                         calendar
                                             .unselect(); //Se deselecciona el rango de fechas abarcado por el usuario al momento de la solicitud 
                                         $('#eventModal').modal(
                                             'hide'
                                         ); //Se oculta el modal una vez se ha terminado de utilizar
                                         $('#eventTitle').val(
                                             ''
                                         ); // Se limpia la entrada que tiene el modal.
                                         calendar.refetchEvents();

                                         //Rehabilitado del botón para guardar registros.
                                         saveEvent.disabled = false;

                                     } else {

                                         console.error("Error, entrada inesperada: ",
                                             data
                                         ); // Muestra por medio un Log respuestas inesperadas.

                                         //Rehabilitado del botón para guardar registros.
                                         saveEvent.disabled = false;
                                     }
                                 },
                                 //// Código que se ejecuta si hay un error en la solicitud
                                 error: function(xhr, status, error) {
                                     console.error("Error: ", xhr
                                         .responseText); // concentrado de errores.
                                     //Rehabilitado del botón para guardar registros.
                                     saveEvent.disabled = false;
                                 }
                             });
                         }
                     });
                 },



                 // Cuando un evento ya creado es arrastrado y asignado a otra fecha, se actualiza a la fecha de donde fue posicionado.
                 eventDrop: function(info) {
                     var start = info.event.startStr;
                     var end = info.event.endStr;


                     const now = new Date();

                     // Opciones de formato para la zona horaria de Ciudad de México
                     const options = {
                         timeZone: "America/Mexico_City",
                         year: "numeric",
                         month: "2-digit",
                         day: "2-digit",
                         hour12: false
                     };

                     // Usamos Intl.DateTimeFormat para asegurar la zona horaria
                     const formatter = new Intl.DateTimeFormat("en-CA", options);
                     const parts = formatter.formatToParts(now);

                     // Reconstruimos la fecha y hora
                     const dateToday =
                         `${parts.find(p => p.type === "year").value}-${parts.find(p => p.type === "month").value}-${parts.find(p => p.type === "day").value}`;
                     // Recuperación de la Fecha actual en formato YYYY-MM-DD. //Correción if, para que la condición sea menor o igual

                     //Depuración
                     console.log(dateToday);
                     // console.log(info.event.startStr);

                     if (info.event.startStr < dateToday) {
                         errorMessage = displayErrorMessage(
                             'No se pueden mover eventos a fechas anteriores a la fecha actual.');
                         calendar.unselect();
                         // alert('No se pueden mover eventos a fechas anteriores o equivalentes a la fecha actual.');
                         //Esta función revierte los cambios realizados al momento de arrastras la fecha.
                         info.revert();
                         return;
                     }


                     $.ajax({
                         url: SITEURL +
                             '/admin/event/ajax', // URL a la que se enviará la petición
                         data: {
                             title: info.event.title,
                             // Recupera de la selección del evento el nombre del evento a editar,
                             start: start,
                             end: end,
                             id: info.event.id,
                             // Recupera de la selección del evento el id del evento a editar,

                             type: 'update' //El caso que va a invocar en el controlador dentro del método ajax.
                         },
                         type: "POST",
                         headers: {
                             'X-CSRF-TOKEN': csrfToken
                         },
                         success: function(response) {
                             displayMessage("Evento actualizado con éxito");
                         },
                         error: function(xhr, status, error) {
                             //  console.error("Error: ", xhr.responseText); // Depuración
                             displayWarningMessage(
                                 "Evento ejecutado anteriormente o eliminado");
                             //elimina el elemento listado dedl calendario para evitar sus posteriores manipulaciones.
                             calendar.getEventById(info.event.id).remove();
                         }
                     });
                 },
                 eventClick: function(info) {
                     selectedEvent = info.event;
                     // Cuando se le hace click a un evento, se mostrará el modal para elminar eventos. (Se invoca a el modal con id deleteEvent)
                     $('#deleteEventModal').modal('show');
                 }
             });

             calendar.render();
             //  resizeCalendar();
             //  window.addEventListener('resize', resizeCalendar);

             $('#deleteEvent').on('click', function() {
                 //Recopilación dentro de una variable de JS del botón dedicado al guardado del registro de evento
                 var deleteEvent = this;
                 //Se inhabilita el botón hasta el final de la transacción.
                 deleteEvent.disabled = true;

                 if (selectedEvent) {
                     $.ajax({
                         type: "POST",
                         url: SITEURL + '/admin/event/ajax',
                         data: {
                             id: selectedEvent.id,
                             type: 'delete'
                         },
                         headers: {
                             'X-CSRF-TOKEN': csrfToken
                         },
                         success: function(response) {
                             calendar.getEventById(selectedEvent.id).remove();
                             displayMessage("Evento eliminado con éxito");
                             $('#deleteEventModal').modal('hide');

                             // //Rehabilitado del botón para eliminación de eventos.

                             deleteEvent.disabled = false;
                         },
                         error: function(xhr, status, error) {
                             //  console.error("Error: ", xhr.responseText); //Depuración

                             // //Rehabilitado del botón para eliminación de eventos.
                             deleteEvent.disabled = false;
                         }
                     });
                 }
             });
         });

         // Método/función displayMessage, esta desplegará el mensaje de éxito de la acción realizada con el contenido de la variable "message".
         function displayMessage(message) { //La variable message contiene el mensaje respectivo a la acción realizada
             toastr.success(message); //Se muestra la notificación al usuario.
             // toastr.success(message, 'Evento'); //despliegue de notificación con toastr, usa un mensaje y titulo
             // toastr.error('Test'); //Test errores
         }


         // Llamada al metodo displayErrorMessage, esta desplegará el mensaje de éxito de la acción realizada.
         //Función dedicada a recuperar un mensaje de error (La variable errorMessage)) y desplegarla en una notifcación de la libreria toaster. 
         function displayErrorMessage(
             errorMessage) { //La variable message contiene el mensaje respectivo a la acción realizada
             toastr.error(
                 errorMessage
             ); //Esta acción desplegará el mensaje en un formato de error (difiere a la notificación de exito).
         }

         function displayWarningMessage(
             warningMessage) { //La variable message contiene el mensaje respectivo a la acción realizada
             toastr.warning(
                 warningMessage
             ); //Esta acción desplegará el mensaje en un formato de advertencia (difiere a la notificación de exito).
         }
     </script>
 @else
     {{-- Se ejecutará el siguiente script en el caso de que el usuario no tenga permisos para manipular eventos
         El siguiente script unicamente podra observar el calendario y los eventos que habrá, NO podrá crear, editar o eliminar eventos.  --}}

     <script type="text/javascript">
         document.addEventListener('DOMContentLoaded', function() {
             var SITEURL =
                 "{{ url('/') }}"; // Dentro de esta variable se define la URL base para todas las peticiones de AJAX (Es decir, por ejemplo 127.0.0.1:8000 o si adoptase una IP/dominio)
             var csrfToken = $('meta[name="csrf-token"]').attr(
                 'content'); // Se recupera el Token CSRF de la etiqueta meta dentro del apartado de código HTML
             var calendarEl = document.getElementById('calendar'); // Se recupera el elemento DOM con el calendario.
             var selectedEvent =
                 null; // Variable para almacenar el evento seleccionado en el calendario para ser eliminado. 
             const sidebarButton = document.querySelector('[data-widget="pushmenu"]')
             sidebarButton.addEventListener("click", resizeCalendar);

             function resizeCalendar() {
                 //  const calendarContainer = document.querySelector('#calendar');

                 setTimeout(() => {
                     calendar.render();
                 }, 270); // 2000 milliseconds = 2 seconds

             }

             //Inicialización del calendario.
             var calendar = new FullCalendar.Calendar(calendarEl, {
                 headerToolbar: {
                     left: 'prev today', //declaración de los botones de navegación dentro del calendario
                     center: 'title', //Aqui se despliegan las fechas en las que se encuentra el calendario
                     right: 'next' // FOrmatear el calendario a meses, semanas o dias.
                 },
                 editable: false, // Este modificador permite que los eventos sean arrastrados/alterados de tamaño
                 events: {
                     url: SITEURL + "/admin/event/fetch", // URL de la cual recopilará los eventos.
                     method: 'GET', // Metodo/tipo de solicitud que usará para recopilar estos datos, en este caso será un GET.
                     failure: function() {
                         alert(
                             'Ocurrió un error al momento de recopilar los registros!'
                         ); //Alerta en caso de que ociurriera un error al recopilar los registros.
                     }
                 },
                 selectable: null, // Con este modificador se permite seleccionar conjuntos de fechas (Acción de arrastras y seleccionar varias fechas).
                 locale: "es", //Con esto se solicita que los textos e iconos se muestren en español.
                 eventColor: '#B91116', //Color de los iconos de eventos
             });

             //Llamada al renderizado del elemento de calendario.            
             calendar.render();

         });
     </script>
 @endif

 {{-- Función de JavaScript, Su función es escuchar al botón del lado del sidebar para cerrar sesión, --}}
 <script>
     function logoutFunction() {
         //llamada para subir formulario de cierre de sesión.
         document.getElementById('logout-form').submit();
     }
     //Escucha del click en el sidebar, si lo detecta ejecutará la función logoutFunction.
     document.getElementById("logout-form-click").addEventListener("click", logoutFunction);
 </script>

 <script>
     // Inicializado de Tooltips 
     $(function() {
         $('[data-toggle="tooltip"]').tooltip()
     })
 </script>

@endsection
