<?php

namespace App\Http\Controllers;

use App\Models\AccessControl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AccessControlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return AccessControl::with('user')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      try {
        DB::beginTransaction();

        $data = $request->all();
        $data['user_id'] = Auth::user()->id; //trae el usuario que esta autenticado
        $accessControl = AccessControl::created($data);
        DB::commit();

        if ($accessControl) {
          return response()->json([
            'type' => 'success',
            'message' => 'Registro almacenado',
            'data' => $accessControl
          ], 202);
        }else{
          return response()->json([
            'type' => 'error',
            'message' => 'Error al registrar',
            'data' =>[]
          ], 204);
        }
      } catch (Exception $e){
          return response()->json([
            'type' => 'error',
            'message' => 'Error registro',
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
        $accessControl = AccessControl::find($id);

        $accessControl->state = !$accessControl->state;
        $accessControl->save();

        DB::commit(); //commit de la transaccion

        if ($accessControl) {
          return response()->json([
            'type' => 'success',
            'message' => 'regitro exitoso',
            'data' => $accessControl->state
          ], 202);
        }else{
          return response()->json([
            'type' => 'error',
            'message' => 'Error',
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
     * Display the specified resource.
     *
     * @param  \App\Models\AccessControl  $accessControl
     * @return \Illuminate\Http\Response
     */
    public function show(AccessControl $accessControl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AccessControl  $accessControl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccessControl $accessControl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AccessControl  $accessControl
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccessControl $accessControl)
    {
        //
    }
}
