<?php

use App\Http\Controllers\Api\TimesheetController as ApiTimesheetController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Route::get('/', function () {
    if (Auth()->user()) {
        return redirect()->route('timesheet.index');
    } else {
        return redirect()->route('login');
    }
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    //'auth',
    // 'auth.session'
])->group(function () {
    Route::name('timesheet.')->group(function () {
        Route::get('/timesheet', [TimesheetController::class, 'index'])->name('index');
        Route::get('/timesheet/create', [TimesheetController::class, 'create'])->name('create');
        Route::get('/timesheet/{timesheet}', [TimesheetController::class, 'edit'])->name('edit');
        Route::post('/timesheet/store', [ApiTimesheetController::class, 'store'])->name('store');
        Route::post('/timesheet/{timesheet}/update', [ApiTimesheetController::class, 'update'])->name('update');
        Route::post('/timesheet/{timesheet}/remove', [ApiTimesheetController::class, 'destroy'])->name('destroy');
        Route::post('/timesheet/{timesheet}/approve', [ApiTimesheetController::class, 'approve'])->name('approve');
    });

    //session token api call
    Route::name('timesheet.')->group(function () {
    });

    Route::middleware(['admin.access'])->group(function () {
        Route::name('user.')->group(function () {
            Route::get('/user', [UserController::class, 'index'])->name('index');
            Route::get('/user/create', [UserController::class, 'create'])->name('create');
            Route::get('/user/{user}', [UserController::class, 'edit'])->name('edit');
            Route::post('/user/store', [ApiUserController::class, 'store'])->name('store');
            Route::post('/user/{user}/update', [ApiUserController::class, 'update'])->name('update');
            Route::post('/user/{user}/remove', [ApiUserController::class, 'destroy'])->name('destroy');
        });

        //session token api call
        Route::name('user.')->group(function () {
        });
    });

    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

/**
 * Custom livewire update route
 */
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('livewire.livewire_update_url'), $handle);
});

/**
 * Custom livewire.js route
 */
Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('livewire.livewire_javascript_url'), $handle);
});
