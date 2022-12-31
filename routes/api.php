<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OwnerController;

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

Route::get('/', function() {
    return response()->json([
        'message' => 'server is working properly!',
        'timestamp' => date('d-m-Y h:i:s a', time())
    ], 200); 
});

Route::prefix('/users')->group(function () {
    Route::post('/', [UserController::class, 'create']);
    Route::post('/login', [UserController::class, 'login']);
});

Route::prefix('/owners')->group(function () {
    Route::post('/', [OwnerController::class, 'create']);
    Route::post('/login', [OwnerController::class, 'login']);
});

Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::group(['middleware' => ['type.owner'], 'prefix' => 'owners'], function() {
        Route::get('/', [OwnerController::class, 'index']);

        Route::prefix('/kosts')->group(function () {
            Route::post('/', [KostController::class, 'create']);
            Route::patch('/{id}', [KostController::class, 'update']);
            Route::delete('/{id}', [KostController::class, 'destroy']);
        });
    });

    Route::group(['middleware' => ['type.user'], 'prefix' => 'users'], function() {
        Route::get('/', [UserController::class, 'index']);
    });
});
