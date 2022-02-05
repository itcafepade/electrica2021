<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\EventoController;

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


Route::group(['middleware'=>['auth','admin']], function () {
    //Vistas
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/acciones', function () {
        return view('acciones');
    });
    Route::get('/horarios', function () {
        return view('horarios');
    });
    Route::get('/usuarios', function () {
        return view('usuarios');
    });
    Route::get('/simulador', function () {
        return view('simulador');
    });
    Route::get('/ajustes', function () {
        return view('ajustes');
    });
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Usuario
    Route::post('/registrarUsuarios', [UserController::class, 'store']);
    Route::get('/usuarioActual', [UserController::class, 'usuarioActual']);
    Route::post('api/obtenerPorCarnet', [UserController::class, 'obtenerUsuarioPorCarnet']);

    //Horarios
    Route::resource('api/horario', HorarioController::class);
    Route::post('api/practicaPorIdUsuario', [HorarioController::class, 'obtenerPracticasPorIdUsuario']);
    Route::post('api/horario/verificarPracticasPorDia', [HorarioController::class, 'verificarPracticasPorDia']);
    Route::post('api/horario/modificarEstado', [HorarioController::class, 'modificarEstadoEvento']);

    //Historial
    Route::resource('api/historial', HistorialController::class);
});

Route::get('generarCsv/{id}', [HistorialController::class, 'generateCSV']);
Route::post('api/historialPorIdUsuario', [HistorialController::class, 'obtenerAccionesPorIdUsuario']);
Route::group(['middleware'=>'auth'], function () {
    //Vistas
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/horarios', function () {
        return view('horarios');
    });

    Route::get('/horarioNoValido', function () {
        return view('horarioInvalido');
    });

    Route::get('/simulador', function () {
        return view('simulador');
    })->middleware('horarioValido');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    //Usuario
    Route::post('/registrarUsuarios', [UserController::class, 'store']);
    Route::get('/usuarioActual', [UserController::class, 'usuarioActual']);
    Route::post('api/obtenerPorCarnet', [UserController::class, 'obtenerUsuarioPorCarnet']);

    //Horarios
    Route::resource('api/horario', HorarioController::class);
    Route::post('api/practicaPorIdUsuario', [HorarioController::class, 'obtenerPracticasPorIdUsuario']);
    Route::post('api/horario/verificarPracticasPorDia', [HorarioController::class, 'verificarPracticasPorDia']);

    // Eventos
    Route::post('api/enviarEvento', [EventoController::class, 'enviarEvento']);
    Route::get('api/realizarConsultas', [EventoController::class, 'realizarConsultas']);
    Route::post('api/asignarEstadoInicial', [EventoController::class, 'asignarEstadoInicial']);
});

Route::get('api/verificarStatus', [HorarioController::class, 'verifyStatusApi']);
Auth::routes(['register' =>false]);
