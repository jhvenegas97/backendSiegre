<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;


class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'academic-level-list',
            'academic-level-create',
            'academic-level-edit',
            'academic-level-delete',
            'academic-list',
            'academic-create',
            'academic-edit',
            'academic-delete',
            'category-publication-list',
            'category-publication-create',
            'category-publication-edit',
            'category-publication-delete',
            'faculty-list',
            'faculty-create',
            'faculty-edit',
            'faculty-delete',
            'program-list',
            'program-create',
            'program-edit',
            'program-delete',
            'publication-list',
            'publication-create',
            'publication-edit',
            'publication-delete',
            'publication-admin-list',
            'publication-admin-create',
            'publication-admin-edit',
            'publication-admin-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'work-type-list',
            'work-type-create',
            'work-type-edit',
            'work-type-delete',
            'work-list',
            'work-create',
            'work-edit',
            'work-delete'
         ];

         $permissionsNameEgresado = [
            'publication-list',
            'publication-create',
            'publication-edit',
            'publication-delete'
         ];

         $permissionsNameGestor = [
            'publication-list',
            'publication-create',
            'publication-edit',
            'publication-delete',
            'publication-admin-list',
            'publication-admin-create',
            'publication-admin-edit',
            'publication-admin-delete'
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }

        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleGestor = Role::create(['name' => 'Gestor']);
        $roleEgresado = Role::create(['name' => 'Egresado']);

        $permissionsEgresado = array();
        $permissionsGestor = array();

        foreach ($permissionsNameEgresado as $permission) {
            array_push($permissionsEgresado,Permission::where('name','=',$permission)->pluck('id','id'));
        }

        foreach ($permissionsNameGestor as $permission) {
            array_push($permissionsGestor,Permission::where('name','=',$permission)->pluck('id','id'));
        }
     
        $permissionsAdmin = Permission::pluck('id','id')->all();

        $roleAdmin->syncPermissions($permissionsAdmin);
        $roleGestor->syncPermissions($permissionsGestor);
        $roleEgresado->syncPermissions($permissionsEgresado);

        $userAdmin = User::create([
            'name' => 'Usuario Administrador', 
            'email' => 'admin@gmail.com',
            'identification_id' => '401',
            'password' => bcrypt('Ei55&9')
        ]);

        $userGestor = User::create([
            'name' => 'Usuario Gestor', 
            'email' => 'adminGestor@gmail.com',
            'identification_id' => '403',
            'password' => bcrypt('Ei55&9')
        ]);

        $userEgresado = User::create([
            'name' => 'Usuario Egresado', 
            'email' => 'adminEgresado@gmail.com',
            'identification_id' => '402',
            'password' => bcrypt('Ei55&9')
        ]);

        $userAdmin->assignRole([$roleAdmin->id]);
        $userGestor->assignRole([$roleGestor->id]);
        $userEgresado->assignRole([$roleEgresado->id]);
    }
}
