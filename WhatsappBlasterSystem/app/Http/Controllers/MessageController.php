<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlastingList;
use App\Models\MessageList;
use App\Models\CustomerList;
use Auth;
use DateTime;
class MessageController extends Controller
{
    public function view()
    {
        $messageLists = MessageList::where('user_id', Auth::id())->get();

        // dd($blastingLists);
        return view('user/blastinglist/index')->with('messageLists', $messageLists);
    }
    public function add_view()
    {
        $blastingLists = BlastingList::where('user_id', Auth::id())->get();

        return view('user/messagelist/add')->with('blastingLists', $blastingLists);
    }

    public function add(Request $request)
    {
        $date = $request->date;
        $time = $request->time;

        $merge= $date.' '.$time;

        $message = MessageList::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'blastinglist_id'=> $request->blasting_id,
            'send_time' => $merge,
        ]);

        return redirect()->route('add_view');
    }
    public function delete($id)
    {
        //find the delete_at data
        // $deleteBlasting = BlastingList::withTrashed()->findOrFail(1);
        //recovery the data
        // dd($deleteBlasting->restore());

        $messagelist = MessageList::find($id);

        //validation
        if (Auth::id() == $messagelist->user_id) {
            $messagelist->delete(); //soft delete
        }

        return redirect()
            ->route('message_view')
            ->with('messages', 'delete successfully!');
    }
}
