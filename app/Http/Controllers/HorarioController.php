<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use DB;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventos = DB::table('horarios')
        ->select('horarios.*', 'users.carnet as carnet')
        ->join('users', 'users.id', '=', 'horarios.id_usuario')
        ->get();
        return response()->json(['mensaje'=>'exito', 'eventos'=>$eventos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $evento = new Horario();
        $evento->nombre = $request->nombre;
        $evento->id_usuario = $request->id_usuario;
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->fecha_final = $request->fecha_final;
        $evento->created_at = date("Y-m-dTH:m");
        $evento->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function show(Horario $horario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $evento = new Horario();
        $evento->id = $request->id;
        $evento->nombre = $request->nombre;
        $evento->id_usuario = $request->id_usuario;
        $evento->fecha_inicio = $request->fecha_inicio;
        $evento->fecha_final = $request->fecha_final;
        $evento->updated_at = date("Y-m-dTH:m");

        DB::table('horarios')->where('id', $request->id)
        ->update([
            'id' => $request->id,
            'nombre' => $request->nombre,
            'id_usuario' => $request->id_usuario,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_final' => $request->fecha_final,
            'updated_at' => date("Y-m-d H:m")
        ]);

        return response()->json(['mensaje'=>'exito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Horario  $horario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Horario $horario)
    {
        dd($horario->id);
    }
}
