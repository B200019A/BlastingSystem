<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function view()
    {
        $viewUser = User::all();
        return view('/auth/userManagement')->with('user', $viewUser);
    }
    public function deactivateUser($id)
    {
        $deactivateUser = User::find($id);
        $deactivateUser->role = 2;
        $deactivateUser->save();

        return redirect()->route('user_view');
    }

    public function reactivateUser($id)
    {
        $deactivateUser = User::find($id);
        $deactivateUser->role = 0;
        $deactivateUser->save();

        return redirect()->route('user_view');
    }
    public function profile()
    {
        $profile = User::find(Auth::id());

        return view('auth/profile')
            ->with('profile', $profile)
            ->with('check', 'user');
    }
    public function profileUser($id)
    {
        $profile = User::find($id);

        return view('auth/profile')
            ->with('profile', $profile)
            ->with('check', 'admin');
    }
    public function profileUpdate()
    {
        $r = request();
        //valdiate
        $rules = [
            'name' => 'required|string',
            'phone' => 'required|string|min:10',
        ];

        $validator = Validator::make($r->all(), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        $profile = User::find($r->id);

        $profile->name = $r->name;
        $profile->phone = $r->phone;
        $profile->save();

        return redirect()->route('profile_view');
    }
    public function profileUpdateUser()
    {
        $r = request();
        //valdiate
        $rules = [
            'name' => 'required|string',
            'phone' => 'required|string|min:10',
        ];

        $validator = Validator::make($r->all(), $rules);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        $profile = User::find($r->id);

        $profile->name = $r->name;
        $profile->phone = $r->phone;
        $profile->save();

        return redirect()->route('user_view');
    }
}
