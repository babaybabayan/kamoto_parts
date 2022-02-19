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
        $ctrs = DB::table('payment')->count();
        $jmltrs = $ctrs+1;
        return view('transaksi/penjualan', ['ctrs' => $jmltrs]);
    }
    public function data_penjualan(){
    	$pnj = DB::table('price as a')->select('a.id','a.capital','a.selling','b.code_product','b.name','a.quantity','c.quantity as qtyp','c.disc','c.id as idp','d.name as nameu','c.price','b.id as idb')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('sales as c', 'c.id_price', '=', 'a.id')->join('unit as d', 'b.id_unit', '=', 'd.id')->where('c.status','=','1')->orderBy('c.created_at','desc')->get();
    	return response()->json($pnj);
    }
    public function insbrgpnj($id,$idcus){
        $code = strtok($id, ' ');
        $fill = DB::table('price as a')->select('a.id','a.id_product')->join('product_name as b', 'a.id_product', '=', 'b.id')->where('b.code_product', '=', $code)->where('a.quantity','>',0)->orderBy('a.id','ASC')->take(1)->get();
        foreach ($fill as $f) {
            $csls = DB::table('sales')->where('id_price','=',$f->id)->where('status','=',1)->count();
            if ($csls==0) {
                $price = DB::table('sales as a')->select('a.price')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('b.id_customer','=',$idcus)->where('c.id_product','=',$f->id_product)->count();
                if ($price==0) {
                    $sellinglast = 0;
                }else{
                    $price2 = DB::table('sales as a')->select('a.price')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('b.id_customer','=',$idcus)->where('c.id_product','=',$f->id_product)->orderBy('a.id','DESC')->take(1)->get();
                    foreach ($price2 as $p2) {
                        $sellinglast = $p2->price;
                    }
                }
                Sales::create([
                    'id_price' => $f->id,
                    'price' => $sellinglast,
                    'status' => 1
                ]);
            }
        }
    }
    public function qtypnj(Request $request){
        $prc = Sales::find($request->id);
        $prc->quantity = $request->qty;
        $prc->save();
    }
    public function hrgpnj(Request $request){
        $prc = Sales::find($request->id);
        $prc->price = $request->hrg;
        $hrg = Barang_harga::find($prc->id_price);
        $hrg->selling = $request->hrg;
        $hrg->save();
        $prc->save();
    }
    public function dispnj(Request $request){
        $prc = Sales::find($request->id);
        $prc->disc = $request->dis;
        $prc->save();
    }
    public function hrgmpnj($ids,$idb,$idcus){
        $hst = DB::table('sales as a')->select('b.created_at','a.price','a.id')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('c.id_product','=',$idb)->where('b.id_customer', '=', $idcus)->groupBy('b.id')->orderBy('b.created_at','DESC')->get();
        return view('transaksi/hrgmpnj', ['hsthrg' => $hst,'ids' => $ids]);
    }
    public function edthrgmpnj($idh,$ids){
        $sls = Sales::find($idh);
        $sls2 = Sales::find($ids);
        $sls2->price = $sls->price;
        $sls2->save();
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
            $idcus = $p['id_customer'];
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
                    $jprice = DB::table('sales as a')->select('c.id')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('b.id_customer','=',$idcus)->where('c.id_product','=',$hrg->id_product)->get();
                    foreach ($jprice as $jp) {
                        DB::table('price')->where('id','=',$jp->id)->update([
                            'selling'=>$hrgj
                        ]);
                    }
                    break;
                }
            }
        }
    }
    public function pembelian(){
        return view('transaksi/pembelian');
    }
    public function data_pembelian(){
        $pnj = DB::table('price as a')->select('a.id','a.capital','a.selling','b.code_product','b.name','a.quantity','c.quantity as qtyp','c.disc','c.id as idp','d.name as nameu','b.id as idb')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('purchases as c', 'c.id_price', '=', 'a.id')->join('unit as d', 'b.id_unit', '=', 'd.id')->where('c.status','=','1')->orderBy('c.created_at','desc')->get();
        return response()->json($pnj);
    }
    public function insbrg($id){
        $code = strtok($id, ' ');
        $fill = DB::table('product_name')->where('code_product', $code)->get();
        foreach ($fill as $f) {
            $cprc = DB::table('purchases as a')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$f->id)->where('a.status','=',1)->count();
            if ($cprc==0) {
                Barang_harga::create([
                    'id_product' => $f->id
                ]);
                $hrg = Barang_harga::orderBy('id', 'DESC')->take(1)->get();
                foreach ($hrg as $h) {
                    $idhrg = $h['id'];
                }
                Purchases::create([
                    'id_price' => $idhrg,
                    'status' => 1
                ]);
            }
        }
        
    }
    public function qtypmb(Request $request){
        $prc = Purchases::find($request->id);
        $prc->quantity = $request->qty;
        $hrg = Barang_harga::find($prc->id_price);
        $hrg->quantity = $request->qty;
        $hrg->save();
        $prc->save();
    }
    public function hrgpmb(Request $request){
        $prc = Purchases::find($request->id);
        $hrg = Barang_harga::find($prc->id_price);
        $hrg->capital = $request->hrg;
        $hrg->save();
    }
    public function dispmb(Request $request){
        $prc = Purchases::find($request->id);
        $prc->disc = $request->dis;
        $prc->save();
    }
    public function hrgmpmb($idp,$idb,$idspl){
        $hst = DB::table('purchases as a')->select('b.created_at','c.capital','a.id')->join('purchases_payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('c.id_product','=',$idb)->where('b.id_supplier', '=', $idspl)->orderBy('b.created_at','DESC')->get();
        return view('transaksi/hrgmpmb', ['hsthrg' => $hst,'idp' => $idp]);
    }
    public function edthrgmpmb($idh,$idp){
        $prc = Purchases::find($idh);
        $hrg = Barang_harga::find($prc->id_price);
        $prc2 = Purchases::find($idp);
        $hrg2 = Barang_harga::find($prc2->id_price);
        $hrg2->capital = $hrg->capital;
        $hrg2->save();
    }
    public function brtpmb(Request $request){
        $prc = Purchases::find($request->id);
        $hrg = Barang_harga::find($prc->id_price);
        $hrg->weight = $request->brt;
        $hrg->save();
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
            $prc->status = 2;
            $hrg = Barang_harga::find($prc->id_price);
            $hrg->id_supplier = $idspl;
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
