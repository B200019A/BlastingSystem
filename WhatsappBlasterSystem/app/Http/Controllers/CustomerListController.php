<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerList;
use  App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerListController extends Controller
{
    //
    public function import(){
        return view('user/customer/import');
    }

    public function import_customer(Request $request){
        $request->validate([    
            'customer_excel'=>'required|mimes:xlsx,csv,txt' 
        ]);

        Excel::import(new CustomerImport($request->input('blasting_id')),$request->file('customer_excel'));

        return redirect()->route('import_view');
    }
}
