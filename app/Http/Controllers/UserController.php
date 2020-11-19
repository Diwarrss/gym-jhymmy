<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash as FacadesHash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
      return User::with('roles', 'gender', 'state')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestUser $request)
    {
      //crear usuario
      try {
        DB::beginTransaction();
        $data = $request->all();
        $data['pin'] = 0000;/* trae el usuario q esta autenticado */
        $data['password'] = FacadesHash::make($request->password);
        $user = User::create($data);
        DB::commit(); //commit de la transaccion

        if ($user) {
          return response()->json([
            'type' => 'success',
            'message' => 'Creado con éxito',
            'data' => $user
          ], 202);
        }else{
          return response()->json([
            'type' => 'error',
            'message' => 'Error al guardar',
            'data' =>[]
          ], 204);
        }
      } catch (Exception $e){
          return response()->json([
            'type' => 'error',
            'message' => 'Error al guardar',
            'data' =>[]
          ], 204);
          DB::rollBack(); //si hay un error no se ejecuta la transaccion
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      //return $id;
      try {
        DB::beginTransaction();

        //$data request->all
        $user = User::find($id);
        //validacion que sea unico
        $request->validate([
          'identification' => 'required|max:200|unique:users,identification,' . $id,
          'email' => 'required|unique:users,email,' . $id
        ]);

        // table,column,except,idColumn
        $user->identification = $request->identification;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->gender_id = $request->gender_id;
        $user->state_id = $request->state_id;
        if ($request->password != null) {
          $user->password = FacadesHash::make($request->password);
        }

        $user->save();

        DB::commit(); //commit de la transaccion

        if ($user) {
        return response()->json([
          'type' => 'success',
          'message' => 'Actualización con exito',
          'data' => $user
        ], 202);
      }else{
        return response()->json([
          'type' => 'error',
          'message' => 'Error al actualizar',
          'data' =>[]
        ], 204);
      }

      } catch (Exception $e){
        return response()->json([
          'type' => 'error',
          'message' => 'Error al actualizar',
          'data' =>[]
        ], 204);
        DB::rollBack(); //si hay un error no se ejecuta la transaccion
      }
    }

    public function updateState(Request $request, $id)
    {
      try {
        DB::beginTransaction();

        //$data request->all
        $user = User::find($id);

        if ($user->state) {
          $user->state = false;
        } else {
          $user->state = true;
        }
        $user->save();

        DB::commit(); //commit de la transaccion

        if ($user) {
          return response()->json([
            'type' => 'success',
            'message' => 'Actualización con éxito',
            'data' => $user->user
          ], 202);
        }else{
          return response()->json([
            'type' => 'error',
            'message' => 'Error al actualizar',
            'data' =>[]
          ], 204);
        }

      } catch (Exception $e){
        return response()->json([
          'type' => 'error',
          'message' => 'Error al actualizar',
          'data' =>[]
        ], 204);
        DB::rollBack(); //si hay un error no se ejecuta la transaccion
      }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }

    public function changePassword(Request $request)
    {//cambiar la contraseña de usuario
      /*
      * Validate all input fields
      */
      $request->validate([
        'old_password'     => 'required',//valida que la contraseña consida con la que tiene la base de datos
        'new_password'     => 'required|min:8',//valida que la nueva ocntraseña cumpla con los parametros necesarios
        'confirm_password' => 'required|same:new_password',//valida que consida con la nueva conrtaseña
      ]);
      $data = $request->all();//captura los parametros q vienen en la petición
      $user = User::find(Auth::user()->id);//Busca registro por ID
      //return FacadesHash::check($request->old_password, $user->password);
      if ($user) {
        if (FacadesHash::check($request->old_password, $user->password)) {//validamos que la iformacion de la contraseña actual coincida
          // The passwords match...
          //guarda la nueva contraseña encriptada en la base de datos
          $user->fill([
            'password' => FacadesHash::make($request->new_password)
          ])->save();

          return response()->json([//respuesta de exito
            'type' => 'success',
            'message' => 'Actualizado con éxito',
            'data' => $user->state
          ], 202);
        }else{//no conincide la contraseña actual con la información
          return response()->json([
            'type' => 'error',
            'message' => 'la contraseña actual no coincide',
            'data' => []
          ], 202);
        }
      }
    }

    //cambiar username y e-mail de usuario logueado (acount)
    public function changeData(Request $request)
    {
      /*
      * Validate all input fields
      //validations->valida q el nombre y el e-mail no esten en la base de datos
      */
      $request->validate([
        'username' => 'required|max:30|unique:users,username,' . Auth::user()->id,
        'email' => 'required|max:130|unique:users,email,' . Auth::user()->id
      ]);

      $user = User::find(Auth::user()->id);//Busca registro por ID
      if ($user) {
        $user->username = $request->username;
        $user->email = $request->email;
        $user->save();//Guarda la informacion del registro

        if ($user) {//respuesta exitosa
          return response()->json([
            'type' => 'success',
            'message' => 'Actualizado con éxito',
            'data' => $user
          ], 202);
        }else{//respuesta de error
          return response()->json([
            'type' => 'error',
            'message' => 'Error al actualizar',
            'data' => []
          ], 204);
        }

      }
    }
}
