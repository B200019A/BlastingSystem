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

Route::get('test', function () {
    $currentTime = Carbon\Carbon::now()->format('Y-m-d H:i');
    $messages = \App\Models\Message::all();
    $message = $messages;
    foreach ($messages as $message) {
        //replace the second
        $sendTime = Carbon\Carbon::parse($message->send_time)->format('Y-m-d H:i');

        //orignal text
        $oriText = $message->message;

        if ($currentTime == $currentTime) {
            foreach ($message->blasters->customers as $customers) {
                //replace attribute text in messge
                $oriText = str_replace('[attribute1]', $customers->attribute1, $oriText);
                $oriText = str_replace('[attribute2]', $customers->attribute2, $oriText);
                $oriText = str_replace('[attribute3]', $customers->attribute3, $oriText);
                $oriText = str_replace('[attribute4]', $customers->attribute4, $oriText);
                $oriText = str_replace('[attribute5]', $customers->attribute5, $oriText);
                $oriText = str_replace('[attribute6]', $customers->attribute6, $oriText);
                $oriText = str_replace('[attribute7]', $customers->attribute7, $oriText);

                //store send message table
                $send_messages = \App\Models\SendMessage::create([
                    'message_id' => $message->id,
                    'blaster_id' => $message->blasters->id,
                    'customer_id' => $customers->id,
                    'full_message' => $oriText,
                    'phone' => $message->phone,
                ]);
            }
            //send message to customer
            $api = \App\Models\OnsendApi::where('user_id',Auth::id())->first();
            $apiKey = $api->api;

            $find_send_messages =  \App\Models\SendMessage::where('message_id',$message->id)->get();
            foreach($find_send_messages as $find_send_message ){

                //get attribute
                $attribute = $find_send_message->phone;
                //get phone number
                $phoneNumber = $find_send_message->customers->$attribute;
                $data = [
                    'phone_number' => $phoneNumber,
                    'message' => $find_send_message->full_message,
                ];

                //onsend api send to targe phone number
                $response = \Illuminate\Support\Facades\Http::accept('application/json')
                    ->withToken($apiKey)
                    ->post('https://onsend.io/api/v1/send', $data);
            }
            $message->delete();
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

        Route::controller(App\Http\Controllers\BlastingController::class)->group(function () {
            Route::get('/blaster/index', 'view')->name('blaster_view');
            Route::get('/blaster/add/view', 'add_view')->name('blaster_add_view');
            Route::post('/blaster/add', 'add')->name('blaster_add');
            Route::get('/blaster/view/customer/{id}', 'viewCustomer')->name('blaster_view_customer');
            Route::post('/blaster/update', 'update')->name('blaster_update');
            Route::get('/blaster/delete/{id}', 'delete')->name('blaster_delete');
        });

        Route::controller(App\Http\Controllers\CustomerListController::class)->group(function () {
            Route::get('/customer/import/{id}', 'import')->name('import_view');
            Route::post('/customer/import/excel', 'import_customer')->name('import_customer');
        });

        Route::controller(App\Http\Controllers\MessageController::class)->group(function () {
            Route::get('/meesage/index', 'view')->name('message_view');
            Route::get('/meesage/add/view', 'add_view')->name('message_add_view');
            Route::post('/meesage/add', 'add')->name('message_add');
            Route::get('/meesage/edit/{id}', 'edit')->name('message_edit_view');
            Route::post('/meesage/update', 'update')->name('message_update');
            Route::get('/meesage/delete/{id}', 'delete')->name('message_delete');
        });

        // Route::apiResources([
        //     'blasters' => BlastingController::class,
        // ]);
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
