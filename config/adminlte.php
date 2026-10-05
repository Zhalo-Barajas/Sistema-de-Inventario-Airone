<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'Panel de administración',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => false,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Administración</b>',
    'logo_img' => '/../logotipos/garza2.png', //Ruta del logotipo, 18/06/24, logo reemplazado
    'logo_img_class' => 'brand-image', //En esta se pueden insertar clases de bootstrap
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => '/../logotipos/garza.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => '/../logotipos/garza.png', // Ruta original: vendor/adminlte/dist/img/AdminLTELogo.png
            'alt' => 'Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => false,
    'layout_fixed_sidebar' => true, //valor anterior: null
    'layout_fixed_navbar' => false, //Con esto el sidebar permanece fijo y el contenido a la derecha no //Valo anterior: null
    'layout_fixed_footer' => null,
    'layout_dark_mode' => null, //true para activa modo oscuro

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',// Clases para el cuerpo de la página
    'classes_brand' => 'bg-dark', //Estilos para el encabezado de la sidebar (Donde se encuentra el titulo y logo)
    'classes_brand_text' => '', //Estilos para el titulo de la barra de navegación
    'classes_content_wrapper' => '', //Estilos para el fondo de los contenedores
    'classes_content_header' => '', //Estilos para cabeceras de contenido
    'classes_content' => '', //Estilos para contenedores dentro de la plantilla
    // 'classes_sidebar' => 'sidebar-dark-primary elevation-4',
    // 'classes_sidebar' => 'sidebar-light-orange elevation-4',
    'classes_sidebar' => 'sidebar-light-orange elevation-4', //Estilos y colores para el sidebar y el elemento seleccionado (active)
    'classes_sidebar_nav' => '',
    // 'classes_topnav' => '',
    'classes_topnav' => '', // NOTA: Si se deja en blanco este conjunto de elementos (EN este caso la topnav bar será afectada por cambios de colores por el botón del tema) // Color y clases de la barra superior de navegación superior (Donde se encuentra el nombre del usuario y el retract del sidebar)
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => true, //Anterior: false //Aquí se guarda el estado de la sidebar (Si esta desplegada o no)
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-dark', //Original: 'os-theme-dark' //Tema de la scrollbar, cambiada a negro.
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => '/',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [ //Arreglo para agregar elementos al sidebar
        // Navbar items:
        // [
        //     'type' => 'navbar-search',
        //     'text' => 'search',
        //     'topnav_right' => true,
        // ],
        
        // [
        //     'type' => 'fullscreen-widget',
        //     'topnav_right' => true,
        // ],
        // Sidebar items:[
        
        [
            'type' => 'sidebar-menu-search',
            'text' => '¿Qué es lo que buscas?',
        ],
        // [
        //     'text' => 'blog',
        //     'url' => 'admin/blog',
        //     'can' => 'manage-blog',
        // ],
        [
            'text'        => 'Dashboard',
            'url'         => 'admin', //Lleva ahora a la interfaz de admin
            // 'route'       => 'admin.home' //Segunda forma de realizar la redirección del icono con rutas
            'icon'        => 'fas fa-terminal fa-fw', //Al final del nombre del icono se debe agregar  un fa-fw el cual separa el icono del texto un poco más

            // 'label'       => 4,
            // 'label_color' => 'success',
            'can'  => 'admin.home', //llamada a directiva blade de can
            // 'classes' => 'text-orange' //Funciona


        ],
        ['header' => 'Administración del sistema',
         'can'  => ['admin.categories.index', 'admin.tags.index','admin.funds.index']],
        [
            'text' => 'Categorías',
            'url'  => 'admin/categories/',
            'icon' => 'fab fa-fw fa-buffer', //Icono nuevo
            'active' => ['admin/categories*'],
            'icon_color' => 'red', 
            'can'  => 'admin.categories.index',
        ],
        [
            'text' => 'Etiquetas',
            'url'  => 'admin/tags/',
            'icon' => 'far fa-fw fa-bookmark', //Icono nuevo /CRUD etiquetas
            'active' => ['admin/tags*'], //Este codigo quiere decir que se resaltará el icono del dashboard en donde nos encontremos, en este caso se iluminará si nos encontramos en una de las paginas de la carpeta de vistas tag.
            'icon_color' => 'blue', 
            'can'  => 'admin.tags.index',//llamada a directiva blade de can
        ],
        [
            'text' => 'Fondos',
            'url'  => 'admin/funds/',
            'icon' => 'fas fa-money-check-alt', //Icono nuevo /CRUD fondos
            'active' => ['admin/funds*'], //Este codigo quiere decir que se resaltará el icono del dashboard en donde nos encontremos, en este caso se iluminará si nos encontramos en una de las paginas de la carpeta de vistas funs.
            'icon_color' => 'green', 
            'can'  => 'admin.funds.index',
        ],
        ['header' => 'Administración de Elementos',
         'can'  => ['admin.elements.index', 'admin.elements.create','admin.conveyances.index','admin.maintenances.index']],
        [
            'text'       => 'Lista de Elementos',
            'url'        => 'admin/elements/',
            'icon' => 'fas fa-fw fa-clipboard',
            'icon_color' => 'warning', 
            'can'  => 'admin.elements.index',//llamada a directiva blade de can
        ],
        [
            'text'       => 'Crear Nuevo Elemento',
            'url'        => 'admin/elements/create',
            'icon' => 'fas fa-fw fa-file',
            'can'  => 'admin.elements.create'
        ],
        [
            'text'       => 'Registro de Traspasos',
            'url'        => 'admin/conveyances/',
            'active' => ['admin/conveyances*'],
            'icon' => 'fas fa-exchange-alt',
            'icon_color' => 'teal', 
            'can'  => 'admin.conveyances.index',//llamada a directiva blade de can
        ],
        [ //Vista index de mantenimientos
            'text'       => 'Mantenimientos',
            'url'        => 'admin/maintenances/',
            'active' => ['admin/maintenances*'],
            'icon' => 'fas fa-tools',
            'icon_color' => 'olive', 
            'can'  => 'admin.maintenances.index',
        ],
        ['header' => 'Usuarios y Roles',
         'can'  => ['admin.users.index', 'admin.roles.index']],
        [
            'text'        => 'Usuarios',
            'route'         => 'admin.users.index', //Lleva a la pagina de index de administración de usuarios
            'active' => ['admin/users*'],
            'icon'        => 'fas fa-users fa-fw', //Al final del nombre del icono se debe agregar  un fa-fw el cual separa el icono del texto un poco más
            'icon_color' => 'danger', 
            'can'  => 'admin.users.index',//llamada a directiva blade de can
        ], //Añadido botón para el index del CRUD de usuarios

        [
            'text'        => 'Listado de Roles',
            'route'         => 'admin.roles.index', //Lleva a la pagina de index de administración de usuarios
            'active' => ['admin/roles*'],
            'icon_color' => 'success', 
            'icon'        => 'fas fa-users-cog fa-fw', //Al final del nombre del icono se debe agregar  un fa-fw el cual separa el icono del texto un poco más
            'can'  => 'admin.roles.index',

        ],
        ['header' => 'Exportación e Importación de Datos',
         'can'  => ['admin.database.index']],
        [
            'text'        => 'Base de Datos',
            'route'         => 'admin.database.index', //Lleva a la pagina de index de administración de usuarios
            'active' => ['admin/database*'],
            'icon_color' => 'primary', 
            'icon'        => 'fas fa-database', //Al final del nombre del icono se debe agregar  un fa-fw el cual separa el icono del texto un poco más
            'can'  => 'admin.database.index',
        ],
        ['header' => 'Centro de notificaciones',
        'can'  => ['admin.notifications.index']],
        [
            'text'        => 'Notificaciones',
            'route'         => 'admin.notifications.index', //Lleva a la pagina de index de administración de usuarios
            'active' => ['admin/notifications*'],
            // 'icon_color' => 'danger', 
            'icon'        => 'fas fa-mobile-alt', //Al final del nombre del icono se debe agregar  un fa-fw el cual separa el icono del texto un poco más
            'can'  => 'admin.notifications.index',
        ],





        //Header con el titulo 
        // ['header' => 'Iluminación'],
        // Este Bóton no redirige a ninguna pagina web, unicamente Activa el codigo embedido de JavaScript dedicado al cambio de color del tema (mediante la linea 'id' => 'toggle-dark-mode',)
        // [
        //     'text' => 'Modo Claro/Oscuro',
        //     'url'        => '#',
        //     'id' => 'toggle-dark-mode',
        //     'icon' => 'fas fa-lightbulb', 
        //     'active' => true,
        //     'icon_color' => 'yellow',   
        // ],
        
        //Este apartado se encarga de manejar la iluminación (o tema utilizado por el tema)
        [
            'type' => 'darkmode-widget',
            'topnav_right' => true,     // Or "topnav => true" to place on the left.
            'color_enabled' => 'purple',
            'color_disabled' => 'yellow',
            'icon_disabled' => 'fas fa-sun'
        ],
        ['header' => 'Sesión'],
        [ //Enlace que redirige a página de ajustes de cuenta
            'text'        => 'Configuración de Cuenta',
            'route'         => 'profile.show', //Lleva a la pagina de index de administración de usuarios
            // 'active' => ['admin/notifactions*'],
            'icon_color' => 'success', 
            'icon' => 'fas  fa-cogs', //Al final del nombre del icono se debe agregar  un fa-fw el cual separa el icono del texto un poco más
            // 'can'  => 'admin.notifications.index',
        ],
        // Este Botón no redirige a ninguna pagina web, unicamente Activa el codigo embedido de JavaScript dedicado al cierre de sesión (mediante la linea 'id' => 'toggle-dark-mode',)
        [
            'text' => 'Cerrar Sesión',
            'url'        => '#',
            'id' => 'logout-form-click',
            'icon' => 'fas fa-power-off', 
            // 'active' => true,
            'icon_color' => 'red',  
        ],
        [ //Botón que redirige a página acerca de.
            'text'        => 'Acerca de',
            'route'         => 'landing.about', //Lleva a la pagina de index de administración de usuarios
            // 'active' => ['admin/notifactions*'],
            'icon_color' => 'info', 
            'icon' => 'fas fa-info-circle', //Al final del nombre del icono se debe agregar  un fa-fw el cual separa el icono del texto un poco más
            // 'can'  => 'admin.notifications.index',
        ],
        
        // [
        //     'text' => 'warning',
        //     'icon_color' => 'yellow',
        //     'url' => '#',
        // ],
        // [
        //     'text' => 'information',
        //     'icon_color' => 'cyan',
        //     'url' => '#',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        //Importación de librerias para la plantilla de admin LTE, añadidas librerias para el calendario, en este caso recuperadas de instacias local descargada de Fullcalendar.
        'FullCalendar' => [
            'active' => false,
            'files' => [
                // Core
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/fullcalendar/main.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/fullcalendar/main.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/fullcalendar/locales-all.js',
                ],
            ],
        ],
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => true, //Habilitar libreria livewire y sus componentes dentro de las páginas de la plantilla adminlte
];
