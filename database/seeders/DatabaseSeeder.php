<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Horario;
use App\Models\User;
use App\Models\Historial;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adminItca'),
            'name' => 'admin',
            'access' => 'admin',
            'carrera' => 'Ing. Eléctrica',
            'carnet' => '010101',
        ]);

        User::create([
            'email' => 'estudiante@gmail.com',
            'password' => Hash::make('adminItca'),
            'name' => 'estudiante',
            'access' => 'estudiante',
            'carrera' => 'Ing. Eléctrica',
            'carnet' => '030303',
        ]);

        Horario::create([
            'nombre'=>'030303 - Práctica evaluada',
            'fecha_inicio'=>date('Y-m-d 10:00'),
            'fecha_final'=>date('Y-m-d 11:00'),
            'id_usuario'=>2,
            'estado'=> 'Autorizada',
            'color'=> 'green',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        Horario::create([
            'nombre'=>'010101 - Práctica evaluada',
            'fecha_inicio'=>date('Y-m-d 08:00'),
            'fecha_final'=>date('Y-m-d 09:00'),
            'id_usuario'=>1,
            'estado'=> 'Rechazada',
            'color'=> 'red',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        Horario::create([
            'nombre'=>'010101 - Práctica evaluada',
            'fecha_inicio'=>date('Y-m-d 15:00'),
            'fecha_final'=>date('Y-m-d 16:00'),
            'id_usuario'=>1,
            'estado'=> 'Pendiente',
            'color'=> 'orange',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        Horario::create([
            'nombre'=>'010101 - Práctica evaluada',
            'fecha_inicio'=>date('Y-m-d 13:00'),
            'fecha_final'=>date('Y-m-d 14:00'),
            'id_usuario'=>1,
            'estado'=> 'Autorizada',
            'color'=> 'green',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        // Historial::create([
        //     'id_horario'=>1,
        //     'fecha'=>date('Y-m-d 22:01'),
        //     'accion'=>'Inicio de práctica evaluada',
        //     'created_at'=>date('Y-m-d H:i:s'),
        //     'updated_at'=>date('Y-m-d H:i:s'),
        // ]);

        // Historial::create([
        //     'id_horario'=>1,
        //     'fecha'=>date('Y-m-d 23:59'),
        //     'accion'=>'Cambio de variables',
        //     'created_at'=>date('Y-m-d H:i:s'),
        //     'updated_at'=>date('Y-m-d H:i:s'),
        // ]);
    }
}
