<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\User;
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
            ->whereDate('horarios.fecha_inicio', date('Y-m-d', strtotime($request->fecha_inicio)))
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
        $carnet = explode(' - ', $request->nombre)[0];

        $user = User::where(['carnet' => $carnet])->first();

        DB::table('horarios')->where('id', $request->id)
        ->update([
            'id' => $request->id,
            'nombre' => $request->nombre,
            'id_usuario' => $user->id,
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
        ->orderBy('horarios.id', 'DESC')
        ->get();
        return response()->json(['mensaje'=>'exito', 'practicas'=>$practicas]);
    }

    /**
     * Verifica el número de prácticas agendadas para un día específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function verificarPracticasPorDia(Request $request)
    {
        $carnet = $request->carnet;
        $fecha = $request->fecha;

        $numeroDePracticas = DB::table('horarios')->select('horarios.*', 'users.carnet as carnet')
        ->join('users', 'users.id', '=', 'horarios.id_usuario')
        ->where('users.carnet', $carnet)
        ->whereDate('horarios.fecha_inicio', $fecha)
        ->count();

        return response()->json(['mensaje'=>'exito', 'numeroPracticas'=>$numeroDePracticas]);
    }

    /**
     * Modifica el estado de la práctica asignandole el estado correspondiente y un color
     * representativo con el estado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function modificarEstadoEvento(Request $request)
    {
        $estado = $request->estado;
        $id = $request->id;
        $color = $request->color;

        $modificado = Horario::where('id', $id)->update(['estado'=>$estado, 'color'=>$color]);

        return response()->json(['mensaje'=>'exito']);
    }

    /**
     * Verifica que la practica actual esté disponible
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Boolean
     */
    public static function verifyStatus()
    {
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');

        $horarios = Horario::join('users', 'horarios.id_usuario', '=', 'users.id')
        ->whereRaw(
            "(horarios.fecha_inicio >= ? AND horarios.fecha_final <= ?)",
            [$start, $end]
        )
        ->where('users.id', auth()->user()->id)
        ->get();

        $valid = false;
        foreach ($horarios as $horario) {
            $dateStart = date('Y-m-d H:i:s', strtotime($horario->fecha_inicio));
            $dateEnd = date('Y-m-d H:i:s', strtotime($horario->fecha_final));
            $dateNow = date('Y-m-d H:i:s');

            if ($dateNow >= $dateStart && $dateNow <= $dateEnd) {
                $valid = true;
                break;
            } else {
                $valid = false;
            }
        }

        return $valid;
    }

    /**
     * Verifica que la practica actual esté disponible
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Boolean
     */
    public static function verifyStatusApi()
    {
        $valid = HorarioController::verifyStatus();

        $status = ($valid === true) ? 'OK' : '';

        return response()->json(['mensaje'=>'exito', 'status'=>$status]);
    }

    /**
     * Verifica que la practica actual esté disponible
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Boolean
     */
    public static function practicaActual()
    {
        $actual = [];
        $start = date('Y-m-d 00:00:00');
        $end = date('Y-m-d 23:59:59');

        $horarios = Horario::select('*', 'horarios.id as id')
        ->join('users', 'horarios.id_usuario', '=', 'users.id')
        ->whereRaw(
            "(horarios.fecha_inicio >= ? AND horarios.fecha_final <= ?)",
            [$start, $end]
        )
        ->where('users.id', auth()->user()->id)
        ->get();

        foreach ($horarios as $horario) {
            $dateStart = date('Y-m-d H:i:s', strtotime($horario->fecha_inicio));
            $dateEnd = date('Y-m-d H:i:s', strtotime($horario->fecha_final));
            $dateNow = date('Y-m-d H:i:s');

            if ($dateNow >= $dateStart && $dateNow <= $dateEnd) {
                $actual = $horario;
                break;
            }
        }

        return $actual;
    }
}
