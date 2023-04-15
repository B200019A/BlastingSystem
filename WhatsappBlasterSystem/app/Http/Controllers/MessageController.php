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
        $validated = $request->validate([
            'message' => 'required|string',
            'date' => 'required|string',
            'time' => 'required|string',
        ]);

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
            $destinationPath = 'images';
            $image->move(public_path($destinationPath), $image->getClientOriginalName()); //images is the location
            $imageName = $image->getClientOriginalName();
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
        $validated = $request->validate([
            'message' => 'required|string',
            'date' => 'required|string',
            'time' => 'required|string',
            'image' => 'required|string',
        ]);

        //checking
        $blaster = Blaster::where('id', $request->blaster_id)->first();
        if ($blaster->user_id != Auth::id()) {
            Session::flash('error', 'Edit Fail');
            return redirect()->route('message_view');
        }
        if ($request->phone != ('attribute1' || 'attribute2' || 'attribute3' || 'attribute4' || 'attribute5' || 'attribute6' || 'attribute7')) {
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
            $destinationPath = 'images';
            $image->move(public_path($destinationPath), $image->getClientOriginalName()); //images is the location
            $imageName = $image->getClientOriginalName();
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

    public function history_view()
    {
        $data['messages'] = Message::onlyTrashed()
            ->where('user_id', Auth::id())
            ->get();
        if ($data['messages']->count() == null) {
            $data['messages'] = 'history_null';
        }
        return view('user/message/index', $data);
    }

    public function history_customer($id)
    {
        //checking
        $message = Message::onlyTrashed()
            ->where('id', $id)
            ->first();
        if ($message->user_id != Auth::id()) {
            return back();
        }
        $data['customersMessages'] = SendMessage::where('message_id', $id)->get();

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

        $findMessage  = Message::onlyTrashed()->where('id',$sendMessage->message_id)->first();

        if ($findMessage->image != null) {
            // url("images/{$find_send_messages->blasters->image}")
            $data = [
                'phone_number' => $phoneNumber,
                'message' => $sendMessage->full_message,
                'type' => 'image',
                'url' => url("public/images/{$findMessage->image}"),
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
        if($message == null){
            return back();
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
                'message_id' => $message->id,
                'blaster_id' => $message->blasters->id,
                'customer_id' => $customers->id,
                'full_message' => $oriText,
                'phone' => $message->phone,
            ]);
        }
        //send message to customer
        $api = OnsendApi::where('user_id', $message->user_id)->first();
        $apiKey = $api->api;

        $find_send_messages = SendMessage::where('message_id', $message->id)->get();
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
            $message->delete();
        }
        return back();
    }
    public function test(Request $request)
    {
         //valdiate
         $validated = $request->validate([
            'message_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);


        //me
        // $image = $request->file('message_image') ? $request->file('message_image') : null;
        // $imageName = null;
        // if ($image) {
        //     $destinationPath = 'images';
        //     $image->move(public_path($destinationPath), $image->getClientOriginalName()); //images is the location
        //     $imageName = $image->getClientOriginalName();
        // }


        // reference
        $image = $request->file('message_image') ? $request->file('message_image') : null;
        $input['imagename'] = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('images');

        $img = Image::make($request->file('message_image')->getRealPath());
        $img->resize(100, 100, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$input['imagename']);

        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imagename']);

        //$this->postImage->add($input);
        return back();
    }
}
