<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestUser;
use App\Models\User;
use App\Http\Requests\UserRequest;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        $user->state = !$user->state;
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
}
