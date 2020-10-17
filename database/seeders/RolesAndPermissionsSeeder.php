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

        //crear usuario
        $userCreate = Permission::create([
          'name' => 'user_create',
          'title' => 'crear_usuario'
        ]);
        array_push($permissionsAdmin_array, $userCreate);

        //editar usuario
        $userEdit = Permission::create([
          'name' => 'user_edit',
          'title' => 'crear_usuario'
        ]);
        array_push($permissionsAdmin_array, $userEdit);

        //cambiar estado de usuario
        $userStatus = Permission::create([
          'name' => 'user_status',
          'title' => 'estado_usuario'
        ]);
        array_push($permissionsAdmin_array, $userStatus);

        //ver acceso de control
        $seeAccessControl = Permission::create([
          'name' => 'see_access_control',
          'title' => 'ver_control_acceso'
        ]);
        array_push($permissionsAdmin_array, $seeAccessControl);

        //crear registro entrada
        $entryRegister = Permission::create([
          'name' => 'entry_register',
          'title' => 'registro_entrada'
        ]);
        array_push($permissionsAdmin_array, $entryRegister);

        //crear registro salida
        $outputRegister = Permission::create([
          'name' => 'output_register',
          'title' => 'registro_salida'
        ]);
        array_push($permissionsAdmin_array, $outputRegister);

        //crear pago
        $createPayment = Permission::create([
          'name' => 'create_payment',
          'title' => 'crear_pago'
        ]);
        array_push($permissionsAdmin_array, $createPayment);

        //anular pago
        $cancelPayment = Permission::create([
          'name' => 'cancel_payment',
          'title' => 'anular_pago'
        ]);
        array_push($permissionsAdmin_array, $cancelPayment);

        //motivo de cancelación pago
        $cancellationReasonPayment = Permission::create([
          'name' => 'cancellation_reason_payment',
          'title' => 'motivo_cancelacion_pago'
        ]);
        array_push($permissionsAdmin_array, $cancellationReasonPayment);

        //crear motivo de cancelacion pago
        $createReasonCancellationPayment = Permission::create([
          'name' => 'create_reason_cancellation_payment',
          'title' => 'crear_motivo_cancelacion_pago'
        ]);
        array_push($permissionsAdmin_array, $createReasonCancellationPayment);

        //editar motivo de cancelacion pago
        $editReasonCancellationPayment = Permission::create([
          'name' => 'edit_reason_cancellation_payment',
          'title' => 'editar_motivo_cancelacion_pago'
        ]);
        array_push($permissionsAdmin_array, $editReasonCancellationPayment);

        //estado motivo de cancelación pago
        $statusReasonPaymentCancellation = Permission::create([
          'name' => 'status_reaso_payment_cancellation',
          'title' => 'estado_motivo_cancelacion_pago'
        ]);
        array_push($permissionsAdmin_array, $statusReasonPaymentCancellation);

        //crear genero
        $createGender = Permission::create([
          'name' => 'create_gender',
          'title' => 'crear_genero'
        ]);
        array_push($permissionsAdmin_array, $createGender);

        //editar genero
        $editGender = Permission::create([
          'name' => 'edit_gender',
          'title' => 'editar_genero'
        ]);
        array_push($permissionsAdmin_array, $editGender);

        //cambiar estado de genero
        $genderStatus = Permission::create([
          'name' => 'gender_status',
          'title' => 'estado_genero'
        ]);
        array_push($permissionsAdmin_array, $genderStatus);

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
