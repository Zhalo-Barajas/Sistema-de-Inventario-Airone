<nav class="bg-orange-600" x-data="{open: false}">
{{-- En la directiva de alpine en este campo le esta diciendo que la variable open: es false, es decir que no se va a desplegar nada la pestaña en la que dependa esta variable --}}

    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Botón del menú móvil-->
          <button type="button" x-on:click="open = true"  class="inline-flex items-center justify-center rounded-md p-2 text-slate-100 hover:bg-orange-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <!--
              Icon when menu is closed.
  
              Menu open: "hidden", Menu closed: "block"
            -->
            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!--
              Icon when menu is open.
  
              Menu open: "block", Menu closed: "hidden"
            -->
            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>


        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          
                
            <a href="/" class="flex flex-shrink-0 items-center">
            {{-- Etiqueta href hacia nuestra pagina pricipal --}}
      
            {{-- Insertados enlaces al logo dentro de las carpetas dedicada a logotipos. usar /../ para evitar que errores al encontrar el logo y desplegarlo en la pagina (como courriria con ./)  --}}
            <img class="block h-8 w-auto lg:hidden" src="/../logotipos/garza2.png" alt="logo"> {{-- Logotipo --}}
            <img class="hidden h-8 w-auto lg:block" src="/../logotipos/garza2.png" alt="logo">
            </a>

          {{-- Menu lg --}}
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">

              {{-- La directiva foreach va a imprimir en el menu superior las etiquetas que existen en la base de datos --}}

              
              <a href="{{route('landing.index')}}" class="text-slate-100 hover:bg-orange-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"><i class="fas fa-paper-plane"></i>&nbsp;&nbsp;Landpage</a>
              {{-- En la linea href estamos llamando a la ruta de PostController a l Pagina elements/category--}}
              @can('admin.home') 
              <a href="{{route('admin.home')}}" class="text-slate-100 hover:bg-orange-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"><i class="fas fa-desktop"></i>&nbsp;&nbsp;Dashboard</a>
              @endcan
              <a href="{{route('profile.show')}}" class="text-slate-100 hover:bg-orange-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"><i class="fas fa-cogs"></i>&nbsp;&nbsp;Cuenta</a>
              <a href="{{route('landing.about')}}" class="text-slate-100 hover:bg-orange-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium"><i class="fas fa-info-circle"></i>&nbsp;&nbsp;Acerca de</a>
              
            </form>
            </div>
          </div>
        </div>

        <div class="hidden sm:ml-6 sm:block">
          <div class="flex space-x-4">
          <a href="{{route('profile.show')}}"  class="text-slate-100 hover:bg-orange-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
            {{Auth::user()->name}}
          </a>
          <form method="POST" action="{{ route('logout') }}" x-data>
            @csrf
          <button type="submit" class="text-slate-100 hover:bg-orange-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium" @click.prevent="$root.submit();">
            <p><i class="text-red-700 fas fa-power-off"></i>  Cerrar Sesión</p>
          </button>
          </div>
        </div>
        
      </div>
      {{--  --}}
    </div>
  
    <!-- Menu móvil -->
    <div class="sm:hidden" id="mobile-menu" x-show= 'open' x-on:click.away="open = false">
      <div class="space-y-1 px-2 pb-3 pt-2">

        {{-- <a href="#" class="text-gray-300 hover:bg-orange-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Projects</a> --}}
        
        <a href="{{route('landing.index')}}" class="text-slate-100 hover:bg-orange-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Landpage</a>
        {{-- En la linea href estamos llamando a la ruta de PostController a l Pagina elements/category--}}
        @can('admin.home') 
        <a href="{{route('admin.home')}}" class="text-slate-100 hover:bg-orange-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Dashboard</a>
        @endcan
        <a href="{{route('profile.show')}}" class="text-slate-100 hover:bg-orange-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Cuenta</a>

        
          <a href="{{route('landing.about')}}" class="text-slate-100 hover:bg-orange-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Acerca de</a>
  

        <form method="POST" action="{{ route('logout') }}" x-data>
          @csrf
          <button href="{{ route('logout') }}" class="text-slate-100 hover:bg-orange-700 hover:text-white block rounded-md px-3 py-2 text-base font-medium">Cerrar Sesión</button>
        </form>
      </div>
    </div>
  </nav>
