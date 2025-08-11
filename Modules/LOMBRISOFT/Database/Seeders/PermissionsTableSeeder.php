<?php

namespace Modules\LOMBRISOFT\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Permission;
use Modules\SICA\Entities\Role;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        // Obtener aplicación LOMBRISOFT
        $app = App::where('name', 'LOMBRISOFT')->first();

        /** ============================================
         *  PERMISOS PARA ADMINISTRADOR
         *  ============================================ */
        $permissions_admin = [];

        // Acceso al panel de administrador
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.welcome'],
            [
                'name' => 'Acceso al Rol de Administrador',
                'description' => 'Acceso al Rol de Administrador',
                'description_english' => 'Access to the Administrator Role',
                'app_id' => $app->id,
            ]
        )->id;

        // Acceso a la lista de camas (index)
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.camas.index'],
            [
                'name' => 'Acceso a la lista de camas',
                'description' => 'Permite acceder a la lista de camas del administrador',
                'description_english' => 'Allows access to the administrator worm bed list',
                'app_id' => $app->id,
            ]
        )->id;

        // Crear camas (create)
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.camas.create'],
            [
                'name' => 'Crear camas',
                'description' => 'Permite crear nuevas camas',
                'description_english' => 'Allows creating new worm beds',
                'app_id' => $app->id,
            ]
        )->id;
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.camas.store'],
            [
                'name' => 'Crear camas',
                'description' => 'Permite crear nuevas camas',
                'description_english' => 'Allows creating new worm beds',
                'app_id' => $app->id,
            ]
        )->id;

        // Ver detalles de cama (show)
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.camas.show'],
            [
                'name' => 'Ver detalles de cama',
                'description' => 'Permite ver los detalles de una cama',
                'description_english' => 'Allows viewing worm bed details',
                'app_id' => $app->id,
            ]
        )->id;

        // Editar camas (edit)
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.camas.edit'],
            [
                'name' => 'Editar camas',
                'description' => 'Permite editar la información de las camas',
                'description_english' => 'Allows editing worm beds',
                'app_id' => $app->id,
            ]
        )->id;

        // Guardar cambios (actualizar camas - update)
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.camas.update'],
            [
                'name' => 'Guardar cambios de camas',
                'description' => 'Permite guardar los cambios realizados en las camas',
                'description_english' => 'Allows saving worm bed changes',
                'app_id' => $app->id,
            ]
        )->id;

        // Eliminar camas (destroy)
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.camas.destroy'],
            [
                'name' => 'Eliminar camas',
                'description' => 'Permite eliminar camas',
                'description_english' => 'Allows deleting worm beds',
                'app_id' => $app->id,
            ]
        )->id;
        /** ============================================
         *  PERMISOS PARA MATERIALES (ADMINISTRADOR)
         *  ============================================ */
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.materials.index'],
            [
                'name' => 'Acceso a la lista de materiales',
                'description' => 'Permite acceder a la lista de materiales del administrador',
                'description_english' => 'Allows access to the administrator material list',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.materials.create'],
            [
                'name' => 'Crear materiales',
                'description' => 'Permite crear nuevos materiales',
                'description_english' => 'Allows creating new materials',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.materials.store'],
            [
                'name' => 'Guardar materiales',
                'description' => 'Permite guardar nuevos materiales',
                'description_english' => 'Allows storing new materials',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.materials.show'],
            [
                'name' => 'Ver detalles de material',
                'description' => 'Permite ver los detalles de un material',
                'description_english' => 'Allows viewing material details',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.materials.edit'],
            [
                'name' => 'Editar materiales',
                'description' => 'Permite editar la información de los materiales',
                'description_english' => 'Allows editing materials',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.materials.update'],
            [
                'name' => 'Guardar cambios de materiales',
                'description' => 'Permite guardar los cambios realizados en los materiales',
                'description_english' => 'Allows saving material changes',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.materials.destroy'],
            [
                'name' => 'Eliminar materiales',
                'description' => 'Permite eliminar materiales',
                'description_english' => 'Allows deleting materials',
                'app_id' => $app->id,
            ]
        )->id;
        /** ============================================
         *  PERMISOS PARA MOVIMIENTOS DE MATERIALES (ADMINISTRADOR)
         *  ============================================ */
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.movements.index'],
            [
                'name' => 'Acceso a la lista de movimientos',
                'description' => 'Permite acceder a la lista de movimientos de materiales',
                'description_english' => 'Allows access to the material movements list',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.movements.create'],
            [
                'name' => 'Crear movimientos',
                'description' => 'Permite crear nuevos movimientos de materiales',
                'description_english' => 'Allows creating new material movements',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.movements.store'],
            [
                'name' => 'Guardar movimientos',
                'description' => 'Permite guardar nuevos movimientos de materiales',
                'description_english' => 'Allows storing new material movements',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.movements.show'],
            [
                'name' => 'Ver detalles de movimiento',
                'description' => 'Permite ver los detalles de un movimiento de material',
                'description_english' => 'Allows viewing material movement details',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.movements.destroy'],
            [
                'name' => 'Eliminar movimientos',
                'description' => 'Permite eliminar movimientos de materiales',
                'description_english' => 'Allows deleting material movements',
                'app_id' => $app->id,
            ]
        )->id;
        /** ============================================
         *  PERMISOS PARA ACTIVIDADES EN CAMAS (ADMINISTRADOR)
         *  ============================================ */
        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.bed_activities.index'],
            [
                'name' => 'Acceso a la lista de actividades',
                'description' => 'Permite acceder a la lista de actividades de camas',
                'description_english' => 'Allows access to worm bed activities list',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.bed_activities.create'],
            [
                'name' => 'Crear actividades',
                'description' => 'Permite crear nuevas actividades en camas',
                'description_english' => 'Allows creating new bed activities',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.bed_activities.store'],
            [
                'name' => 'Guardar actividades',
                'description' => 'Permite guardar nuevas actividades en camas',
                'description_english' => 'Allows storing new bed activities',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.bed_activities.edit'],
            [
                'name' => 'Editar actividades',
                'description' => 'Permite editar actividades en camas',
                'description_english' => 'Allows editing bed activities',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.bed_activities.update'],
            [
                'name' => 'Actualizar actividades',
                'description' => 'Permite actualizar actividades en camas',
                'description_english' => 'Allows updating bed activities',
                'app_id' => $app->id,
            ]
        )->id;

        $permissions_admin[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.admin.bed_activities.destroy'],
            [
                'name' => 'Eliminar actividades',
                'description' => 'Permite eliminar actividades en camas',
                'description_english' => 'Allows deleting bed activities',
                'app_id' => $app->id,
            ]
        )->id;
        /** ============================================
 *  PERMISOS PARA ALERTAS DE ACTIVIDADES (ADMINISTRADOR)
 *  ============================================ */
$permissions_admin[] = Permission::updateOrCreate(
    ['slug' => 'lombrisoft.admin.activity_alerts.index'],
    [
        'name' => 'Acceso a la lista de alertas',
        'description' => 'Permite acceder a la lista de alertas de actividades',
        'description_english' => 'Allows access to activity alerts list',
        'app_id' => $app->id,
    ]
)->id;

$permissions_admin[] = Permission::updateOrCreate(
    ['slug' => 'lombrisoft.admin.activity_alerts.create'],
    [
        'name' => 'Crear alertas',
        'description' => 'Permite crear nuevas alertas para actividades',
        'description_english' => 'Allows creating new activity alerts',
        'app_id' => $app->id,
    ]
)->id;

$permissions_admin[] = Permission::updateOrCreate(
    ['slug' => 'lombrisoft.admin.activity_alerts.store'],
    [
        'name' => 'Guardar alertas',
        'description' => 'Permite guardar nuevas alertas para actividades',
        'description_english' => 'Allows storing new activity alerts',
        'app_id' => $app->id,
    ]
)->id;

$permissions_admin[] = Permission::updateOrCreate(
    ['slug' => 'lombrisoft.admin.activity_alerts.show'],
    [
        'name' => 'Ver detalles de alerta',
        'description' => 'Permite ver los detalles de una alerta de actividad',
        'description_english' => 'Allows viewing activity alert details',
        'app_id' => $app->id,
    ]
)->id;

$permissions_admin[] = Permission::updateOrCreate(
    ['slug' => 'lombrisoft.admin.activity_alerts.edit'],
    [
        'name' => 'Editar alertas',
        'description' => 'Permite editar alertas de actividades',
        'description_english' => 'Allows editing activity alerts',
        'app_id' => $app->id,
    ]
)->id;

$permissions_admin[] = Permission::updateOrCreate(
    ['slug' => 'lombrisoft.admin.activity_alerts.update'],
    [
        'name' => 'Actualizar alertas',
        'description' => 'Permite actualizar alertas de actividades',
        'description_english' => 'Allows updating activity alerts',
        'app_id' => $app->id,
    ]
)->id;

$permissions_admin[] = Permission::updateOrCreate(
    ['slug' => 'lombrisoft.admin.activity_alerts.destroy'],
    [
        'name' => 'Eliminar alertas',
        'description' => 'Permite eliminar alertas de actividades',
        'description_english' => 'Allows deleting activity alerts',
        'app_id' => $app->id,
    ]
)->id;



        // Asignar permisos al rol administrador
        $rol_admin = Role::where('slug', 'lombrisoft.admin')->first();
        $rol_admin->permissions()->syncWithoutDetaching($permissions_admin);


        /** ============================================
         *  PERMISOS PARA PASANTE
         *  ============================================ */
        $permissions_intern = [];

        // Acceso al panel del pasante
        $permissions_intern[] = Permission::updateOrCreate(
            ['slug' => 'lombrisoft.intern.paneli'],
            [
                'name' => 'Acceso al Rol de Pasante',
                'description' => 'Acceso al Rol de Pasante',
                'description_english' => 'Access to the Intern Role',
                'app_id' => $app->id,
            ]
        )->id;

        // Asignar permisos al rol pasante
        $rol_intern = Role::where('slug', 'lombrisoft.intern')->first();
        $rol_intern->permissions()->syncWithoutDetaching($permissions_intern);
    }
}
