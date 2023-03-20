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

Route::get('/sidebar', function () {
    return view('layouts/sidebar');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//staff
Route::prefix('user')
    ->middleware(['auth', 'isUser'])
    ->group(function () {
        Route::controller(App\Http\Controllers\ApiController::class)->group(function () {
            Route::get('/apiSetting', 'api')->name('api_setting');
            Route::post('/apiEdit', 'apiEdit')->name('api_edit');
            Route::post('/apiUpadate', 'apiUpadate')->name('api_update');
        });

        Route::controller(App\Http\Controllers\Auth\UserController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile_view');
            Route::get('/profile/{id}', 'profileUser')->name('profile_user_view');
            Route::post('/profile/update', 'profileUpdate')->name('profile_update');
        });

        Route::controller(App\Http\Controllers\BlastingController::class)->group(function (){
            Route::get('/blasting/index','view')->name('blasting_view');
            Route::get('/blasting/add/view','add_view')->name('blasting_add_view');
            Route::post('/blasting/add','add')->name('blasting_add');
            Route::get('/blasting/edit','edit')->name('blasting_edit_view');
            Route::post('/blasting/update','update')->name('blasting_update');
            Route::get('/blasting/delete/{id}','delete')->name('blasting_delete');

        });
    });

Route::prefix('admin')
    ->middleware(['auth', 'isAdmin'])
    ->group(function () {
        Route::controller(App\Http\Controllers\Auth\UserController::class)->group(function () {
            //go to customerAccountManagement
            Route::get('/user/manage', 'view')->name('user_view');
            //deactivate the user
            Route::get('/deactivateUser/{id}', 'deactivateUser')->name('deactivateUser');
            //reactivate the user
            Route::get('/reactivateUser/{id}', 'reactivateUser')->name('reactivateUser');

            Route::post('/user/profile/update', 'profileUpdateUser')->name('profile_update_user');
        });
    });
