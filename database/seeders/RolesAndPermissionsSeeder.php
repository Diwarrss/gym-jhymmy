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
        $permissionsClient_array = [];

        //ver sidebar
        $showPanelAdmin = Permission::create([
          'name' => 'show_panel_admin',
          'title' => 'ver_panel_administrador'
        ]);
        array_push($permissionsAdmin_array, $showPanelAdmin);
        array_push($permissionsClient_array, $showPanelAdmin);

        //ver usuario
        $userSee = Permission::create([
          'name' => 'view_user',
          'title' => 'ver_usuario'
        ]);
        array_push($permissionsAdmin_array, $userSee);

        //crear usuario
        $userCreate = Permission::create([
          'name' => 'user_create',
          'title' => 'crear_usuario'
        ]);
        array_push($permissionsAdmin_array, $userCreate);

        //editar usuario
        $userEdit = Permission::create([
          'name' => 'user_edit',
          'title' => 'editar_usuario'
        ]);
        array_push($permissionsAdmin_array, $userEdit);

        //cambiar estado de usuario
        $userStatus = Permission::create([
          'name' => 'user_status',
          'title' => 'estado_usuario'
        ]);
        array_push($permissionsAdmin_array, $userStatus);

        //ver control de acceso
        $seeAccessControl = Permission::create([
          'name' => 'see_access_control',
          'title' => 'ver_control_acceso'
        ]);
        array_push($permissionsAdmin_array, $seeAccessControl);

        //crear registro control de acceso
        $entryRegister = Permission::create([
          'name' => 'create_access_controll',
          'title' => 'crear_control_acceso'
        ]);
        array_push($permissionsAdmin_array, $entryRegister);

        //anular control de acceso
        $outputRegister = Permission::create([
          'name' => 'cancel_access_controll',
          'title' => 'anular_control_acceso'
        ]);
        array_push($permissionsAdmin_array, $outputRegister);

        //ver seguimiento
        $tracingSee = Permission::create([
          'name' => 'view_tracing',
          'title' => 'ver_seguimineto'
        ]);
        array_push($permissionsAdmin_array, $tracingSee);

        //crear registro seguimiento
        $tracingSee = Permission::create([
          'name' => 'create_tracing',
          'title' => 'ver_seguimineto'
        ]);
        array_push($permissionsAdmin_array, $tracingSee);

        //editar seguimiento
        $editTracing = Permission::create([
          'name' => 'edit_tracing',
          'title' => 'editar_seguimiento'
        ]);
        array_push($permissionsAdmin_array, $editTracing);

        //anular seguimiento
        $outputTracing = Permission::create([
          'name' => 'cancel_tracing',
          'title' => 'anular_seguimineto'
        ]);
        array_push($permissionsAdmin_array, $outputTracing);

        //ver pago
        $paymentSee = Permission::create([
          'name' => 'view_payment',
          'title' => 'ver_pago'
        ]);
        array_push($permissionsAdmin_array, $paymentSee);

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

        //ver genero
        $genderSee = Permission::create([
          'name' => 'see_gender',
          'title' => 'ver_genero'
        ]);
        array_push($permissionsAdmin_array, $genderSee);

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

        //ver estado
        $stateSee = Permission::create([
          'name' => 'see_state',
          'title' => 'ver_estado'
        ]);
        array_push($permissionsAdmin_array, $stateSee);

        //crear estado
        $createState = Permission::create([
          'name' => 'create_state',
          'title' => 'crear_estado'
        ]);
        array_push($permissionsAdmin_array, $createState);

        //editar estado
        $editState = Permission::create([
          'name' => 'edit_state',
          'title' => 'editar_estado'
        ]);
        array_push($permissionsAdmin_array, $editState);

        //cambiar estado
        $stateStatus = Permission::create([
          'name' => 'state_status',
          'title' => 'estado_estado'
        ]);
        array_push($permissionsAdmin_array, $stateStatus);

        /* creacion de roll */
        $superAdminRole = Role::create(['name' => 'super_admin']);
        /* asiganacion de permisos por array al roll */
        $superAdminRole->syncPermissions($permissionsAdmin_array);

        $clientRole = Role::create(['name' => 'viewer']);
        $clientRole->syncPermissions($permissionsClient_array);

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
