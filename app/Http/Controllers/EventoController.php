<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function enviarEvento(Request $request)
    {
        $fullRoute= "C:\Users\Leonel\Desktop\socketPython";
        $env = "production"; //env o production
        $comando = $request->primerValor;
        $valor = $request->segundoValor;

        /**
         * Se envían 3 parámetros:
         * Comando - es el número del comando que se desea que se ejecute en el controlador
         * Valor - es el número que se utilizará para actualizar el valor del controlador,
         *         en el caso de no existir, el valor por defecto será de -1
         * Entorno - Este valor puede tener dos valores, 'dev' o 'production'
         * -- dev - este se utiliza para un entorno de pruebas en el que no se cuenta con el controlador
         *           asignando valores por defecto a las peticiones
         * -- production - Este se utiliza cuando se posee el controlador; ya que, en este caso se conectará
         *                 al socket para obtener el valor del controlador
         *
         */
        exec("python $fullRoute/client.py $comando $valor $env", $resultado);
        // dd($resultado);
        try {
            $resultados = [
                "mensaje"=>"exito",
                "primerValor"=>$request->primerValor,
                "segundoValor"=>$request->segundoValor,
            ];

            $resultados['resultado']=$resultado[1];
        } catch (\Throwable $th) {
            $resultados['mensaje']="Servidor desconectado";
        }

        return response()->json($resultados);
    }
}
