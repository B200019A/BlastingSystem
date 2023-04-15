<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Blaster;
use  App\Imports\CustomerImport;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class CustomerController extends Controller
{
    //excel import page
    public function import($id,$existed){

        //validate
        $data['blaster_id'] = $id;
        $data['current_existed'] = $existed;
        return view('user/customer/import',$data);
    }

    public function import_customer(Request $request){

        $request->validate([
            'customer_excel'=>'required|mimes:xlsx,csv,txt'
        ]);

        try{
            Excel::import(new CustomerImport($request->input('blaster_id'),$request->input('current_existed')),$request->file('customer_excel'));
        }
        catch (Exception $e){
            return back()->withError('Please make sure you are using correct template.');
        }

        return redirect()->route('blaster_view_customer',$request->input('blaster_id'));//return to the customer list
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
        return back();
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
        return back();
    }


    public function delete(Request $request){
        $customer = Customer::find($request->input('customer_id'));
        $customer->delete();

        return back();
    }

    public function download(){
        $templatePath = public_path("excel_template/excel_template.xlsx");
        return response()->download($templatePath);
    }

}
