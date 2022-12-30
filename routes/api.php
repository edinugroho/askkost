<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::post('/users', [UserController::class, 'create']);

Route::post('/owners', [OwnerController::class, 'create']);
Route::post('/owners/login', [OwnerController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
