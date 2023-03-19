<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OnsendApi;
use Auth;
class ApiController extends Controller
{
    public function api()
    {
        if (OnsendApi::where('user_id',Auth::id())->first() == null) {
            $check = 'none';
            $api ="none";
        } else {
            $api = OnsendApi::where('user_id',Auth::id())->first();
            $api = $api->api;
            $check ="none";
        }
        return view('user/apiSetting')->with('api', $api)->with('check',$check);
    }
    public function apiEdit()
    {
        if (OnsendApi::where('user_id',Auth::id())->first() == null) {
            $api = '';
            $check ="edit";
        } else {
            $api = OnsendApi::where('user_id',Auth::id())->first();
            $api = $api->api;
            $check ="edit";
        }
        return view('user/apiSetting')->with('api', $api)->with('check',$check);
    }
    public function apiUpadate()
    {
        $r = request();

        if (OnsendApi::where('user_id',Auth::id())->first() == null) {
            $api = OnsendApi::create([
                'user_id' => Auth::id(),
                'api' => $r->key,
            ]);
        } else {
            $api= OnsendApi::where('user_id',Auth::id())->first();
            $api->api = $r->key;
            $api->save();

        }
        return redirect()->route('api_setting');
    }
}
