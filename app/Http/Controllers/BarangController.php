<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\Barang;
use App\Models\Barang_harga;
use App\Models\Unit;

class BarangController extends Controller{
    public function index(){
        $brg = DB::table('product_name as a')->select('a.id','a.code_product','a.name','a.weight','a.id as idb','b.name as nameu','b.id as idu')->join('unit as b', 'a.id_unit', '=', 'b.id')->orderBy('a.name','asc')->get();
        $unit = Unit::all();
        return view('barang/barang', ['brg' => $brg, 'unit' => $unit]);
    }
    public function tambah(Request $request){
    	$cdprd = DB::table('product_name')->where('code_product', $request->kode)->count();
        if ($cdprd == 0) {
            Barang::create([
	            'code_product' => $request->kode,
	            'name' => $request->nama,
	            'weight' => $request->weight,
                'id_unit' => $request->unit
	        ]);
        }
        return Response::json(['success'=>true, 'info'=>$cdprd]);
    }
    public function ubah($id_brg, Request $request){
        $brg = Barang::find($id_brg);
        $brg->code_product = $request->ukode;
        $brg->name = $request->unama;
        $brg->weight = $request->idweight;
        $brg->id_unit = $request->uunit;
        $brg->save();
        return redirect('/brg');
    }
    public function saldo(){
        $brg = DB::table('price as a')->select('a.id','b.code_product','b.name','b.id as idb','c.name as nameu','c.id as idu')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('unit as c', 'b.id_unit', '=', 'c.id')->where('a.quantity','>',0)->groupBy('a.id_product')->orderBy('b.name','asc')->get();
        $unit = Unit::all();
        return view('barang/saldo', ['brg' => $brg, 'unit' => $unit]);
    }
    public function persediaan(){
        $brg = DB::table('price as a')->select('a.id','b.code_product','b.name','b.id as idb','c.name as nameu','c.id as idu','a.quantity','a.capital','a.selling','a.id_supplier','a.created_at','b.weight')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('unit as c', 'b.id_unit', '=', 'c.id')->where('a.quantity','>',0)->groupBy('a.id_product','a.created_at')->orderBy('b.name','asc')->orderBy('a.created_at','asc')->get();
        $unit = Unit::all();
        return view('barang/persediaan', ['brg' => $brg, 'unit' => $unit]);
    }
    public function load_namebrgpmb(Request $request){
        $qnamebrg = $request->get('namebrgpmb');
        $brg = Barang::where('name', 'LIKE', '%'.$qnamebrg.'%')->get();
        $filterResult = array();
        foreach ($brg as $b) {
            $filterResult[] = $b->code_product.' - '.$b->name;
        }
        return response()->json($filterResult);
    }
    public function load_namebrgpnj(Request $request){
        $qnamebrg = $request->get('namebrgpnj');
        $brg = DB::table('price as a')->select('a.id','b.code_product','b.name','b.id as idb')->join('product_name as b', 'a.id_product', '=', 'b.id')->where('name', 'LIKE', '%'.$qnamebrg.'%')->whereRaw('a.quantity > 0 group by a.id_product')->orderBy('b.name','ASC')->get();
        $filterResult = array();
        foreach ($brg as $b) {
            $filterResult[] = $b->code_product.' - '.$b->name;
        }
        return response()->json($filterResult);
    }
    public function load_namebrghpmb(Request $request){
        $qnamebrg = $request->get('namebrghpmb');
        $brg = Barang::where('name', 'LIKE', '%'.$qnamebrg.'%')->get();
        $filterResult = array();
        foreach ($brg as $b) {
            $filterResult[] = $b->code_product.' - '.$b->name;
        }
        return response()->json($filterResult);
    }
    public function load_namebrghpnj(Request $request){
        $qnamebrg = $request->get('namebrghpnj');
        $brg = DB::table('price as a')->select('a.id','b.code_product','b.name','b.id as idb')->join('product_name as b', 'a.id_product', '=', 'b.id')->where('name', 'LIKE', '%'.$qnamebrg.'%')->whereRaw('a.quantity > 0 group by a.id_product')->orderBy('b.name','ASC')->get();
        $filterResult = array();
        foreach ($brg as $b) {
            $filterResult[] = $b->code_product.' - '.$b->name;
        }
        return response()->json($filterResult);
    }
}
