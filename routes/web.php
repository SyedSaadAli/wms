<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VendorProfileController;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::group(['middleware' => 'useradmin'], function () {
    // Route::prefix('/panel/admin')->group(function () {

        //User Routes
        Route::get('/panel/user', [UserController::class, 'list']);
        Route::get('/panel/user/add', [UserController::class, 'add']);
        Route::post('/panel/user/add', [UserController::class, 'insert']);
        Route::get('/panel/user/edit/{id}', [UserController::class, 'edit']);
        Route::post('/panel/user/edit/{id}', [UserController::class, 'update']);
        Route::get('/panel/user/delete/{id}', [UserController::class, 'delete']);
        Route::post('/panel/user/search', [UserController::class, 'list']);

        //Vendor Routes In Admin
        Route::get('/panel/admin/vendor', [UserController::class, 'list']);
        Route::get('/panel/admin/vendor/approve/{id}', [UserController::class, 'approve']);
        Route::get('/panel/admin/vendor/reject/{id}', [UserController::class, 'reject']);
    });
// });

// Vendor Routes
Route::group(['middleware' => 'uservendor'], function () {
    // Route::prefix('/panel/vendor')->group(function () {

        //Profile Routes
        Route::get('/panel/vendor/profile', [VendorProfileController::class, 'index']);
        Route::get('/panel/vendor/profile/add', [VendorProfileController::class, 'add']);
        Route::post('/panel/vendor/profile/add', [VendorProfileController::class, 'insert']);
        Route::get('/panel/vendor/profile/edit/{id}', [VendorProfileController::class, 'edit']);
        Route::post('/panel/vendor/profile/edit/{id}', [VendorProfileController::class, 'update']);

        //Venue Routes
        Route::get('/panel/vendor/venue', [VenueController::class, 'list']);
        Route::get('/panel/vendor/venue/add', [VenueController::class, 'add']);
        Route::post('/panel/vendor/venue/add', [VenueController::class, 'insert']);
        Route::get('/panel/vendor/venue/edit/{id}', [VenueController::class, 'edit']);
        Route::post('/panel/vendor/venue/edit/{id}', [VenueController::class, 'update']);
        Route::get('/panel/vendor/venue/delete/{id}', [VenueController::class, 'delete']);

    });
// });

Route::get('/home', [HomeController::class, 'home'])->name('home');
Route::get('/venues/{id?}', [HomeController::class, 'venues'])->name('venues');
Route::get('/vendors', [HomeController::class, 'vendors'])->name('vendors');

require __DIR__ . '/auth.php';
