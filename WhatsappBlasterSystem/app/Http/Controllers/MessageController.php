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
            'phone' => 'required|string',
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

        $message = Message::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'blaster_id' => $request->blaster_id,
            'send_time' => $mergeTime,
            'phone' => $request->phone,
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
            'phone' => 'required|string',
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
        $message->message = $request->message;
        $message->blaster_id = $request->blaster_id;
        $message->send_time = $mergeTime;
        $message->phone = $request->phone;
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

        //get attribute
        $attribute = $sendMessage->phone;
        //get phone number
        $phoneNumber = $sendMessage->customers->$attribute;
        $data = [
            'phone_number' => $phoneNumber,
            'message' => $sendMessage->full_message,
        ];

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
}
