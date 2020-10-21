<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
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
      return Payment::all();
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
        $payment = Payment::create($data);
        DB::commit(); //commit de la transaccion

        if ($payment) {
          return response()->json([
            'type' => 'success',
            'message' => 'Pago Realizado',
            'data' => $payment
          ], 201);
        }else{
          return response()->json([
            'type' => 'error',
            'message' => 'Error al Pagar',
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
    public function update(Request $request, Payment $payment)
    {
        //
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
}
