<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AuthController;





// Auth::routes();
Route::get('/', [PageController::class, 'initial'])->name('index');

Route::group(['as' => 'auth.', 'controller' => AuthController::class], function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['as' => 'medical.', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => '/history', 'as' => 'history.', 'controller' => HistoryController::class], function () {
        Route::get('/histories-professional', 'HistoriesProfessional')->name('histories-professional');
        Route::get('/histories-professional-show', 'HistoriesProfessionalShow')->name('histories-professional-show');
        Route::get('/histories-patient', 'HistoriesPatient')->name('histories-patient');
        Route::get('/histories-patient-show', 'HistoriesPatientShow')->name('histories-patient-show');
        Route::post('/save', 'store')->name('save-history');
        Route::put('/update/{history}', 'update')->name('update-history');
    });

    Route::group(['prefix' => '/user', 'as' => 'user.', 'controller' => UserController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{user}', 'user')->name('user');
        Route::post('/save', 'store')->name('save-user');
        Route::get('/edit-profile', 'editProfile')->name('edit-profile');
        // Route::post('/update-profile', 'updateProfile')->name('update-profile');
    });
});
