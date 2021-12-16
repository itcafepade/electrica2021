<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function enviarEvento(Request $request)
    {
        exec('python C:\Users\Leonel\Desktop\client.py '.$request->primerValor, $resultado);

        if ($request->segundoValor != -1) {
            sleep(1);

            exec('python C:\Users\Leonel\Desktop\client.py '.$request->segundoValor, $resultado);
        }
        dd($resultado);
    }
}
