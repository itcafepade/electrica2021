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

        $historial = $this->gettingRowsWithoutEmptySpaces($historial);

        return response()->json(['mensaje'=>'exito', 'historial'=>$historial]);
    }

    public function generateCSV($id)
    {
        // dd($id);
        $historial = DB::table('historial')
        ->where('id_horario', $id)
        ->get();

        $historial = $this->gettingRowsWithoutEmptySpaces($historial);

        $fileName = 'data.csv';

        $headers = array(
                 "Content-type"        => "text/csv",
                 "Content-Disposition" => "attachment; filename=$fileName",
                 "Pragma"              => "no-cache",
                 "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                 "Expires"             => "0"
             );

        $columns = array('SetPoint', 'Proportional', 'Integral', 'Derivative', 'Temperature');

        $callback = function () use ($historial, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($historial as $fila) {
                $row['SetPoint']  = $fila->setpoint;
                $row['Proportional']    = $fila->proportional;
                $row['Integral']    = $fila->integral;
                $row['Derivative']  = $fila->derivative;
                $row['Temperature']  = $fila->temperature;

                fputcsv($file, array($row['SetPoint'], $row['Proportional'], $row['Integral'], $row['Derivative'], $row['Temperature']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Completa la tabla recorriendo el array del historial tanto de forma normal,
     * como de forma inversa.
     */
    public function gettingRowsWithoutEmptySpaces($historial)
    {
        // Obteniendo el primer valor que no está vacío en el array
        $setpoint = $this->getFirstRecord($historial, 'setpoint');
        $proportional = $this->getFirstRecord($historial, 'proportional');
        $integral = $this->getFirstRecord($historial, 'integral');
        $derivative = $this->getFirstRecord($historial, 'derivative');
        $temperature = $this->getFirstRecord($historial, 'temperature');

        //Se envía el primer valor obtenido y la variable a la que se le asignará
        $historial = $this->fillEmptyRecords($historial, 'setpoint', $setpoint);
        $historial = $this->fillEmptyRecords($historial, 'proportional', $proportional);
        $historial = $this->fillEmptyRecords($historial, 'integral', $integral);
        $historial = $this->fillEmptyRecords($historial, 'derivative', $derivative);
        $historial = $this->fillEmptyRecords($historial, 'temperature', $temperature);

        //Obteniendo el primer valor vacío para luego recorrerlo de forma inversa
        $setpoint = $this->getFirstRecord($historial, 'setpoint');
        $proportional = $this->getFirstRecord($historial, 'proportional');
        $integral = $this->getFirstRecord($historial, 'integral');
        $derivative = $this->getFirstRecord($historial, 'derivative');
        $temperature = $this->getFirstRecord($historial, 'temperature');

        //Asignando el primer valor vacío, pero ahora recorriendo de forma inversa
        $historial = $this->fillEmptyRecordsReverse($historial, 'setpoint', $setpoint);
        $historial = $this->fillEmptyRecordsReverse($historial, 'proportional', $proportional);
        $historial = $this->fillEmptyRecordsReverse($historial, 'integral', $integral);
        $historial = $this->fillEmptyRecordsReverse($historial, 'derivative', $derivative);
        $historial = $this->fillEmptyRecordsReverse($historial, 'temperature', $temperature);

        return $historial;
    }

    /**
     * Retorna el primer valor que sea distinto de vacío
     */
    public function getFirstRecord($historial, $property)
    {
        $value = 0;
        for ($i = 0; $i<count($historial); $i++) {
            if ($historial[$i]->{$property} != "") {
                $value = $historial[$i]->{$property};
                break;
            }
        }

        return $value;
    }

    /**
     * Rellenando los espacios vacíos recorriendo el array incrementandolo en 1
     */
    public function fillEmptyRecords($historial, $property, $value = "")
    {
        $value = "";
        for ($i = 0; $i<count($historial); $i++) {
            if ($historial[$i]->{$property} == "") {
                $historial[$i]->{$property} = $value;
            } else {
                $value = $historial[$i]->{$property};
            }
        }

        return $historial;
    }

    /**
     * Rellenando los espacios vacíos que quedan recorriendo el array de forma inversa,
     * el array está decreciendo en 1
     */
    public function fillEmptyRecordsReverse($historial, $property, $value = "")
    {
        $value = "";
        for ($i = count($historial)-1; $i>=0; $i--) {
            if ($historial[$i]->{$property} == "") {
                $historial[$i]->{$property} = $value;
            } else {
                $value = $historial[$i]->{$property};
            }
        }

        return $historial;
    }
}
