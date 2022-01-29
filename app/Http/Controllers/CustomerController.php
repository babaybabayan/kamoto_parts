<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\Customer;

class CustomerController extends Controller{
    public function index(){
        $cus = Customer::orderBy('code_customer','asc')->get();
        return view('customer/customer', ['cus' => $cus]);
    }
    public function tambah(Request $request){
    	$cdcus = DB::table('customer')->where('code_customer', $request->id)->count();
        if ($cdcus == 0) {
            Customer::create([
	            'code_customer' => $request->id,
	            'name' => $request->nama,
	            'address' => $request->alamat,
	            'city' => $request->city,
	            'telp' => $request->telepon
	        ]);
        }
        return Response::json(['success'=>true, 'info'=>$cdcus]);
    }
    public function ubah($id_cus, Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'unama' => 'required',
            'ualamat' => 'required',
            'ucity' => 'required',
            'utelepon' => 'required'
        ]);
        $cus = Customer::find($id_cus);
        $cus->code_customer = $request->uid;
        $cus->name = $request->unama;
        $cus->address = $request->ualamat;
        $cus->city = $request->ucity;
        $cus->telp = $request->utelepon;
        $cus->save();
        return redirect('/cus');
    }
    public function load_cus(Request $request){
        $query = $request->get('namecus');
        $cus = Customer::where('name', 'LIKE', '%'. $query.'%')->get();
        $filterResult = array();
        foreach ($cus as $c) {
            $filterResult[] = $c->code_customer.' - '.$c->name;
        }
        return response()->json($filterResult);
    }
    public function getidcus($id){
        $code = strtok($id, ' ');
        $fill = DB::table('customer')->where('code_customer', $code)->pluck('id');
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}