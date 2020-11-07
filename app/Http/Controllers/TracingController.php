<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
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
    public function update(Request $request, Tracing $tracing, $id)
    {
      try {
        DB::beginTransaction();

        //$data request->all
        $tracing = Tracing::find($id);

        //validacion
        $request->validate([
          'name' => 'required|max:200|unique:tracing$tracings,name,' . $id,
          'initials' => 'required|max:5|unique:tracing$tracings,initials,' . $id
        ]);

      $tracing->name = $request->name;
      $tracing->initials = $request->initials;
      $tracing->state = $request->state;
      $tracing->save();

      DB::commit(); //commit de la transaccion

      if ($tracing) {
        return response()->json([
          'type' => 'success',
          'message' => 'Actualización con exito',
          'data' => $tracing
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
        $tracing = Tracing::find($id);

        $tracing->state = !$tracing->state;
        $tracing->save();

        DB::commit(); //commit de la transaccion

        if ($tracing) {
          return response()->json([
            'type' => 'success',
            'message' => 'Actualización con éxito',
            'data' => $tracing->state
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
     * @param  \App\Models\Tracing  $tracing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tracing $tracing)
    {
        //
    }
}
