<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role; //Llamada al modelo Roles creado por la libreria Spatie/Laravel Permissions
use Spatie\Permission\Models\Permission; //Importación del modelo de permisos de Spatie/Laravel Permissions


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creación de roles
        $role1 = Role::create(['name'=>'Administrador']); //Variable que alojará los datos del nuevo rol a almacenar, en este caso a administrador, tambien en la llamada al modelo se creará este rol.
        $role2 = Role::create(['name'=>'Usuario']);

        // Permission::create(['name' => 'admin.home']); //Por buena practica es recomendable utilizar como nombre de permiso el mismo nombre de la vista que va a recibir el permiso, en este caso admin.home
        // Permission::create(['name' => 'admin.home'])->assignRole($role1); //Esta manera de asignar roles es liimitada a unicamente 1 permiso que estara asignado a 1 solo rol, uso no recomendado.

        Permission::create(['name' => 'admin.home','description'=>'Ver el dashboard'])->syncRoles([$role1, $role2]); //syncRoles le da los permisos de esa pagina a los roles asignados

        Permission::create(['name' => 'admin.categories.index','description' => 'Ver listado de Categorias'])->syncRoles([$role1,$role2]); //Creación de permisos para paginas de CRUD de categorias
        Permission::create(['name' => 'admin.categories.create','description' => 'Crear categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categories.edit','description' => 'Editar categorias'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.categories.destroy','description' => 'Eliminar Categorias'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'admin.elements.index','description' => 'Ver listado de elementos'])->syncRoles([$role1, $role2]); //Creación de permisos para paginas de CRUD de Elementos
        Permission::create(['name' => 'admin.elements.create','description' => 'Crear elementos'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.elements.edit','description' => 'Editar elementos'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'admin.elements.destroy','description' => 'Eliminar elementos'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.tags.index','description' => 'Ver listado de etiquetas'])->syncRoles([$role1,$role2]); //Creación de permisos para paginas de CRUD de tags,$role2
        Permission::create(['name' => 'admin.tags.create','description' => 'Crear Etiquetas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.tags.edit','description' => 'Editar Etiquetas'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.tags.destroy','description' => 'Eliminar Etiquetas'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.funds.index','description' => 'Ver listado de fondos'])->syncRoles([$role1,$role2]); //Creación de permisos para paginas de CRUD de Fondos
        Permission::create(['name' => 'admin.funds.create','description' => 'Crear fondos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.funds.edit','description' => 'Editar fondos'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.funds.destroy','description' => 'Eliminar fondos'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.roles.index','description' => 'Ver listado de roles'])->syncRoles([$role1]); //Creación de permisos para paginas de CRUD de Fondos
        Permission::create(['name' => 'admin.roles.create','description' => 'Crear rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.edit','description' => 'Editar permisos de rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.roles.destroy','description' => 'Eliminar rol'])->syncRoles([$role1]);

        Permission::create(['name' => 'admin.users.edit','description' => 'Asignar un Rol'])->syncRoles([$role1]); //Asignación de roles.
        Permission::create(['name' => 'admin.users.index','description' => 'Ver listado de usuarios'])->syncRoles([$role1]); //Creación de permisos para paginas de CRUD de Usuarios


        Permission::create(['name' => 'admin.conveyances.index','description' => 'Ver listado de traspasos'])->syncRoles([$role1,$role2]);

        //Permisos para páginas de mantenimiento
        Permission::create(['name' => 'admin.maintenances.index','description' => 'Ver listado de mantenimientos'])->syncRoles([$role1,$role2]); //Observar maintenances.index
        Permission::create(['name' => 'admin.maintenances.create','description' => 'Crear registros de mantenimiento'])->syncRoles([$role1]); //Crear 
        Permission::create(['name' => 'admin.maintenances.print','description' => 'Imprimir listado de mantenimientos'])->syncRoles([$role1,$role2]);

        //Permisos de vistas para importación y exportación
        Permission::create(['name' => 'admin.database.index','description' => 'Ver página de Exportaciones/Importaciones'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.database.export','description' => 'Exportar registros de elementos'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.database.import','description' => 'Importar registros de elementos'])->syncRoles([$role1]); //Será utilizado para tambien vista upload
        Permission::create(['name' => 'admin.database.dump','description' => 'Exportar base de datos en archivo .sql'])->syncRoles([$role1]); //Será utilizado para tambien vista upload

        //Permiso para manipular el calendario
        Permission::create(['name' => 'admin.event.ajax','description' => 'Manipular calendario de eventos'])->syncRoles([$role1]); //Será utilizado para tambien vista upload

        //Permiso para enviar notificaciones
        Permission::create(['name' => 'admin.notifications.index','description' => 'Enviar notificaciones por medio del canal de Telegram'])->syncRoles([$role1]); //Será utilizado para tambien vista upload


    }
}
