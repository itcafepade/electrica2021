<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\HorarioController;
use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioValido
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $valid = HorarioController::verifyStatus();

        if ($valid) {
            return $next($request);
        }

        return redirect('/horarioNoValido');
    }
}
