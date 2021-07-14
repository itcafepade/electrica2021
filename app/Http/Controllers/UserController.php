<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    /**
     * Almacena los datos de los usuarios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuarios = $request->usuarios;

        foreach ($usuarios as $usuario) {
            User::create([
                'email' => $usuario['correo'],
                'password' => Hash::make('adminItca'),
                'name' => $usuario['nombres'].' '.$usuario['apellidos'],
                'access' => 'estudiante',
                'carrera' => $usuario['carrera'],
                'carnet' => $usuario['carnet'],
            ]);
        }

        return response()->json(['mensaje'=>'exito']);
    }

    /**
     * Retorna el usuario que actualmente ha iniciado sesión.
     *
     * @return \Illuminate\Http\Response
     */
    public function usuarioActual()
    {
        return auth()->user();
    }

    /**
     * Obtiene la información del usuario filtrando por el carnet.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function obtenerUsuarioPorCarnet(Request $request)
    {
        $usuario = User::where(['carnet'=>$request->carnet])->get();

        return response()->json(['mensaje'=>'exito', 'usuario'=>$usuario]);
    }
}
