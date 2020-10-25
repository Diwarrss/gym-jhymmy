<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
      //crear usuario
      try {
        DB::beginTransaction();
        $data = $request->all();
        $user = User::create($data);
        DB::commit(); //commit de la transaccion

        if ($user) {
          return response()->json([
            'type' => 'success',
            'message' => 'Usuario creado con éxito',
            'data' => $user
          ], 201);
        }else{
          return response()->json([
            'type' => 'error',
            'message' => 'Error al guardar',
            'data' => []
          ], 204);
        }
        /* return response()->json([
          'message' => 'Seguimiento creado con éxito',
          'data' => $user
        ], 201); */
      } catch (Exception $e) {
        DB::rollBack(); //si hay error no ejecute la transaccion
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tracing  $tracing
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
     * @param  \App\Models\Tracing  $tracing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tracing  $tracing
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}
