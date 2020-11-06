<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestCancellationReason;
use App\Models\CancellationReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CancellationReasonController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return CancellationReason::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestCancellationReason $request)
    {
      try {
        DB::beginTransaction();

        $data = $request->all();
        $cancellationReason = CancellationReason::create($data);
        DB::commit();

        if ($cancellationReason) {
          return response()->json([
            'type' => 'success',
            'message' => 'Creado con éxito',
            'data' => $cancellationReason
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

    public function show(CancellationReason $cancellationReason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CancellationReason  $cancellationReason
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      try {
        DB::beginTransaction();

        //$data request->all
        $cancellationReason = CancellationReason::find($id);

        //validacion
       /*  $request->validate([
          'name' => 'required|max:200|unique:cancellation_reasons,name,' . $id
        ]); */

      $cancellationReason->name = $request->name;
      $cancellationReason->state = $request->state;
      $cancellationReason->save();

      DB::commit(); //commit de la transaccion

      if ($cancellationReason) {
        return response()->json([
          'type' => 'success',
          'message' => 'Cancelación con exito',
          'data' => $cancellationReason
        ], 202);
      }else{
        return response()->json([
          'type' => 'error',
          'message' => 'Error al cancelar',
          'data' =>[]
        ], 204);
      }

      } catch (Exception $e){
        return response()->json([
          'type' => 'error',
          'message' => 'Error al cancelar',
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
        $cancellationReason = CancellationReason::find($id);

        $cancellationReason->state = !$cancellationReason->state;
        $cancellationReason->save();

        DB::commit(); //commit de la transaccion

        if ($cancellationReason) {
          return response()->json([
            'type' => 'success',
            'message' => 'Actualización con éxito',
            'data' => $cancellationReason->state
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
     * @param  \App\Models\CancellationReason  $cancellationReason
     * @return \Illuminate\Http\Response
     */
    public function destroy(CancellationReason $cancellationReason)
    {
        //
    }
}
