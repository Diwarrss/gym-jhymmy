<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return State::all();
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
        $state = State::created($data);
        DB::commit();

        if ($state) {
          return response()->json([
            'type' => 'success',
            'message' => 'Estado cambiado',
            'data' => $state
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
            'message' => 'Error al cambiar estado',
            'data' =>[]
          ], 204);
          DB::rollBack(); //si hay un error no se ejecuta la transaccion
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      try {
        DB::beginTransaction();

        //$data request->all
        $state = State::find($id);

        DB::commit(); //commit de la transaccion

        if ($state) {
        return response()->json([
          'type' => 'success',
          'message' => 'Actualización con exito',
          'data' => $state
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
        $state = State::find($id);

        $state->state = !$state->state;
        $state->save();

        DB::commit(); //commit de la transaccion

        if ($state) {
          return response()->json([
            'type' => 'success',
            'message' => 'Actualización con éxito',
            'data' => $state->state
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
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        //
    }
}
