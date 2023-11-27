<?php

use App\Http\Controllers\HistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;




Route::group(['as' => 'auth.', 'controller' => AuthController::class], function () {
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->name('logout');
});

Route::group(['as' => 'medical.', 'middleware' => ['auth', 'checkactive']], function () {
    Route::middleware(['password_expired'])->group(function () {
        Route::group(['prefix' => '/history', 'as' => 'history.', 'controller' => HistoryController::class], function () {
            Route::get('/histories-professional', 'HistoriesProfessional')->name('histories-professional')->middleware('permission:medical.history:read professional');
            Route::get('/histories-patient', 'HistoriesPatient')->name('histories-patient')->middleware('permission:medical.history:read patient');
            Route::post('/save', 'store')->name('save-history')->middleware('permission:medical.history:create');
            Route::put('/update/{courseCategory}', 'update')->name('update-history')->middleware('permission:medical.history:update');
        });

        Route::group(['prefix' => '/user', 'as' => 'user.', 'controller' => UserController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:medical.user:read');
            Route::post('/save', 'store')->name('save-user')->middleware('permission:medical.user:create');
            Route::get('/edit-profile', 'editProfile')->name('edit-profile')->middleware('permission:medical.user:read profile');
            Route::post('/update-profile', 'updateProfile')->name('update-profile')->middleware('permission:medical.user:update');
        });
    });
});
