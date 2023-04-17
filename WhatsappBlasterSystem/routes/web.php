<?php

//use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;

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

        Route::controller(App\Http\Controllers\BlasterController::class)->group(function () {
            Route::get('/blaster/index', 'view')->name('blaster_view');
            Route::get('/blaster/add/view', 'add_view')->name('blaster_add_view');
            Route::post('/blaster/add', 'add')->name('blaster_add');
            Route::get('/blaster/view/customer/{id}', 'viewCustomer')->name('blaster_view_customer');
            Route::get('/blaster/edit/{id}', 'edit')->name('blaster_edit');
            Route::post('/blaster/update', 'update')->name('blaster_update');
            Route::get('/blaster/delete/{id}', 'delete')->name('blaster_delete');
        });

        Route::controller(App\Http\Controllers\CustomerController::class)->group(function () {
            Route::get('/customer/import/{id}/{existed}', 'import')->name('import_view');
            Route::post('/customer/import/excel', 'import_customer')->name('import_customer');
            Route::post('/customer/add', 'add')->name('customer_add');
            Route::post('/customer/edit', 'edit')->name('customer_edit');
            Route::post('/customer/delete', 'delete')->name('customer_delete');
            Route::get('/customer/download','download')->name('template_download');
        });

        Route::controller(App\Http\Controllers\MessageController::class)->group(function () {
            Route::get('/meesage/index', 'view')->name('message_view');
            Route::get('/meesage/add/view', 'add_view')->name('message_add_view');
            Route::post('/meesage/add', 'add')->name('message_add');
            Route::get('/meesage/edit/{id}', 'edit')->name('message_edit_view');
            Route::post('/meesage/update', 'update')->name('message_update');
            Route::get('/meesage/delete/{id}', 'delete')->name('message_delete');
            Route::get('/meesage/delete', 'delete_view')->name('message_delete_view');
            Route::get('/meesage/history', 'history_view')->name('message_history_view');
            Route::get('/meesage/restore/{id}', 'restore')->name('restore');
            Route::get('/meesage/history/customer/{id}', 'history_customer')->name('history_customer_view');
            Route::get('/meesage/resend/{id}', 'resend')->name('resend_message');
            Route::post('/test', 'test')->name('test');
            Route::get('/send/now/{id}', 'send_now')->name('send_now');


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
