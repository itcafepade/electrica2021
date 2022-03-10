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
        // dd($fullRoute);
        exec("$fullRoute/client.py $comando $valor", $resultado);
        // dd($resultado);
        try {
            $resultados = [
                "mensaje"=>"exito",
                "primerValor"=>$request->primerValor,
                "segundoValor"=>$request->segundoValor,
                "resultado"=>$resultado[1],
            ];

            if ($comando == 50 || $comando == 51 || $comando == 52 || $comando == 53) {
                $actual = HorarioController::practicaActual();

                $this->registrarHistorial($comando, $valor, $actual);
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

            $this->registrarHistorial(22, $resultadoTemperatura[1], $actual);

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

            $actual = HorarioController::practicaActual();

            $this->registrarHistorial(50, $resultadoSetPoint[1], $actual);
            $this->registrarHistorial(51, $resultadoProporcional[1], $actual);
            $this->registrarHistorial(52, 0.01, $actual);
            $this->registrarHistorial(53, 0.00, $actual);
        } catch (\Throwable $th) {
            $resultados['mensaje']="Servidor desconectado";
        }

        return response()->json($resultados);
    }

    public function registrarHistorial($comando, $valor, $actual)
    {
        $historial = [
            'id_horario' => $actual->id,
            'fecha' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        switch ($comando) {
            case 22:
                $historial['temperature'] = $valor;
                break;
            case 50:
                $historial['setpoint'] = $valor;
                break;
            case 51:
                $historial['proportional'] = $valor;
                break;
            case 52:
                $historial['integral'] = $valor;
                break;
            case 53:
                $historial['derivative'] = $valor;
                break;
            default:
            break;
        }

        Historial::insert($historial);
    }
}
