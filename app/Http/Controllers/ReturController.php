<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;
use App\Models\Barang_harga;
use App\Models\Purchases;
use App\Models\Transaksi;

class ReturController extends Controller{
	public function fr_penjualan(){
		$year = date('Y');
        $month = date('m');
		$hst = DB::table('payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name as namecus','c.name as namests','d.name as namesls')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->join('sales_user as d', 'a.id_salesuser', '=', 'd.id')->whereYear('a.created_at','=',$year)->whereMonth('a.created_at', '=', $month)->orderBy('a.created_at','ASC')->get();
        return view('retur/fpenjualan', ['hst' => $hst]);
    }
    public function r_penjualan(Request $request){
        $tgl1 = date('Y-m-d', strtotime($request->tglhst1));
        $tgl2 = date('Y-m-d', strtotime($request->tglhst2));
        $hst = DB::table('payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name as namecus','c.name as namests','d.name as namesls')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->join('sales_user as d', 'a.id_salesuser', '=', 'd.id')->whereRaw('(a.created_at >= ? AND a.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->orderBy('a.created_at','ASC')->get();
        return view('retur/r_penjualan', ['hst' => $hst]);
    }
    public function dr_penjualan($id){
        $drpj = DB::table('sales as a')->selectRaw('c.code_product,c.name as namebrg,d.name as nameu,sum(a.quantity) as qtyp,a.price,a.disc,a.id as idp,sum(a.retur) as rtr,a.id_payment,b.id_product')->join('price as b', 'a.id_price', '=', 'b.id')->join('product_name as c', 'b.id_product', '=', 'c.id')->join('unit as d', 'c.id_unit', '=', 'd.id')->where('a.id_payment','=',$id)->groupby('c.id')->orderby('c.code_product','asc')->get(); 
        return view('retur/dr_penjualan', ['drpj' => $drpj]);
    }
    public function insdrpnj(Request $request){
        $vhrg = DB::table('sales as a')->select('a.id','a.quantity','a.id_price')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$request->idpym)->where('b.id_product','=',$request->idbrg)->orderBy('a.id','DESC')->get();
        $rtr = DB::table('sales as a')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$request->idpym)->where('b.id_product','=',$request->idbrg)->sum('a.retur');
        if ($rtr==0) {
        	$apq = [];
	        foreach ($vhrg as $v) {
	        	array_push($apq, $v->quantity);
	            $japq = array_sum($apq);
	            if ($japq>=$request->jmlrtr) {
	            	$vhrg2 = DB::table('sales as a')->select('a.id','a.quantity','a.id_price')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id','>',$v->id)->where('a.id_payment','=',$request->idpym)->where('b.id_product', '=', $request->idbrg)->orderBy('a.id','DESC')->get();
	            	$apq2 = [];
	            	foreach ($vhrg2 as $v2) {
	            		array_push($apq2, $v2->quantity);
	            		$sls = Sales::find($v2->id);
				        $sls->retur = $v2->quantity;
				        $sls->save();
				        $hrg = Barang_harga::find($v2->id_price);
				        $hrg->quantity = $hrg->quantity+$v2->quantity;
				        $hrg->save();
	            	}
	            	$japq2 = array_sum($apq2);
	            	$sls2 = Sales::find($v->id);
				    $sls2->retur = $request->jmlrtr-$japq2;
				    $sls2->save();
				    $hrg2 = Barang_harga::find($v->id_price);
				    $hrg2->quantity = $hrg2->quantity+($request->jmlrtr-$japq2);
				    $hrg2->save();
	            	break;
	            }
	        }
        }else{
        	$vhrg3 = DB::table('sales as a')->select('a.id','a.retur','a.id_price')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$request->idpym)->where('b.id_product', '=', $request->idbrg)->get();
        	foreach ($vhrg3 as $v3) {
        		$hrg3 = Barang_harga::find($v3->id_price);
				$hrg3->quantity = $hrg3->quantity-$v3->retur;
				$hrg3->save();
        		$sls3 = Sales::find($v3->id);
				$sls3->retur = 0;
				$sls3->save();
        	}
        	$apq = [];
	        foreach ($vhrg as $v) {
	        	array_push($apq, $v->quantity);
	            $japq = array_sum($apq);
	            if ($japq>=$request->jmlrtr) {
	            	$vhrg2 = DB::table('sales as a')->select('a.id','a.quantity','a.id_price')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id','>',$v->id)->where('a.id_payment','=',$request->idpym)->where('b.id_product', '=', $request->idbrg)->orderBy('a.id','DESC')->get();
	            	$apq2 = [];
	            	foreach ($vhrg2 as $v2) {
	            		array_push($apq2, $v2->quantity);
	            		$sls = Sales::find($v2->id);
				        $sls->retur = $v2->quantity;
				        $sls->save();
				        $hrg = Barang_harga::find($v2->id_price);
				        $hrg->quantity = $hrg->quantity+$v2->quantity;
				        $hrg->save();
	            	}
	            	$japq2 = array_sum($apq2);
	            	$sls2 = Sales::find($v->id);
				    $sls2->retur = $request->jmlrtr-$japq2;
				    $sls2->save();
				    $hrg2 = Barang_harga::find($v->id_price);
				    $hrg2->quantity = $hrg2->quantity+($request->jmlrtr-$japq2);
				    $hrg2->save();
	            	break;
	            }
	        }
        }
        return redirect('/rtr/drpnj/'.$request->idpym);
    }
    public function fr_pembelian(){
    	$year = date('Y');
        $month = date('m');
    	$hst = DB::table('purchases_payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name','c.name as namests')->join('supplier as b', 'a.id_supplier', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->whereYear('a.created_at','=',$year)->whereMonth('a.created_at', '=', $month)->orderBy('a.created_at','ASC')->get();
        return view('retur/fpembelian', ['hst' => $hst]);
    }
    public function r_pembelian(Request $request){
    	$tgl1 = date('Y-m-d', strtotime($request->tglhst1));
        $tgl2 = date('Y-m-d', strtotime($request->tglhst2));
        $hst = DB::table('purchases_payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name','c.name as namests')->join('supplier as b', 'a.id_supplier', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->whereRaw('(a.created_at >= ? AND a.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->orderBy('a.created_at','ASC')->get();
        return view('retur/r_pembelian', ['hst' => $hst]);
    }
    public function dr_pembelian($id){
        $drpm = DB::table('purchases as a')->select('c.code_product','c.name as namebrg','d.name as nameu','a.quantity','b.capital','a.disc','a.id as idp','a.retur','a.id_payment')->join('price as b', 'a.id_price', '=', 'b.id')->join('product_name as c', 'b.id_product', '=', 'c.id')->join('unit as d', 'c.id_unit', '=', 'd.id')->where('a.id_payment','=',$id)->orderby('c.code_product','asc')->get(); 
        return view('retur/dr_pembelian', ['drpm' => $drpm]);
    }
    public function insdrpmb(Request $request){
        $prc = Purchases::find($request->id);
        $hrg = Barang_harga::find($prc->id_price);
        $hrg->quantity = $hrg->quantity+$prc->retur-$request->jmlrtr;
        $hrg->save();
        $prc->retur = $request->jmlrtr;
        $prc->save();
        return redirect('/rtr/drpmb/'.$request->idpym);
    }
}