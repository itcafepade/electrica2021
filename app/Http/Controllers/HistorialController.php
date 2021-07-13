<?php

namespace App\Http\Controllers;

use App\Models\Historial;
use Illuminate\Http\Request;
use DB;

class HistorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $historial = DB::table('historial')
        ->select('historial.*', 'horarios.*', 'users.carnet as carnet')
        ->join('horarios', 'horarios.id', '=', 'historial.id_usuario')
        ->join('users', 'users.id', '=', 'horarios.id_usuario')
        ->get();
        return response()->json(['mensaje'=>'exito', 'eventos'=>$historial]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function show(Historial $historial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Historial $historial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Historial  $historial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Historial $historial)
    {
        //
    }

    /**
     * Obtiene los eventos registrados durante una práctica filtrando
     * por el ID del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function obtenerAccionesPorIdUsuario(Request $request)
    {
        $historial = DB::table('historial')
        ->where('id_horario', $request->id)
        ->get();

        return response()->json(['mensaje'=>'exito', 'historial'=>$historial]);
    }
}
