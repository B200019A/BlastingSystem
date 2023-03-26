<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blaster;
use App\Models\Message;
use App\Models\Customer;
use Auth;
use Session;
class MessageController extends Controller
{
    public function view()
    {
        $data['messages'] = Message::where('user_id',Auth::id())->get();

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
        $blaster = Blaster::where('id',$request->blaster_id)->first();
        if($blaster->user_id != Auth::id()){

            Session::flash('error','Edit Fail');
            return redirect()->route('message_view');
        }
        if($request->phone != ("attribute1" || "attribute2" || "attribute3" || "attribute4" || "attribute5" || "attribute6" || "attribute7")){
            Session::flash('error','Edit Fail');
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

        if($message == null || $message->user_id != Auth::id()){
            Session::flash('error','Edit Fail');
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
        $blaster = Blaster::where('id',$request->blaster_id)->first();
        if($blaster->user_id != Auth::id()){
            Session::flash('error','Edit Fail');
            return redirect()->route('message_view');
        }
        if($request->phone != ("attribute1" || "attribute2" || "attribute3" || "attribute4" || "attribute5" || "attribute6" || "attribute7")){
            Session::flash('error','Edit Fail');
            return redirect()->route('message_view');
        }
        $date = $request->date;
        $time = $request->time;

        $mergeTime = $date . ' ' . $time;

        $message = Message::find($request->meesage_id);
        if ($message == null || Auth::id() != $message->user_id) {
            Session::flash('error','Edit Fail');
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
            Session::flash('error','Delete Fail');
            return redirect()->route('message_view');
        }

        $message->delete(); //soft delete

        return redirect()
            ->route('message_view')
            ->with('messages', 'delete successfully!');
    }
}
