<?php

use App\Http\Controllers\HistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::group(['prefix' => 'users', 'controller' => UserController::class], function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::put('/{user}', 'updateProfile');
});

Route::group(['prefix' => 'histories', 'controller' => HistoryController::class], function () {
    Route::post('/', 'store');
    Route::put('/{history}', 'update');
});
