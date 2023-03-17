<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//staff
Route::prefix('user')
    ->middleware(['auth', 'isUser'])
    ->group(function () {});

Route::prefix('admin')
    ->middleware(['auth', 'isAdmin'])
    ->group(function () {
        Route::controller(App\Http\Controllers\UserController::class)->group(function () {
            //go to customerAccountManagement
            Route::get('/user/manage', 'view')->name('user_view');
            //deactivate the user
            Route::get('/deactivateUser/{id}', 'deactivateUser')->name('deactivateUser');
            //reactivate the user
            Route::get('/reactivateUser/{id}', 'reactivateUser')->name('reactivateUser');

            Route::get('/user/profile', 'profile')->name('profile_view');
            Route::get('/user/profile/{id}', 'profileUser')->name('profile_user_view');
            Route::post('/user/profile/update', 'profileUpdate')->name('profile_update');
        });
    });
