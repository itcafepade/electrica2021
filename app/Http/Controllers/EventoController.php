<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial;

class EventoController extends Controller
{
    public function enviarEvento(Request $request)
    {
        $fullRoute= env("PYTHON_CLIENT_URL");
        $comando = $request->primerValor;
        $valor = $request->segundoValor;

        /**
         * Se envían 2 parámetros:
         * Comando - es el número del comando que se desea que se ejecute en el controlador
         * Valor - es el número que se utilizará para actualizar el valor del controlador,
         *         en el caso de no existir, el valor por defecto será de -1
         */

        exec("$fullRoute/client.py $comando $valor", $resultado);

        try {
            $resultados = [
                "mensaje"=>"exito",
                "primerValor"=>$request->primerValor,
                "segundoValor"=>$request->segundoValor,
                "resultado"=>$resultado[1],
            ];

            if ($comando != 100) {
                $actual = HorarioController::practicaActual();

                Historial::insert([
                    'id_horario' => $actual->id,
                    'fecha' => now(),
                    'accion' => "Comando: $comando, Valor: $valor, Resultado: $resultado[1]",
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Throwable $th) {
            $resultados['mensaje']="Servidor desconectado";
        }

        return response()->json($resultados);
    }


    public function realizarConsultas(Request $request)
    {
        $fullRoute= env("PYTHON_CLIENT_URL");

        /**
         * Se envían 2 parámetros:
         * Comando - es el número del comando que se desea que se ejecute en el controlador
         * Valor - es el número que se utilizará para actualizar el valor del controlador,
         *         en el caso de no existir, el valor por defecto será de -1
         */

        exec("$fullRoute/client.py 21 -1", $resultadoPID);
        // usleep(250000); //Sleeping for 0.25 s

        exec("$fullRoute/client.py 22 -1", $resultadoTemperatura);
        // usleep(250000); //Sleeping for 0.25 s

        exec("$fullRoute/client.py 23 -1", $resultadoSetPoint);
        // usleep(250000); //Sleeping for 0.25 s

        try {
            $resultados = [
                "mensaje"=>"exito",
                "setPoint"=>$resultadoSetPoint[1],
                "temperatura"=>$resultadoTemperatura[1],
                "datoPID"=>$resultadoPID[1],
            ];

            $actual = HorarioController::practicaActual();

            Historial::insert([
                'id_horario' => $actual->id,
                'fecha' => now(),
                'accion' => "Temperatura: $resultadoTemperatura[1]",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $th) {
            $resultados['mensaje']="Servidor desconectado";
        }

        return response()->json($resultados);
    }

    public function asignarEstadoInicial(Request $request)
    {
        $fullRoute= env("PYTHON_CLIENT_URL");
        $proporcional = $request->proporcional;
        $setPoint = $request->setPoint;

        /**
         * Se envían 2 parámetros:
         * Comando - es el número del comando que se desea que se ejecute en el controlador
         * Valor - es el número que se utilizará para actualizar el valor del controlador,
         *         en el caso de no existir, el valor por defecto será de -1
         */

        exec("$fullRoute/client.py 50 $setPoint", $resultadoSetPoint);

        exec("$fullRoute/client.py 51 $proporcional", $resultadoProporcional);

        try {
            $resultados = [
                "mensaje"=>"exito",
                "datoPID"=>$resultadoProporcional[1],
                "setPoint"=>$resultadoSetPoint[1],
            ];

            $actual = HorarioController::practicaActual();

            Historial::insert([
                'id_horario' => $actual->id,
                'fecha' => now(),
                'accion' => "Comando: $comando, Valor: $valor, Resultado: $resultado[1]",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $th) {
            $resultados['mensaje']="Servidor desconectado";
        }

        return response()->json($resultados);
    }
}
