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
            'nombre'=>'Práctica evaluada - 010101',
            'fecha_inicio'=>date('Y-m-d 13:00'),
            'fecha_final'=>date('Y-m-d 14:00'),
            'id_usuario'=>1,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        Historial::create([
            'id_horario'=>1,
            'fecha'=>date('Y-m-d 13:01'),
            'accion'=>'Inicio de práctica evaluada',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);

        Historial::create([
            'id_horario'=>1,
            'fecha'=>date('Y-m-d 13:02'),
            'accion'=>'Cambio de variables',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);
    }
}
