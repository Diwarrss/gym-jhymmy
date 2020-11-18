<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestPayment;
use App\Models\CanceledPayment;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Payment::with('userAdm', 'userCli')->where('state', '1')->get();

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
        $data['creator_user_id'] = Auth::user()->id;
        // $data['state'] = 1;
        $payment = Payment::create($data);
        DB::commit(); //commit de la transaccion

        if ($payment) {
          return response()->json([
            'type' => 'success',
            'message' => 'Creado con éxito',
            'data' => $payment
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      try {
        DB::beginTransaction();

        //$data request->all
        $payment = Payment::find($id);

        //validacion
       /*  $request->validate([
          'name' => 'required|max:200|unique:accessControl$tracings,name,' . $id,
          'initials' => 'required|max:5|unique:tracing$tracings,initials,' . $id
        ]); */

      $payment->value = $request->value;
      $payment->from_date = $request->from_date;
      $payment->state = $request->state;
      $payment->save();

      DB::commit(); //commit de la transaccion

      if ($payment) {
        return response()->json([
          'type' => 'success',
          'message' => 'Actualización con exito',
          'data' => $payment
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
        $payment = Payment::find($id);

        /* $payment->state = !$payment->state; */
        if ($payment->state) {
          $payment->state = false;
        } else {
          $payment->state = true;
        }
        $payment->save();

        DB::commit(); //commit de la transaccion

        if ($payment) {
          return response()->json([
            'type' => 'success',
            'message' => 'Actualización con éxito',
            'data' => $payment->state
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
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function cancelPayment(Request $request, $id)
    {
      //anular radicado, no elimina solo cambia el estado
      try {
        DB::beginTransaction();

        $payment = Payment::find($id); //Busca registro por ID

        //Add data in cancels_payments
        $cancelPayment = CanceledPayment::create([
          'description' => $request->description,
          'cancellation_reason_id' => $request->cancellation_reason_id,
          'payment_id' => $request->payment_id,
          'user_id' => Auth::user()->id
        ]);

        $payment->state = !$payment->state; //cambia el estado del radicado
        $payment->save(); //guarda el estado

        DB::commit(); //commit de la transaccion

        if ($payment) { //respuesta exitosa
          return response()->json([
            'type' => 'success',
            'message' => 'Anulado con éxito',
            'data' => $payment->state
          ], 202);
        }else{ //respuesta de error
          return response()->json([
            'type' => 'error',
            'message' => 'Error al anular',
            'data' => []
          ], 204);
        }
      } catch (Exception $e) { //error en el proceso
        return response()->json([
          'type' => 'error',
          'message' => 'Error al anular',
          'data' => []
        ], 204);
        DB::rollBack(); //si hay error no ejecute la transaccion
      }
    }
}
