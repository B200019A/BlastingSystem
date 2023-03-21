<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlastingList;
use App\Models\CustomerList;
use Auth;

class BlastingController extends Controller
{
    public function view(){

        $blastingLists = BlastingList::where('user_id',Auth::id())->get();

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

}
