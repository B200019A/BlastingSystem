<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Blaster;
use  App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerListController extends Controller
{
    //
    public function import($id){

        //validate
        $data['blaster_id'] = $id;

        return view('user/customer/import',$data);
    }

    public function import_customer(Request $request){

        $request->validate([
            'customer_excel'=>'required|mimes:xlsx,csv,txt'
        ]);
        Excel::import(new CustomerImport($request->blaster_id),$request->file('customer_excel'));

        return redirect()->route('blaster_view');
    }
}
