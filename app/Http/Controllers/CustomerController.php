<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function CreateCustomer(Request $request)
    {
        $user_id = $request->header('id');
        return Customer::create([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "mobile" => $request->input('mobile'),
            "user_id" => $user_id
        ]);
    }

    public function CustomerList(Request $request)
    {
        $user_id = $request->header('id');
        return Customer::where('user_id', $user_id)->get();
    }

    public function CustomerByID(Request $request)
    {
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('id', $customer_id)->where('user_id', $user_id)->get();
    }

    public function CustomerUpdate(Request $request)
    {
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('id', $customer_id)->where('user_id', $user_id)->update([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "mobile" => $request->input('mobile'),
        ]);
    }

    public function CustomerDelete(Request $request){
        $user_id = $request->header('id');
        $customer_id = $request->input('id');
        return Customer::where('id', $customer_id)->where('user_id', $user_id)->delete();
    }
}
