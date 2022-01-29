<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\Sales_user;

class SalesUserController extends Controller{
    public function index(){
        $sls = Sales_user::orderBy('code_sales','asc')->get();
        return view('sales_user/sales_user', ['sls' => $sls]);
    }
    public function tambah(Request $request){
    	$cdcus = DB::table('sales_user')->where('code_sales', $request->id)->count();
        if ($cdcus == 0) {
            Sales_user::create([
	            'code_sales' => $request->id,
	            'name' => $request->nama,
	            'telp' => $request->telepon
	        ]);
        }
        return Response::json(['success'=>true, 'info'=>$cdcus]);
    }
    public function ubah($id_sls, Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'unama' => 'required',
            'utelepon' => 'required'
        ]);
        $sls = Sales_user::find($id_sls);
        $sls->code_sales = $request->uid;
        $sls->name = $request->unama;
        $sls->telp = $request->utelepon;
        $sls->save();
        return redirect('/sls');
    }
    public function load_sls(Request $request){
        $query = $request->get('namesls');
        $sls = Sales_user::where('name', 'LIKE', '%'. $query.'%')->get();
        $filterResult = array();
        foreach ($sls as $s) {
            $filterResult[] = $s->code_sales.' - '.$s->name;
        }
        return response()->json($filterResult);
    }
    public function getidsls($id){
        $code = strtok($id, ' ');
        $fill = DB::table('sales_user')->where('code_sales', $code)->pluck('id');
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}