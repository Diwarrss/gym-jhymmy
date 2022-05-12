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
      //return $request;
      try {
        DB::beginTransaction();

        $data = $request->all();
        /* $data['user_id'] = Auth::user()->id; */ //trae el usuario que esta autenticado
        $accessControl = AccessControl::create($data);

        /* dd($data); */
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
        return $e;
          return response()->json([
            'type' => 'error',
            'message' => 'Error registro',
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
    public function update(Request $request, $id)
    {
      try {
        DB::beginTransaction();

        //$data request->all
        $accessControl = AccessControl::find($id);

        //validacion
       /*  $request->validate([
          'name' => 'required|max:200|unique:accessControl$tracings,name,' . $id,
          'initials' => 'required|max:5|unique:tracing$tracings,initials,' . $id
        ]); */

      $accessControl->temperature = $request->temperature;
      $accessControl->save();

      DB::commit(); //commit de la transaccion

      if ($accessControl) {
        return response()->json([
          'type' => 'success',
          'message' => 'Actualización con éxito',
          'data' => $accessControl
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
        $accessControl = AccessControl::find($id);

        /* $accessControl->state = !$accessControl->state; */
        if ($accessControl->state) {
          $accessControl->state = false;
        } else {
          $accessControl->state = true;
        }
          $accessControl->save();

        DB::commit(); //commit de la transaccion

        if ($accessControl) {
          return response()->json([
            'type' => 'success',
            'message' => 'regitro éxitoso',
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
