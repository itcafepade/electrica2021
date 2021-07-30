<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Hash;

class crearAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:crearAdmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para crear el primer usuario como administrador.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::create([
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('adminItca'),
            'name' => 'admin 2',
            'access' => 'admin 2',
            'carrera' => 'Ing. Eléctrica',
            'carnet' => '020202',
        ]);

        $this->info('Usuario administrador creado satisfactoriamente.');
    }
}
