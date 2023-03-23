<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blaster;
use App\Models\Message;
use App\Models\Customer;
use Auth;

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
            'date' => 'required|string|unique:users',
            'time' => 'required|string|min:6',
            'phone' => 'required|string',
        ]);

        $date = $request->date;
        $time = $request->time;

        $mergeTime = $date . ' ' . $time;

        $message = Message::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'blastinglist_id' => $request->blaster_id,
            'send_time' => $mergeTime,
            'status' => 'Available',
            'phone' => $request->phone,
        ]);

        return redirect()->route('message_view');
    }
    public function edit($id)
    {
        $message = Message::where('id', $id)->first();
        $blasters = Blaster::where('user_id', Auth::id())->get();

        return view('user/message/add', compact('blasters', 'message'));
    }
    public function update()
    {
    }
    public function delete($id)
    {
        //find the delete_at data
        // $deleteBlasting = BlastingList::withTrashed()->findOrFail(1);
        //recovery the data
        // dd($deleteBlasting->restore());

        $messagelist = Message::find($id);

        //validation
        if (Auth::id() == $messagelist->user_id) {
            $messagelist->delete(); //soft delete
        }

        return redirect()
            ->route('message_view')
            ->with('messages', 'delete successfully!');
    }
}
