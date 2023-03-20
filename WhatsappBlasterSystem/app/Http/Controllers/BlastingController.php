<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlastingList;
use Auth;

class BlastingController extends Controller
{
    public function view(){

        $blastingLists = BlastingList::where('user_id',Auth::id())->get();

        // dd($blastingLists);
        return view('user/blastinglist/index')->with('blastingLists',$blastingLists);

    }
    public function add_view()
    {
        return view('user/blastinglist/add');
    }

    public function add(Request $request)
    {

        $blasting = BlastingList::create([
            'user_id' => Auth::id(),
            'name' => $request->blasting_name,
        ]);

        return redirect()->route('blasting_view');
    }
    public function delete($id)
    {
        //find the delete_at data
        // $deleteBlasting = BlastingList::withTrashed()->findOrFail(1);
        //recovery the data
        // dd($deleteBlasting->restore());

        $blasting = BlastingList::find($id);

        //validation
        if(Auth::id() == $blasting->user_id){
            $blasting->delete();//soft delete
        }

        return redirect()->route('blasting_view')->with('messages','delete successfully!');
    }
    public function myFeedback()
    {
        $r = request();

        $feebacks = Feeback::where([['user_id', Auth::id()], ['status', '!=', 2]])->get();

        return view('feeback/myFeeback')->with('feebacks', $feebacks);

    }
    public function editFeedback($id)
    {
        $feeback = Feeback::find($id);

        if ($feeback->user_id != Auth::id()) {
            redirect()->route('feeback_index');
        }
        $places = Place::where('branch_id',$feeback->branch_id)->get();

        $titles = Title::whereNot('status', '=', 'close')->get();

        return view('feeback/edit', compact('feeback','titles', 'places'));

    }
    public function updateFeedback()
    {
        $r = request();

        $feeback = Feeback::find($r->id);
        if ($r->file('image') != '' && $feeback->image != $r->file('image')->getClientOriginalName()) {
            $image = $r->file('image');
            $image->move('images', $image->getClientOriginalName()); //images is the location
            $imageName = $image->getClientOriginalName();
            $feeback->image = $imageName;
        }
        $feeback->place = $r->place;
        $feeback->level = $r->level;
        $feeback->title = $r->title;
        $feeback->description = $r->description;
        $feeback->save();

        return redirect()->route('my_feedback');
    }
    public function searchFeedback()
    {
        $r = request();
        $keyword = $r->keyword;
        $feebacks = Feeback::where([['id', 'like', '%' . $keyword . '%'], ['status', '!=', 2]])->get();

        return view('feeback/index')->with('feebacks', $feebacks);
    }
    public function feedbackIndexComplete()
    {
        $feebacks = Feeback::all()->where('status',2);

        return view('feeback/index')->with('feebacks', $feebacks);
    }
}
