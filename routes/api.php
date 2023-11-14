<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TodoController;


Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [RegisterController::class, 'login']);

Route::middleware('auth:api')->group( function () {
Route::get('/list', [TodoController::class, 'index']); 
Route::post('/store', [TodoController::class, 'store']);
Route::get('/show/{id}', [TodoController::class, 'show']);
Route::get('/update/{todoApp}', [TodoController::class, 'update']);
Route::get('/delete/{todoApp}', [TodoController::class, 'destroy']); 
    
});

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
