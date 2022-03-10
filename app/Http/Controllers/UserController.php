<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return response()->json(['mensaje'=>'exito', 'users'=>$users]);
    }

    /**
     * Almacena los datos de los usuarios.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $usuarios = $request->usuarios;

            foreach ($usuarios as $usuario) {
                $user = User::firstOrNew([
                    'email' => $usuario['correo'],
                    'password' => Hash::make('Itca123!'),
                    'name' => $usuario['nombres'].' '.$usuario['apellidos'],
                    'access' => 'estudiante',
                    'carrera' => $usuario['carrera'],
                    'carnet' => $usuario['carnet']
                ]);

                if (!$user->exists) {
                    $user->save();
                }
            }

            return response()->json(['mensaje'=>'exito']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

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
