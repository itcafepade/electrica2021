<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

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
        try {
            User::create([
                'email' => 'admin@gmail.com',
                'password' => 'adminItca',
                'name' => 'admin',
                'access' => 'admin'
            ]);

            $this->info('Usuario administrador creado satisfactoriamente.');
        } catch (\Throwable $th) {
            $this->error('Error: El usuario administrador ya fue creado.');
        }
    }
}
