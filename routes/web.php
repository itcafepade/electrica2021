<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'auth'], function () {
    //Vistas
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/acciones',['middleware'=>'admin', function () {
        return view('acciones');
    }]);
    Route::get('/horarios', function () {
        return view('horarios');
    });
    Route::get('/usuarios',['middleware'=>'admin', function () {
        return view('usuarios');
    }]);
    Route::get('/simulador', function () {
        return view('simulador');
    });
    Route::get('/ajustes',['middleware'=>'admin', function () {
        return view('ajustes');
    }]);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Usuario
    Route::post('/registrarUsuarios', [App\Http\Controllers\UserController::class, 'store']);
    Route::get('/usuarioActual', [App\Http\Controllers\UserController::class, 'usuarioActual']);
    Route::post('api/obtenerPorCarnet', [App\Http\Controllers\UserController::class, 'obtenerUsuarioPorCarnet']);

    //Horarios
    Route::resource('api/horario', App\Http\Controllers\HorarioController::class);
    Route::post('api/practicaPorIdUsuario', [App\Http\Controllers\HorarioController::class, 'obtenerPracticasPorIdUsuario']);

    //Historial
    Route::resource('api/historial', App\Http\Controllers\HistorialController::class);
    Route::post('api/historialPorIdUsuario', [App\Http\Controllers\HistorialController::class, 'obtenerAccionesPorIdUsuario']);
});



Auth::routes(['register' =>false]);
