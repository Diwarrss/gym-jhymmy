<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash as FacadesHash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionsAdmin_array = [];
        $permissionsViewer_array = [];
        $permissionsManager_array = [];

        $showPanelAdmin = Permission::create([
          'name' => 'show_panel_admin',
          'title' => 'ver_panel_administrador'
        ]);
        array_push($permissionsAdmin_array, $showPanelAdmin);
        array_push($permissionsViewer_array, $showPanelAdmin);
        array_push($permissionsManager_array, $showPanelAdmin);

        /* creacion de roll */
        $superAdminRole = Role::create(['name' => 'super_admin']);
        /* asiganacion de permisos por array al roll */
        $superAdminRole->syncPermissions($permissionsAdmin_array);

        $viewerRole = Role::create(['name' => 'viewer']);
        $viewerRole->syncPermissions($permissionsViewer_array);

        $managerRole = Role::create(['name' => 'manager']);
        $managerRole->syncPermissions($permissionsManager_array);

        $superAdminRole = Role::create(['name' => 'invited']);
        $superAdminRole = Role::create(['name' => 'auditor']);
        $superAdminRole = Role::create(['name' => 'basic']);

        //creamos el usuario super admin
        $userSuperAdmin = User::create([
          'name' => 'Admin Admin',
          'identification' => '1101000000',
          'address' => 'calle falsa 123',
          'phone' => '3001234567',
          'birthdate' => now(),
          'email' => 'admin@argon.com',
          'email_verified_at' => now(),
          'password' => FacadesHash::make('secret'),
          'pin' => '1234',
          'state_id' => '1',
          'gender_id' => '1',
          'created_at' => now(),
          'updated_at' => now()
        ]);
        $userViewer = User::create([
          'name' => 'Cliente Cliente',
          'identification' => '987654321',
          'address' => 'calle falsa 123',
          'phone' => '3001234567',
          'birthdate' => now(),
          'email' => 'cliente@argon.com',
          'email_verified_at' => now(),
          'password' => FacadesHash::make('secret'),
          'pin' => '1234',
          'state_id' => '1',
          'gender_id' => '1',
          'created_at' => now(),
          'updated_at' => now()
        ]);

        $userSuperAdmin->assignRole('super_admin');
        $userViewer->assignRole('viewer');
    }
}
