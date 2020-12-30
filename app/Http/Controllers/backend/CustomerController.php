<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use DB;

class CustomerController extends Controller
{
    public function index()
    {
    	//dd('kkkk');
       // $this->checkpermission('sales-list');
    	$customer=[];
       $customer = Customer::orderBy('id', 'desc')->get();
        return view('backend.customer.list', compact('customer'));
    }

     public function create()
    {
       // $this->checkpermission('sales-create');
       // $salescart = Salescart::all();
        return view('backend.customer.create');
    }
     public function store(Request $request)
    {
        $input = \Request::all();
        //dd($input);
       $this->validate($request, [
            'name' => 'required',
            "cust_id" => 'required|unique:customers,customer_id',
            //'cust_id' => 'required',
            'mobile' => 'required|digits:10',
            'address' => 'required',
        ]);
       
   

      // dd($input);
       $message =  DB::table('customers')->insert(
                array(
            'client_name' => $request->name,
            'customer_id' => $request->cust_id,
            'phone' => $request->mobile,
            'address' => $request->address,
            'email' => $request->email,
            'landmark' => $request->landmark,
            'gst_tin' => $request->gsttin,
            'status' => $request->status,
            'created_at' => date('Y-m-d H:i:s'),
                ));
      
      // dd($request,$input);
      // $customer_id=$request->cust_id;
      // dd($customer_id);
        if ($message) {
          if($request->sale == "dashboard"){
            //$customerID=[];
            
            //dd($customerID);
           // $success_message='You are successfully created. New Customer ID:'. $request->cust_id;
            return redirect()->route('user.dashboard')->with('success_message', 'You are successfully created.  '. $request->name.'  Customer ID:   '. $request->cust_id);
          }else{
            return redirect()->route('customer.list')->with('success_message', 'You are successfully created');
          }

              
        } else {
            return redirect()->route('create.customer')->with('error_message', 'can not created at this time ');
        }
     
    }


}
