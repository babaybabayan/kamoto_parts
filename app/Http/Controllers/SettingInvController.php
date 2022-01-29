<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SettingInv;

class SettingInvController extends Controller{
    public function index(){
    	$stg = SettingInv::all();
        return view('setting', ['stg' => $stg]);
    }
    public function ubah($id, Request $request){
        $stg = SettingInv::find($id);
        $stg->bank_name = $request->sbn;
        $stg->account_no = $request->san;
        $stg->name = $request->sn;
        $stg->save();
        return redirect('/stg');
    }
}
