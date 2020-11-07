<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestTracing;
use App\Models\Tracing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TracingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return Tracing::with('user')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestTracing $request)
    {
      try {
        DB::beginTransaction();
        $data = $request->all();
        $tracing = Tracing::create($data);
        DB::commit();

        if ($tracing) {
          return response()->json([
            'type' => 'success',
            'message' => 'Creado con éxito',
            'data' => $tracing
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
     * @param  \App\Models\Tracing  $tracing
     * @return \Illuminate\Http\Response
     */
    public function show(Tracing $tracing)
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
    public function update(Request $request, Tracing $tracing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tracing  $tracing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tracing $tracing)
    {
        //
    }
}
