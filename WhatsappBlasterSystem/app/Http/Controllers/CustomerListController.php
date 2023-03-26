<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Blaster;
use  App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerListController extends Controller
{
    //excel import page
    public function import($id){

        //validate
        $data['blaster_id'] = $id;

        return view('user/customer/import',$data);
    }

    public function import_customer(Request $request){

        $request->validate([
            'customer_excel'=>'required|mimes:xlsx,csv,txt'
        ]);

        Excel::import(new CustomerImport($request->input('blaster_id')),$request->file('customer_excel'));

        return redirect()->route('blaster_view');
    }

    public function add(Request $request)
    {
        Customer::create([
            'blaster_id' => $request->blaster_id,
            'attribute1' => $request->attribute1,
            'attribute2' => $request->attribute2,
            'attribute3' => $request->attribute3,
            'attribute4' => $request->attribute4,
            'attribute5' => $request->attribute5,
            'attribute6' => $request->attribute6,
            'attribute7' => $request->attribute7,
        ]);
        return redirect()
                ->route('blaster_view_customer',$request->blaster_id)
                ->with('messages', 'added successfully!');
    }


    public function edit(Request $request)
    {
        $customer = Customer::find($request->cust_id);
        //update attribute
        $customer->attribute1 = $request->attribute1;
        $customer->attribute2 = $request->attribute2;
        $customer->attribute3 = $request->attribute3;
        $customer->attribute4 = $request->attribute4;
        $customer->attribute5 = $request->attribute5;
        $customer->attribute6 = $request->attribute6;
        $customer->attribute7 = $request->attribute7;
        $customer->save();
        return redirect()
                ->route('blaster_view_customer',$request->edit_blaster_id)
                ->with('messages', 'edit successfully!');
    }


    public function delete(Request $request){
        $customer = Customer::find($request->input('customer_id'));
        $customer->delete();
        
        return redirect()
                ->route('blaster_view_customer',$request->del_blaster_id)
                ->with('messages', 'delete successfully!');
    }

    // //user keyin page
    // public function keyin($id){
    //     $data['blaster_id'] = $id;
    //     return view('user/customer/keyin',$data);
    // }
}
