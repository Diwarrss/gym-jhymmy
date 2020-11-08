<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestGender;
use App\Models\Gender;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Catch_;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if ($request->active == 1) {
        return Gender::where('state', true)->get();
      }
      return Gender::all();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestGender $request)
    {
      try {
        DB::beginTransaction();
        $data = $request->all();
        $gender = Gender::create($data);
        DB::commit();

        if ($gender) {
          return response()->json([
            'type' => 'success',
            'message' => 'Creado con éxito',
            'data' => $gender
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
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function show(Gender $gender)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      try {
        DB::beginTransaction();

        $gender = Gender::find($id);

        //validacion
        $request->validate([
          'name' => 'required|max:200|unique:genders,name,' . $id,
          'initials' => 'required|max:5|unique:genders,initials,' . $id
        ]);
        // table,column,except,idColumn


        $gender->name = $request->name;
        $gender->initials = $request->initials;
        $gender->state = $request->state;
        $gender->save();

        DB::commit(); //commit de la transaccion

        if ($gender) {
          return response()->json([
            'type' => 'success',
            'message' => 'Actualización con exito',
            'data' => $gender
          ], 202);
        }else{
          return response()->json([
            'type' => 'error',
            'message' => 'Error al actualizar',
            'data' =>[]
          ], 204);
        }

      } catch (Exception $e){
        return $e;
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
        $gender = Gender::find($id);

        $gender->state = !$gender->state;
        $gender->save();

        DB::commit(); //commit de la transaccion

        if ($gender) {
          return response()->json([
            'type' => 'success',
            'message' => 'Actualización con éxito',
            'data' => $gender->state
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
     * @param  \App\Models\Gender  $gender
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gender $gender)
    {
        //
    }
}
