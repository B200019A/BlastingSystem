<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blaster;
use App\Models\Message;
use App\Models\OnsendApi;
use App\Models\SendMessage;
use Auth;
use Session;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Arr;

class MessageController extends Controller
{
    public function view()
    {
        $data['messages'] = Message::where('user_id', Auth::id())->get();

        return view('user/message/index', $data);
    }
    public function add_view()
    {
        $data['blasters'] = Blaster::where('user_id', Auth::id())->get();

        return view('user/message/add', $data);
    }

    public function add(Request $request)
    {
        //valdiate
        if ($request->file('message_image') != null) {
            $validated = $request->validate([
                'message' => 'required|string',
                'date' => 'required|string',
                'time' => 'required|string',
                'message_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
        } else {
            $validated = $request->validate([
                'message' => 'required|string',
                'date' => 'required|string',
                'time' => 'required|string',
            ]);
        }

        //checking
        $blaster = Blaster::where('id', $request->blaster_id)->first();
        if ($blaster->user_id != Auth::id()) {
            Session::flash('error', 'Edit Fail');
            return redirect()->route('message_view');
        }

        $date = $request->date;
        $time = $request->time;

        $mergeTime = $date . ' ' . $time;

        $image = $request->file('message_image') ? $request->file('message_image') : null;
        $imageName = null;

        if ($image) {
            $imageName = $image->getClientOriginalName();
            $destinationPath = public_path('images');
            if($image->getSize() >= 500001){
                $img = Image::make($request->file('message_image')->getRealPath());
                $height = $img->height() / 4; //get 1/4th of image height
                $width = $img->width() / 4; //get 1/4th of image width
                //resize and then store image to pulbic/images
                $imageFile = $img->resize($width, $height)->save($destinationPath . '/' . $imageName);
            }else{
                $image->move($destinationPath, $imageName); //images is the location
            }
        }

        $message = Message::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'blaster_id' => $request->blaster_id,
            'send_time' => $mergeTime,
            'image' => $imageName ? $imageName : null,
        ]);

        return redirect()->route('message_view');
    }
    public function edit($id)
    {
        $message = Message::where('id', $id)->first();

        if ($message == null || $message->user_id != Auth::id()) {
            Session::flash('error', 'Edit Fail');
            return redirect()->route('message_view');
        }
        $blasters = Blaster::where('user_id', Auth::id())->get();

        return view('user/message/add', compact('blasters', 'message'));
    }
    public function update(Request $request)
    {
        //valdiate
        if ($request->file('message_image') != null) {
            $validated = $request->validate([
                'message' => 'required|string',
                'date' => 'required|string',
                'time' => 'required|string',
                'message_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);
        } else {
            $validated = $request->validate([
                'message' => 'required|string',
                'date' => 'required|string',
                'time' => 'required|string',
            ]);
        }

        //checking
        $blaster = Blaster::where('id', $request->blaster_id)->first();
        if ($blaster->user_id != Auth::id()) {
            Session::flash('error', 'Edit Fail');
            return redirect()->route('message_view');
        }

        $date = $request->date;
        $time = $request->time;

        $mergeTime = $date . ' ' . $time;

        $message = Message::find($request->meesage_id);
        if ($message == null || Auth::id() != $message->user_id) {
            Session::flash('error', 'Edit Fail');
            return redirect()->route('message_view');
        }
        if ($request->file('message_image') != '' && $blaster->image != $request->file('message_image')->getClientOriginalName()) {
            $image = $request->file('message_image');
            $imageName = $image->getClientOriginalName();
            $destinationPath = public_path('images');

            if($image->getSize() >= 500001){
                $img = Image::make($request->file('message_image')->getRealPath());
                $height = $img->height() / 4; //get 1/4th of image height
                $width = $img->width() / 4; //get 1/4th of image width
                //resize and then store image to pulbic/images
                $imageFile = $img->resize($width, $height)->save($destinationPath . '/' . $imageName);
            }else{
                $image->move($destinationPath, $imageName); //images is the location
            }
            //save to databse update image
            $message->image = $imageName;

        }

        $message->message = $request->message;
        $message->blaster_id = $request->blaster_id;
        $message->send_time = $mergeTime;
        $message->save();

        return redirect()->route('message_view');
    }
    public function delete($id)
    {
        //find the delete_at data
        // $deleteBlasting = BlastingList::withTrashed()->findOrFail(1);
        //recovery the data
        // dd($deleteBlasting->restore());

        $message = Message::find($id);

        //validation
        if ($message == null || Auth::id() != $message->user_id) {
            Session::flash('error', 'Delete Fail');
            return redirect()->route('message_view');
        }

        $message->delete(); //soft delete

        return redirect()
            ->route('message_view')
            ->with('messages', 'delete successfully!');
    }
    public function delete_view()
    {
        $data['messages'] = Message::onlyTrashed()
            ->where('user_id', Auth::id())
            ->get();
        if ($data['messages']->count() == null) {
            $data['messages'] = 'message_history_null';
        }
        return view('user/message/index', $data);
    }
    public function restore($id)
    {
        $message = Message::withTrashed()->find($id);
        if ($message->user_id == Auth::id()) {
            $message->restore();
        }
        return back();
    }
    public function history_view()
    {
        $data = SendMessage::where('user_id', Auth::id())->get();
        $data = $data->groupBy('send_time');
        $sendMessages = [];
        foreach ($data as $key => $data) {
            $searchMessage = SendMessage::where('send_time', $key)->first();
            array_push($sendMessages, $searchMessage);
        }
        return view('user/message/send_message')->with('sendMessages', $sendMessages);
    }

    public function history_customer($send_time)
    {
        //checking
        $message = SendMessage::where('send_time', $send_time)->first();
        if ($message->user_id != Auth::id()) {
            return back();
        }

        $data['customersMessages'] = SendMessage::where('send_time', $send_time)->get();

        return view('user/message/history_customer', $data);
    }
    public function resend($id)
    {
        $sendMessage = SendMessage::where('id', $id)->first();

        //send message to customer
        $api = OnsendApi::where('user_id', Auth::id())->first();
        $apiKey = $api->api;

        //get phone number
        $phoneNumber = $sendMessage->customers->attribute1;

        if ($sendMessage->messages->image != null) {
            // url("images/{$find_send_messages->blasters->image}")
            $data = [
                'phone_number' => $phoneNumber,
                'message' => $sendMessage->full_message,
                'type' => 'image',
                'url' => url("public/images/{$sendMessage->messages->image}"),
            ];
        } else {
            $data = [
                'phone_number' => $phoneNumber,
                'message' => $sendMessage->full_message,
            ];
        }
        //onsend api send to targe phone number
        $response = \Illuminate\Support\Facades\Http::accept('application/json')
            ->withToken($apiKey)
            ->post('https://onsend.io/api/v1/send', $data);

        //check send message status
        $response = json_decode($response, true);
        $collection = collect($response);
        $time = Carbon::now();
        if (Arr::has($collection, 'errors')) {
            $sendMessage->fail_at = $time;
        } else {
            if (!$collection['success']) {
                //cannot send the target phone number
                $sendMessage->fail_at = $time;
            } else {
                //successful send the phone number
                $sendMessage->pass_at = $time;
            }
        }
        $sendMessage->save();
        return back();
    }

    public function send_now($id)
    {
        $message = Message::where([['id', $id], ['user_id', Auth::id()]])->first();
        if ($message == null) {
            return back();
        }
        $currentTime = Carbon::now();

        if ($message->blasters == null) {
            return back()->with('error', 'Blaster List Not Exist!');
        }
        foreach ($message->blasters->customers as $customers) {
            //orignal text
            $oriText = $message->message;
            //replace attribute text in messge
            $oriText = str_replace('[attribute1]', $customers->attribute1, $oriText);
            $oriText = str_replace('[attribute2]', $customers->attribute2, $oriText);
            $oriText = str_replace('[attribute3]', $customers->attribute3, $oriText);
            $oriText = str_replace('[attribute4]', $customers->attribute4, $oriText);
            $oriText = str_replace('[attribute5]', $customers->attribute5, $oriText);
            $oriText = str_replace('[attribute6]', $customers->attribute6, $oriText);
            $oriText = str_replace('[attribute7]', $customers->attribute7, $oriText);
            //store send message table

            $send_messages = SendMessage::create([
                'user_id' => Auth::id(),
                'message_id' => $message->id,
                'blaster_id' => $message->blasters->id,
                'customer_id' => $customers->id,
                'full_message' => $oriText,
                'send_time' => $currentTime, //store current time
            ]);
        }
        //send message to customer
        $api = OnsendApi::where('user_id', $message->user_id)->first();
        $apiKey = $api->api;

        $find_send_messages = SendMessage::where('send_time', $currentTime)->get();

        foreach ($find_send_messages as $find_send_messages) {
            //get phone number
            $phoneNumber = $find_send_messages->customers->attribute1;

            if ($message->image != null) {
                $data = [
                    'phone_number' => $phoneNumber,
                    'message' => $find_send_messages->full_message,
                    'type' => 'image',
                    'url' => url("public/images/{$message->image}"),
                ];
            } else {
                $data = [
                    'phone_number' => $phoneNumber,
                    'message' => $find_send_messages->full_message,
                ];
            }
            //onsend api send to targe phone number
            $response = \Illuminate\Support\Facades\Http::accept('application/json')
                ->withToken($apiKey)
                ->post('https://onsend.io/api/v1/send', $data);

            //check send message status
            $response = json_decode($response, true);
            $collection = collect($response);
            $time = Carbon::now();
            if (Arr::has($collection, 'errors')) {
                $find_send_messages->fail_at = $time;
            } else {
                if (!$collection['success']) {
                    //cannot send the target phone number
                    $find_send_messages->fail_at = $time;
                } else {
                    //successful send the phone number
                    $find_send_messages->pass_at = $time;
                }
            }
            $find_send_messages->save();
            // $message->delete();
        }
        return back();
    }
}
