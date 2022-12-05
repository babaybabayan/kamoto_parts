<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SettingInv;

class SettingInvController extends Controller{
    public function index(){
    	$data = SettingInv::first();
        return view('setting')->with('data', $data);
    }
    public function ubah($id, Request $request){
        $data = SettingInv::find($id);
        $data->store_name = $request->storeName;
        $data->name = $request->onBehalfOf;
        $data->bank_name = $request->bankName;
        $data->phone_number = $request->phoneNumber;
        $data->account_number = $request->accountNumber;
        $data->save();
        return redirect('/stg');
    }
}
