<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventosAutorizados = Horario::select('horarios.*', 'users.carnet as carnet')
        ->join('users', 'users.id', '=', 'horarios.id_usuario')
        ->get();

        $eventosNoAutorizados = DB::table('horarios')
        ->select('horarios.*', 'users.carnet', 'users.name')
        ->join('users', 'users.id', '=', 'horarios.id_usuario')
        ->where('horarios.estado', 'Pendiente')
        ->get();

        return response()->json([
            'mensaje'=>'exito',
            'eventos'=>$eventosAutorizados,
            'eventosNoAutorizados'=>$eventosNoAutorizados
        ]);
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

        if (auth()->user()->access == 'admin') {
            $evento->estado = "Autorizada";
            $evento->color = "green";
            $evento->save();
            return response()->json(['mensaje'=>'exito']);
        }

        if (auth()->user()->access == 'estudiante') {
            $numeroDePracticas = DB::table('horarios')->select('horarios.*', 'users.carnet as carnet')
            ->join('users', 'users.id', '=', 'horarios.id_usuario')
            ->where('users.carnet', auth()->user()->carnet)
            ->whereDate('horarios.created_at', date('Y-m-d', strtotime($request->fecha_inicio)))
            ->count();

            if ($numeroDePracticas >= 1) {
                $evento->estado = "Pendiente";
                $evento->color = "orange";
            } else {
                $evento->estado = "Autorizada";
                $evento->color = "green";
            }

            $evento->save();
            return response()->json(['mensaje'=>'exito']);
        }
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
        Horario::where(['id'=>$horario->id])->delete();

        return response()->json(['mensaje'=>'exito']);
    }

    /**
     * Obtiene las prácticas registradas filtradas por el ID del usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function obtenerPracticasPorIdUsuario(Request $request)
    {
        $practicas = DB::table('horarios')
        ->select('horarios.*', 'users.carnet as carnet')
        ->join('users', 'users.id', '=', 'horarios.id_usuario')
        ->where(['users.id'=> $request->id, 'horarios.estado'=>'Autorizada'])
        ->get();
        return response()->json(['mensaje'=>'exito', 'practicas'=>$practicas]);
    }

    public function verificarPracticasPorDia(Request $request)
    {
        $carnet = $request->carnet;
        $fecha = $request->fecha;

        $numeroDePracticas = DB::table('horarios')->select('horarios.*', 'users.carnet as carnet')
        ->join('users', 'users.id', '=', 'horarios.id_usuario')
        ->where('users.carnet', $carnet)
        ->whereDate('horarios.created_at', $fecha)
        ->count();

        return response()->json(['mensaje'=>'exito', 'numeroPracticas'=>$numeroDePracticas]);
    }

    public function modificarEstadoEvento(Request $request)
    {
        $estado = $request->estado;
        $id = $request->id;
        $color = $request->color;

        $modificado = Horario::where('id', $id)->update(['estado'=>$estado, 'color'=>$color]);

        return response()->json(['mensaje'=>'exito']);
    }
}
