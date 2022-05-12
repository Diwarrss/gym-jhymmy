<?php

namespace App\Http\Controllers;

use App\Models\CanceledPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CanceledPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return CanceledPayment::all();
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
        $canceledPayment = CanceledPayment::created($data);
        DB::commit();

        if ($canceledPayment) {
          return response()->json([
            'type' => 'success',
            'message' => 'Cancelado',
            'data' => $canceledPayment
          ], 202);
        }else{
          return response()->json([
            'type' => 'error',
            'message' => 'Error al Cancelar',
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CanceledPayment  $canceledPayment
     * @return \Illuminate\Http\Response
     */
    public function show(CanceledPayment $canceledPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CanceledPayment  $canceledPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      try {
        DB::beginTransaction();

        //$data request->all
        $canceledPayment = CanceledPayment::find($id);

        //validacion
       /*  $request->validate([
          'name' => 'required|max:200|unique:cancellation_payment,name,' . $id
        ]); */

      $canceledPayment->name = $request->name;
      $canceledPayment->state = $request->state;
      $canceledPayment->save();

      DB::commit(); //commit de la transaccion

      if ($canceledPayment) {
        return response()->json([
          'type' => 'success',
          'message' => 'Cancelación con éxito',
          'data' => $canceledPayment
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
        $canceledPayment = CanceledPayment::find($id);

        $canceledPayment->state = !$canceledPayment->state;
        $canceledPayment->save();

        DB::commit(); //commit de la transaccion

        if ($canceledPayment) {
          return response()->json([
            'type' => 'success',
            'message' => 'Cancelación con éxito',
            'data' => $canceledPayment->state
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
            'message' => 'Error al actualizar',
            'data' =>[]
          ], 204);
          DB::rollBack(); //si hay un error no se ejecuta la transaccion
        }
      }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CanceledPayment  $canceledPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CanceledPayment $canceledPayment)
    {
        //
    }
}
