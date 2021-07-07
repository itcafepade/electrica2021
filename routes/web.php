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
    Route::post('/registrarUsuarios', [App\Http\Controllers\UserController::class, 'store']);
});

Auth::routes(['register' =>false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
