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
        $brg = DB::table('product_name as a')->select('a.id','a.code_product','a.name','a.id as idb','b.name as nameu','b.id as idu')->join('unit as b', 'a.id_unit', '=', 'b.id')->orderBy('a.code_product','asc')->get();
        $unit = Unit::all();
        return view('barang/barang', ['brg' => $brg, 'unit' => $unit]);
    }
    public function tambah(Request $request){
    	$cdprd = DB::table('product_name')->where('code_product', $request->kode)->count();
        if ($cdprd == 0) {
            Barang::create([
	            'code_product' => $request->kode,
	            'name' => $request->nama,
                'id_unit' => $request->unit
	        ]);
        }
        return Response::json(['success'=>true, 'info'=>$cdprd]);
    }
    public function ubah($id_brg, Request $request){
        $brg = Barang::find($id_brg);
        $brg->code_product = $request->ukode;
        $brg->name = $request->unama;
        $brg->id_unit = $request->uunit;
        $brg->save();
        return redirect('/brg');
    }
    public function saldo(){
        $brg = DB::table('price as a')->select('a.id','b.code_product','b.name','b.id as idb','c.name as nameu','c.id as idu')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('unit as c', 'b.id_unit', '=', 'c.id')->where('a.quantity','>',0)->groupBy('a.id_product')->orderBy('b.code_product','asc')->get();
        $unit = Unit::all();
        return view('barang/saldo', ['brg' => $brg, 'unit' => $unit]);
    }
    public function persediaan(){
        $brg = DB::table('price as a')->select('a.id','b.code_product','b.name','b.id as idb','c.name as nameu','c.id as idu','a.quantity','a.capital','a.selling','a.id_supplier','a.created_at','a.weight')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('unit as c', 'b.id_unit', '=', 'c.id')->where('a.quantity','>',0)->groupBy('a.id_product','a.created_at')->orderBy('b.code_product','asc')->orderBy('a.created_at','asc')->get();
        $unit = Unit::all();
        return view('barang/persediaan', ['brg' => $brg, 'unit' => $unit]);
    }
}