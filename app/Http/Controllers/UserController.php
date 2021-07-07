<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class UserController extends Controller
{
    /**
     * Almacena los datos de los usuarios
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
}
