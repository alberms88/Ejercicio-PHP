<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\Middleware\Authenticate;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('users')->group(function () {

    Route::post('/registro',[UserController::class, 'createUser']);

    Route::post('/login',[UserController::class, 'login']);

    Route::post('/resetPassword',[UserController::class, 'resetPassword']);

});

Route::prefix('cards')->group(function () {

    Route::post('/create',[CardController::class, 'CreateCard']);
    Route::get('/listcards/{cardname}',[CardController::class, 'listCard']);


});

Route::prefix('ventas')->group(function (){


    Route::get('/listaventas/{nombre_venta}',[VentaController::class,"listaventas"])->middleware('auth');
    Route::post('/createventa',[VentaController::class,"createventa"]);
    Route::get('/listacompra/{nombre_venta}',[VentaController::class,"listacompra"])->middleware('auth');

});