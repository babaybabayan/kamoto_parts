<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Purchases;
use App\Models\Sales;
use App\Models\Barang_harga;
use App\Models\Transaksi;
use App\Models\PurchasesPayment;
use PDF;

class TransaksiController extends Controller{
    public function penjualan(){
    	$brg = DB::table('price as a')->select('a.id','b.code_product','b.name','b.id as idb')->join('product_name as b', 'a.id_product', '=', 'b.id')->whereRaw('a.quantity > 0 group by a.id_product')->orderBy('b.name','ASC')->get();
        $ctrs = DB::table('payment')->count();
        $jmltrs = $ctrs+1;
        return view('transaksi/penjualan', ['brg' => $brg,'ctrs' => $jmltrs]);
    }
    public function data_penjualan(){
    	$pnj = DB::table('price as a')->select('a.id','a.capital','a.selling','b.code_product','b.name','a.quantity','c.quantity as qtyp','c.disc','c.id as idp','d.name as nameu')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('sales as c', 'c.id_price', '=', 'a.id')->join('unit as d', 'b.id_unit', '=', 'd.id')->where('c.status','=','1')->orderBy('b.name','asc')->get();	
    	return response()->json($pnj);
    }
    public function tambah(Request $request){
        $csls = DB::table('sales')->where('id_price','=',$request->checked)->where('status','=',1)->count();
        if ($csls==0) {
            Sales::create([
                'id_price' => $request->checked,
                'status' => 1
            ]);
        }else{
            DB::table('sales')->where('id_price','=',$request->checked)->where('status','=',1)->delete();
        }
    }
    public function delprc($id){
        $prc = Sales::find($id);
        $prc->delete();
    }
    public function inspympnj(Request $request){
        if ($request->tmpo==0) {
            $idsts = 1;
        }elseif ($request->tmpo=="") {
            $idsts = 1;
        }else{
            $idsts = 2;
        }
        Transaksi::create([
            'due_date' => date('Y-m-d', strtotime($request->tgltmpo)),
            'invoice' => $request->invpnj,
            'id_customer' => $request->idcus,
            'id_salesuser' => $request->idsls,
            'id_status' => $idsts,
            'total_payment' => $request->sttlpnj
        ]);
    }
    public function inspnj(Request $request){
        $pym = Transaksi::orderBy('id', 'DESC')->take(1)->get();
        foreach ($pym as $p) {
            $idpym = $p['id'];
        }
        $ipnj = $request->ipnj;
        for ($i=0; $i < count($ipnj); $i++) { 
            $prc = Sales::find($ipnj[$i]);
            $hrg = Barang_harga::find($prc->id_price);
            $vhrg = DB::table('price')->where('id_product','=',$hrg->id_product)->where('quantity','>',0)->orderBy('created_at','ASC')->get();
            $apq=[];
            foreach ($vhrg as $v) {
                $prc->id_payment = $idpym;
                $hrgj = str_replace(".", "", $request->hpnj[$i]);
                $prc->price = $hrgj;
                $prc->disc = $request->dpnj[$i];
                $prc->status = 2;
                $prc->save();
                array_push($apq, $v->quantity);
                $japq = array_sum($apq);
                if ($japq>=$request->qpnj[$i]) {
                    $vhrg2 = DB::table('price')->where('id_product','=',$hrg->id_product)->where('created_at','<',$v->created_at)->orderBy('created_at','ASC')->get();
                    $vhrg3 = DB::table('price')->where('id_product','=',$hrg->id_product)->where('created_at','>',$hrg->created_at)->where('created_at','<=',$v->created_at)->orderBy('created_at','ASC')->get();
                    $vhrg4 = DB::table('price')->where('id_product','=',$hrg->id_product)->where('created_at','>=',$hrg->created_at)->where('created_at','<',$v->created_at)->orderBy('created_at','ASC')->get();
                    foreach ($vhrg3 as $v3) {
                        Sales::create([
                            'id_payment' => $idpym,
                            'id_price' => $v3->id,
                            'disc' => $request->dpnj[$i],
                            'status' => 2
                        ]);
                    }
                    $apq2=[];
                    foreach ($vhrg4 as $v4) {
                        DB::table('sales')->where('id_price','=',$v4->id)->where('id_payment','=',$idpym)->update([
                            'quantity'=>$v4->quantity,
                            'price' => $hrgj
                        ]);
                        array_push($apq2, $v4->quantity);
                    }
                    $japq2 = array_sum($apq2);
                    DB::table('sales')->where('id_price','=',$v->id)->where('id_payment','=',$idpym)->update([
                        'quantity'=>$request->qpnj[$i]-$japq2,
                        'price' => $hrgj
                    ]);
                    foreach ($vhrg2 as $v2) {
                        $hrg2 = Barang_harga::find($v2->id);
                        $hrg2->quantity = 0;
                        $hrg2->save();
                    }
                    $hrg3 = Barang_harga::find($v->id);
                    $hrg3->quantity = $japq-$request->qpnj[$i];
                    $hrg3->save();
                    DB::table('price')->where('id_product','=',$hrg->id_product)->update([
                        'selling'=>$hrgj
                    ]);
                    break;
                }
            }
        }
    }
    public function pembelian(){
        $brg = DB::table('product_name')->orderBy('code_product','ASC')->get();
        return view('transaksi/pembelian', ['brg' => $brg]);
    }
    public function data_pembelian(){
        $pnj = DB::table('price as a')->select('a.id','a.capital','a.selling','b.code_product','b.name','a.quantity','c.quantity as qtyp','c.disc','c.id as idp','d.name as nameu')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('purchases as c', 'c.id_price', '=', 'a.id')->join('unit as d', 'b.id_unit', '=', 'd.id')->where('c.status','=','1')->orderBy('b.name','asc')->get(); 
        return response()->json($pnj);
    }
    public function insprc(Request $request){
        $cprc = DB::table('purchases as a')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$request->checked)->where('a.status','=',1)->count();
        if ($cprc==0) {
            Barang_harga::create([
                'id_product' => $request->checked
            ]);
            $hrg = Barang_harga::orderBy('id', 'DESC')->take(1)->get();
            foreach ($hrg as $h) {
                $idhrg = $h['id'];
            }
            Purchases::create([
                'id_price' => $idhrg,
                'status' => 1
            ]);
        }else{
            $id = DB::table('purchases as a')->select('a.id','b.id as idh')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$request->checked)->where('a.status','=',1)->get();
            foreach ($id as $i) {
                $hrg2 = Barang_harga::find($i->idh);
                $hrg2->delete();
                $prc = Purchases::find($i->id);
                $prc->delete();
            }
        }
    }
    public function delprcpmb($id,$qty){
        DB::table('purchases')->where('id_price','=',$id)->where('status','=',1)->delete();
        $hrg = Barang_harga::find($id);
        $hrg->delete();
    }
    public function inspympmb(Request $request){
        if ($request->tmpopmb==0) {
            $idsts = 1;
        }elseif ($request->tmpopmb=="") {
            $idsts = 1;
        }else{
            $idsts = 2;
        }
        PurchasesPayment::create([
            'due_date' => date('Y-m-d', strtotime($request->tgltmpopmb)),
            'invoice' => $request->invpmb,
            'id_supplier' => $request->idsplpmb,
            'id_status' => $idsts,
            'total_payment' => $request->sttlpmb
        ]);
    }
    public function inspmb(Request $request){
        $pym = PurchasesPayment::orderBy('id', 'DESC')->take(1)->get();
        foreach ($pym as $p) {
            $idpym = $p['id'];
            $idspl = $p['id_supplier'];
        }
        $ipmb = $request->ipmb;
        for ($i=0; $i < count($ipmb); $i++) { 
            $prc = Purchases::find($ipmb[$i]);
            $prc->id_payment = $idpym;
            $prc->quantity = $request->qpmb[$i];
            $prc->disc = $request->dpmb[$i];
            $prc->status = 2;
            $hrg = Barang_harga::find($prc->id_price);
            $chrg = DB::table('price')->where('id_product','=',$hrg->id_product)->where('selling','!=',0)->count();
            if ($chrg==0) {
                $sellinglast = 0;
            }else{
                $hrgj = DB::table('price')->where('id_product','=',$hrg->id_product)->where('selling','!=',0)->orderBy('id', 'DESC')->take(1)->get();
                foreach ($hrgj as $h) {
                    $sellinglast = $h->selling;
                }
            }
            $hrgb = str_replace(".", "", $request->hpmb[$i]);
            $hrg->capital = $hrgb;
            $hrg->selling = $sellinglast;
            $hrg->quantity = $request->qpmb[$i];
            $hrg->id_supplier = $idspl;
            $hrg->weight = $request->bpmb[$i];
            $hrg->save();
            $prc->save();
        }
    }
    public function invpnj(){
        $pym = Transaksi::orderBy('id', 'DESC')->take(1)->get();
        foreach ($pym as $p) {
            $idpym = $p['id'];
        }
        $sls = DB::table('payment as a')->select('a.invoice','b.name as namecus','a.created_at','a.due_date','b.address','c.code_sales','b.city','b.telp','a.total_payment')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('sales_user as c', 'a.id_salesuser', '=', 'c.id')->where('a.id','=',$idpym)->get();
        $stg = DB::table('setting_inv')->where('id','=',1)->get();
        $brg = DB::table('sales as a')->selectRaw('c.code_product,c.name as nameprod,sum(a.quantity) AS qtyp,d.name as nameu,a.price,a.disc')->join('price as b', 'a.id_price', '=', 'b.id')->join('product_name as c', 'b.id_product', '=', 'c.id')->join('unit as d', 'c.id_unit', '=', 'd.id')->where('a.id_payment','=',$idpym)->groupBy('b.id_product')->orderBy('c.code_product','asc')->get();
        $jds = DB::table('sales as a')->selectRaw('(a.price*sum(a.quantity))*(a.disc/100) as jml')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$idpym)->groupBy('b.id_product')->get();
        $jdis=[];
        foreach ($jds as $j) {
            array_push($jdis, round($j->jml));
        }
        $jdisc = array_sum($jdis);
        $customPaper = array(0,0,396.85,609.44);
        $pdf = PDF::loadview('transaksi/invpnj',['sls'=>$sls, 'brg'=>$brg, 'stg'=>$stg, 'jdisc'=>$jdisc])->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }
}