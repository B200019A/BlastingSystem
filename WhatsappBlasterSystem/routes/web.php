<?php

//use Illuminate\Support\Facades\App;
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

Route::get('test', function(){
    $messages = \App\Models\MessageList::get();

    foreach($messages as $message){
        $oriText = $message->message;

        foreach($message->blastinglists->customerlists as $costomer){
            $oriText = str_replace('[attribute1]', $costomer->attribute1, $oriText);
            $oriText = str_replace('[attribute2]', $costomer->attribute2, $oriText);
            $oriText = str_replace('[attribute3]', $costomer->attribute3, $oriText);
            $oriText = str_replace('[attribute4]', $costomer->attribute4, $oriText);
            $oriText = str_replace('[attribute5]', $costomer->attribute5, $oriText);
            $oriText = str_replace('[attribute6]', $costomer->attribute6, $oriText);
            $oriText = str_replace('[attribute7]', $costomer->attribute7, $oriText);
            $oriText = trim($oriText);
            dd($oriText);
            // $breasting->breast_messages()->create([
            //     'costomer_id' => $costomer->id,
            //     'message' => $oriText
            // ]);
        }
    }
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
            Route::get('/blaster/index','view')->name('blaster_view');
            Route::get('/blaster/add/view','add_view')->name('blaster_add_view');
            Route::post('/blaster/add','add')->name('blaster_add');
            Route::get('/blaster/edit','edit')->name('blaster_edit_view');
            Route::post('/blaster/update','update')->name('blasterupdate');
            Route::get('/blaster/delete/{id}','delete')->name('blaster_delete');
        });

        Route::controller(App\Http\Controllers\CustomerListController::class)->group(function (){
            Route::get('/customer/import','import')->name('import_view');
            Route::post('/customer/import/excel','import_customer')->name('import_customer');
        });

        Route::controller(App\Http\Controllers\MessageController::class)->group(function (){
            Route::get('/meesage/index','view')->name('message_view');
            Route::get('/meesage/add/view','add_view')->name('message_add_view');
            Route::post('/meesage/add','add')->name('message_add');
            Route::get('/meesage/edit/{id}','edit')->name('message_edit_view');
            Route::post('/meesage/update','update')->name('message_update');
            Route::get('/meesage/delete/{id}','delete')->name('message_delete');

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

