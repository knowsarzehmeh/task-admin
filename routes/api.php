<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\Auth\LoginController;

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

Route::post('/register', [LoginController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);

Route::middleware('auth:api')->group(function() {

   Route::get('/user', function (Request $request) {
        return Auth::user();
    });

   Route::get('/task', [TasksController::class, 'index']); 
   Route::get('/task/{task}', [TasksController::class, 'show']); 
   Route::post('/task', [TasksController::class, 'store']); 
   Route::patch('/task/{task}', [TasksController::class, 'update']); 
   Route::delete('/task/{task}', [TasksController::class, 'destroy']); 

   Route::get('/logout', [LoginController::class, 'logout']);
});
