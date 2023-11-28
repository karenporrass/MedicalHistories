<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\AuthController;

Route::get('/', [PageController::class, 'initial'])->name('index');

Route::group(['as' => 'auth.', 'controller' => AuthController::class], function () {
    Route::post('/login', 'login')->name('login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::group(['as' => 'medical.', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => '/history', 'as' => 'history.', 'controller' => HistoryController::class], function () {
        Route::get('/histories-professional', 'HistoriesProfessional')->name('histories-professional')->middleware('can:history.professional');
        Route::get('/histories-professional-show', 'HistoriesProfessionalShow')->name('histories-professional-show')->middleware('can:history.professional.show');
        Route::get('/histories-patient', 'HistoriesPatient')->name('histories-patient')->middleware('can:history.patient');
        Route::get('/histories-patient-show', 'HistoriesPatientShow')->name('histories-patient-show')->middleware('can:history.patient.show');
        Route::post('/save', 'store')->name('save-history')->middleware('can:history.store');
        Route::put('/update/{history}', 'update')->name('update-history')->middleware('can:history.update');
    });

    Route::group(['prefix' => '/user', 'as' => 'user.', 'controller' => UserController::class], function () {
        Route::get('/{user}', 'user')->name('user')->middleware('can:user.get.professional');
        Route::post('/save', 'store')->name('save-user')->middleware('can:user.store');
        Route::post('/edit-profile', 'editProfile')->name('edit-profile')->middleware('can:user.get.update');
        Route::put('/update/{id}', 'updateProfile')->name('update')->middleware('can:user.update');
    });
});
