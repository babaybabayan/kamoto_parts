<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\Supplier;

class SupplierController extends Controller{
    public function index(){
    	$spl = Supplier::orderBy('code_supplier','asc')->get();
        return view('supplier/supplier', ['spl' => $spl]);
    }
    public function tambah(Request $request){
    	$cdspl = DB::table('supplier')->where('code_supplier', $request->id)->count();
        if ($cdspl == 0) {
            Supplier::create([
	            'code_supplier' => $request->id,
	            'name' => $request->nama,
	            'address' => $request->alamat,
	            'city' => $request->city,
	            'telp' => $request->telepon
	        ]);
        }
        return Response::json(['success'=>true, 'info'=>$cdspl]);
    }
    public function ubah($id_spl, Request $request){
        $this->validate($request,[
            'uid' => 'required',
            'unama' => 'required',
            'ualamat' => 'required',
            'ucity' => 'required',
            'utelepon' => 'required'
        ]);
        $spl = Supplier::find($id_spl);
        $spl->code_supplier = $request->uid;
        $spl->name = $request->unama;
        $spl->address = $request->ualamat;
        $spl->city = $request->ucity;
        $spl->telp = $request->utelepon;
        $spl->save();
        return redirect('/spl');
    }
    public function load_namesplpmb(Request $request){
        $qnamespl = $request->get('namesplpmb');
        $spl = Supplier::where('name', 'LIKE', '%'.$qnamespl.'%')->get();
        $filterResult = array();
        foreach ($spl as $s) {
            $filterResult[] = $s->code_supplier.' - '.$s->name;
        }
        return response()->json($filterResult);
    }
    public function getidsplpmb($id){
        $code = strtok($id, ' ');
        $fill = DB::table('supplier')->where('code_supplier', $code)->pluck('id');
        return Response::json(['success'=>true, 'info'=>$fill]);
    }
}