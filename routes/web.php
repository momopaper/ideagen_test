<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
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

Route::middleware([
    // 'auth:sanctum',
    // config('jetstream.auth_session'),
    // 'verified',
    'auth',
    'auth.session'
])->group(function () {
    Route::name('timesheet.')->group(function () {
        Route::get('/timesheet', [TimesheetController::class, 'index'])->name('index');
        Route::get('/timesheet/create', [TimesheetController::class, 'create'])->name('create');
        Route::post('/timesheet/store', [TimesheetController::class, 'store'])->name('store');
        Route::get('/timesheet/{timesheet}', [TimesheetController::class, 'edit'])->name('edit');
        Route::post('/timesheet/{timesheet}/update', [TimesheetController::class, 'update'])->name('update');
        Route::post('/timesheet/{timesheet}/remove', [TimesheetController::class, 'destroy'])->name('destroy');
        Route::post('/timesheet/{timesheet}/approve', [TimesheetController::class, 'approve'])->name('approve');
    });

    Route::name('user.')->group(function () {
        Route::get('/user', [UserController::class, 'index'])->name('index');
        Route::get('/user/create', [UserController::class, 'create'])->name('create');
        Route::post('/user/store', [UserController::class, 'store'])->name('store');
        Route::get('/user/{user}', [UserController::class, 'edit'])->name('edit');
        Route::post('/user/{user}/update', [UserController::class, 'update'])->name('update');
        Route::post('/user/{user}/remove', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('logoutFromOtherBrowser', [LoginController::class, 'logoutFromOtherBrowser'])->name('logout_other_browser');
});

/**
 * Custom livewire update route
 */
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(env('LIVEWIRE_UPDATE_PATH'), $handle);
});

/**
 * Custom livewire.js route
 */
Livewire::setScriptRoute(function ($handle) {
    return Route::get(env('LIVEWIRE_JAVASCRIPT_PATH'), $handle);
});
