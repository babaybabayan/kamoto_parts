<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;
use App\Models\Barang_harga;
use App\Models\Purchases;
use App\Models\Transaksi;
use App\Models\PurchasesPayment;
use PDF;

class HistoryController extends Controller{
    public function fh_penjualan(){
        $hst = DB::table('payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name as namecus','c.name as namests','d.name as namesls')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->join('sales_user as d', 'a.id_salesuser', '=', 'd.id')->whereDate('a.created_at','=',date('Y-m-d '))->orderBy('a.created_at','ASC')->get();
        return view('history/fpenjualan', ['hst' => $hst]);
    }
    public function h_penjualan(Request $request){
        $tgl1 = date('Y-m-d', strtotime($request->tglhst1));
        $tgl2 = date('Y-m-d', strtotime($request->tglhst2));
        $hst = DB::table('payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name as namecus','c.name as namests','d.name as namesls')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->join('sales_user as d', 'a.id_salesuser', '=', 'd.id')->whereRaw('(a.created_at >= ? AND a.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->orderBy('a.created_at','ASC')->get();
        return view('history/penjualan', ['hst' => $hst]);
    }
    public function e_penjualan($id){
    	$pym = DB::table('payment as a')->select('a.created_at','a.due_date','a.invoice','b.name as namecus','c.name as namesls','a.id','b.id as idcus','c.id as idsls')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('sales_user as c', 'a.id_salesuser', '=', 'c.id')->where('a.id','=',$id)->get();
    	$brg = DB::table('price as a')->select('a.id','b.code_product','b.name','b.id as idb')->join('product_name as b', 'a.id_product', '=', 'b.id')->whereRaw('a.quantity > 0 group by a.id_product')->orderBy('b.name','ASC')->get();
        return view('history/e_penjualan', ['brg' => $brg, 'pym' => $pym]);
    }
    public function t_penjualan($id){
        $pnj = DB::table('price as a')->selectRaw('a.id,c.price,b.code_product,b.name,sum(c.quantity) AS qtyp,c.disc,c.id as idp,b.id as idb,d.name as nameu')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('sales as c', 'c.id_price', '=', 'a.id')->join('unit as d', 'b.id_unit', '=', 'd.id')->where('c.id_payment','=',$id)->groupBy('a.id_product')->orderBy('b.code_product','asc')->get();
    	return response()->json($pnj);
    }
    public function tambah(Request $request){
        $cbrg = DB::table('sales')->where('id_price','=',$request->checked)->where('id_payment','=',$request->idpym)->count();
        $cbrg2 = DB::table('sales')->where('id_price','=',$request->checked)->where('id_payment','=',$request->idpym)->where('status','=',1)->count();
        if ($cbrg==0) {
            Sales::create([
                'id_price' => $request->checked,
                'id_payment' => $request->idpym,
                'status' => 1
            ]);
        }elseif ($cbrg2!=0) {
            DB::table('sales')->where('id_price','=',$request->checked)->where('id_payment','=',$request->idpym)->where('status','=',1)->delete();
        }
    }
    public function tambah2(Request $request){
        DB::table('sales')->where('id_payment','=',$request->idpympnj)->update([
            'status'=>2
        ]);
    }
    public function edthpnj($idpym,$idb){
        $epnj = DB::table('price as a')->selectRaw('a.id,c.price,b.code_product,b.name,sum(c.quantity) AS qtyp,c.disc,c.id as idp,b.id as idb,c.id_payment')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('sales as c', 'c.id_price', '=', 'a.id')->where('c.id_payment','=',$idpym)->where('b.id','=',$idb)->get();
        return view('history/edt_penjualan', ['epnj' => $epnj]);
    }
    public function medthpnj(Request $request){
        $hrgj = $hrgj = str_replace(".", "", $request->mhjhpnj);
        $qty = DB::table('sales as a')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$request->midpymhpnj)->where('b.id_product','=',$request->midbhpnj)->sum('a.quantity');
        if ($request->mqtyhpnj>$qty) {
            $slsh = $request->mqtyhpnj-$qty;
            $vhrg = DB::table('price')->where('id_product','=',$request->midbhpnj)->where('quantity','>',0)->orderBy('created_at','ASC')->get();
            $apq = [];
            foreach ($vhrg as $v) {
                array_push($apq, $v->quantity);
                $japq = array_sum($apq);
                if ($japq>=$slsh) {
                    $vhrg2 = DB::table('price')->where('id_product','=',$request->midbhpnj)->where('quantity','>',0)->where('created_at','<=',$v->created_at)->orderBy('created_at','ASC')->get();
                    foreach ($vhrg2 as $v2) {
                        $ctrs = DB::table('sales')->where('id_price','=',$v2->id)->where('id_payment','=',$request->midpymhpnj)->count();
                        if ($ctrs==0) {
                            Sales::create([
                                'id_payment' => $request->midpymhpnj,
                                'id_price' => $v2->id,
                                'status' => 2
                            ]);
                        }
                    }
                    $vhrg3 = DB::table('price')->where('id_product','=',$request->midbhpnj)->where('quantity','>',0)->where('created_at','<',$v->created_at)->orderBy('created_at','ASC')->get();
                    $apq2 = [];
                    foreach ($vhrg3 as $v3) {
                        array_push($apq2, $v3->quantity);
                        $sls = DB::table('sales')->where('id_price','=',$v3->id)->where('id_payment','=',$request->midpymhpnj)->get();
                        foreach ($sls as $s) {
                            $sls2 = Sales::find($s->id);
                            $sls2->quantity = $sls2->quantity+$v3->quantity;
                            $sls2->save();
                        }
                    }
                    $japq2 = array_sum($apq2);
                    $sls5 = DB::table('sales as a')->select('a.id')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$request->midpymhpnj)->where('b.id','=',$v->id)->get();
                    foreach ($sls5 as $s5) {
                        $sls6 = Sales::find($s5->id);
                        $sls6->quantity = $sls6->quantity+$slsh-$japq2;
                        $sls6->save();
                    }
                    $vhrg4 = DB::table('price')->where('id_product','=',$request->midbhpnj)->where('created_at','<',$v->created_at)->orderBy('created_at','ASC')->get();
                    foreach ($vhrg4 as $v4) {
                        $hrg = Barang_harga::find($v4->id);
                        $hrg->quantity = 0;
                        $hrg->save();
                    }
                    $hrg2 = Barang_harga::find($v->id);
                    $hrg2->quantity = $japq-$slsh;
                    $hrg2->save();
                    $sls3 = DB::table('sales as a')->select('a.id')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$request->midpymhpnj)->where('b.id_product','=',$request->midbhpnj)->get();
                    foreach ($sls3 as $s3) {
                        $sls4 = Sales::find($s3->id);
                        $sls4->price = $hrgj;
                        $sls4->disc = $request->mdischpnj;
                        $sls4->save();
                    }
                    DB::table('price')->where('id_product','=',$request->midbhpnj)->update([
                        'selling'=>$hrgj
                    ]);
                    break;
                }
            }
        }elseif ($request->mqtyhpnj<$qty) {
            $slsh = $qty-$request->mqtyhpnj;
            $vhrg = DB::table('sales as a')->select('a.quantity','a.id','a.id_price')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$request->midbhpnj)->where('a.id_payment','=',$request->midpymhpnj)->orderBy('a.id','DESC')->get();
            $apq = [];
            foreach ($vhrg as $v) {
                array_push($apq, $v->quantity);
                $japq = array_sum($apq);
                if ($japq>=$slsh) {
                    $vhrg2 = DB::table('sales as a')->select('a.quantity','a.id','a.id_price')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$request->midbhpnj)->where('a.id','>',$v->id)->where('id_payment','=',$request->midpymhpnj)->orderBy('id','DESC')->get();
                    $apq2 = [];
                    foreach ($vhrg2 as $v2) {
                        array_push($apq2, $v2->quantity);
                        $hrg = Barang_harga::find($v2->id_price);
                        $hrg->quantity = $hrg->quantity+$v2->quantity;
                        $hrg->save();
                        $sls = Sales::find($v2->id);
                        $sls->delete();
                    }
                    $japq2 = array_sum($apq2);
                    $hrg2 = Barang_harga::find($v->id_price);
                    $hrg2->quantity = $hrg2->quantity+$slsh-$japq2;
                    $hrg2->save();
                    $sls2 = Sales::find($v->id);
                    $qty2 = $sls2->quantity-$slsh+$japq2;
                    if ($qty2==0) {
                        $sls2->delete();
                    }else{
                        $sls2->quantity = $qty2;
                        $sls2->save();
                    }
                    $sls3 = DB::table('sales as a')->select('a.id')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$request->midpymhpnj)->where('b.id_product','=',$request->midbhpnj)->get();
                    foreach ($sls3 as $s3) {
                        $sls4 = Sales::find($s3->id);
                        $sls4->price = $hrgj;
                        $sls4->disc = $request->mdischpnj;
                        $sls4->save();
                    }
                    DB::table('price')->where('id_product','=',$request->midbhpnj)->update([
                        'selling'=>$hrgj
                    ]);
                    break;
                }
            }
        }else{
            $vhrg = DB::table('sales as a')->select('a.id')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$request->midbhpnj)->where('a.id_payment','=',$request->midpymhpnj)->get();
            foreach ($vhrg as $v) {
                $sls = Sales::find($v->id);
                $sls->price = $hrgj;
                $sls->disc = $request->mdischpnj;
                $sls->save();
            }
            DB::table('price')->where('id_product','=',$request->midbhpnj)->update([
                'selling'=>$hrgj
            ]);
        }
    }
    public function delhpnj($idpym,$idb){
        $prc = DB::table('sales as a')->select('b.id','a.quantity','a.id as ids')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$idpym)->where('b.id_product','=',$idb)->get();
        $hrg = Barang_harga::where('id_product','=',$idb)->orderBy('id', 'DESC')->take(1)->get();
        foreach ($hrg as $h) {
            $hrgbrg = $h['selling'];
        }
        foreach ($prc as $p) {
            $hrg = Barang_harga::find($p->id);
            $hrg->quantity = $hrg->quantity+$p->quantity;
            $hrg->selling = $hrgbrg;
            $hrg->save();
            $sls = Sales::find($p->ids);
            $sls->delete();
        }
    }
    public function inshtpnj(Request $request){
        $sls = Transaksi::find($request->idpympnj);
        $sls->total_payment = $request->sttlhpnj;
        $sls->save();
    }
    public function fh_pembelian(){
        $hst = DB::table('purchases_payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name','c.name as namests')->join('supplier as b', 'a.id_supplier', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->whereDate('a.created_at','=',date('Y-m-d'))->orderBy('a.created_at','ASC')->get();
        return view('history/fpembelian', ['hst' => $hst]);
    }
    public function h_pembelian(Request $request){
        $tgl1 = date('Y-m-d', strtotime($request->tglhst1));
        $tgl2 = date('Y-m-d', strtotime($request->tglhst2));
        $hst = DB::table('purchases_payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name','c.name as namests')->join('supplier as b', 'a.id_supplier', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->whereRaw('(a.created_at >= ? AND a.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->orderBy('a.created_at','ASC')->get();
        return view('history/pembelian', ['hst' => $hst]);
    }
    public function e_pembelian($id){
    	$pym = DB::table('purchases_payment as a')->select('a.created_at','a.due_date','a.invoice','b.name','a.id','b.id as idspl')->join('supplier as b', 'a.id_supplier', '=', 'b.id')->where('a.id','=',$id)->get();
    	$brg = DB::table('product_name as a')->select('a.id','a.code_product','a.name')->orderBy('a.name')->get();
        return view('history/e_pembelian', ['brg' => $brg, 'pym' => $pym]);
    }
    public function t_pembelian($id){
        $pmb = DB::table('price as a')->select('a.id','a.capital','a.selling','b.code_product','b.name','a.quantity','c.disc','c.quantity as qtyp','c.id as idp','d.name as nameu')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('purchases as c', 'c.id_price', '=', 'a.id')->join('unit as d', 'b.id_unit', '=', 'd.id')->where('c.id_payment','=',$id)->orderBy('b.name','asc')->get();
        return response()->json($pmb);
    }
    public function edthpmb($id){
        $epmb = DB::table('price as a')->select('a.id','a.capital','a.selling','b.code_product','b.name','a.quantity','c.disc','c.quantity as qtyp','c.id as idp')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('purchases as c', 'c.id_price', '=', 'a.id')->where('c.id','=',$id)->get();
        return view('history/edt_pembelian', ['epmb' => $epmb]);
    }
    public function medthpmb(Request $request){
        $prc = Purchases::find($request->midpmb);
        if ($request->mqtyhpmb>$prc->quantity) {
            $slsh=$request->mqtyhpmb-$prc->quantity;
            $prc->quantity = $request->mqtyhpmb;
            $prc->disc = $request->mdischpmb;
            $hrg = Barang_harga::find($prc->id_price);
            $hrgb = str_replace(".", "", $request->mhjbpmb);
            $hrg->capital = $hrgb;
            $hrg->quantity = $hrg->quantity+$slsh;
            $hrg->weight = $request->mwghpmb;
            $hrg->save();
            $prc->save();
        }elseif ($request->mqtyhpmb<$prc->quantity) {
            $slsh=$prc->quantity-$request->mqtyhpmb;
            $prc->quantity = $request->mqtyhpmb;
            $prc->disc = $request->mdischpmb;
            $hrg = Barang_harga::find($prc->id_price);
            $hrgb = str_replace(".", "", $request->mhjbpmb);
            $hrg->capital = $hrgb;
            $hrg->quantity = $hrg->quantity-$slsh;
            $hrg->weight = $request->mwghpmb;
            $hrg->save();
            $prc->save();
        }else{
            $prc->disc = $request->mdischpmb;
            $hrg = Barang_harga::find($prc->id_price);
            $hrgb = str_replace(".", "", $request->mhjbpmb);
            $hrg->capital = $hrgb;
            $hrg->weight = $request->mwghpmb;
            $hrg->save();
            $prc->save();
        }
    }
    public function tambahpmb(Request $request){
        $cbrg = DB::table('purchases as a')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$request->idpym)->where('b.id_product','=',$request->checked)->count();
        $cbrg2 = DB::table('purchases as a')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$request->idpym)->where('b.id_product','=',$request->checked)->where('a.status','=',1)->count();
        if ($cbrg==0) {
            Barang_harga::create([
                'id_product' => $request->checked
            ]);
            $hrg = Barang_harga::orderBy('id', 'DESC')->take(1)->get();
            foreach ($hrg as $h) {
                $idhrg = $h['id'];
            }
            Purchases::create([
                'id_price' => $idhrg,
                'id_payment' => $request->idpym,
                'status' => 1
            ]);
        }elseif ($cbrg2!=0) {
            $id = DB::table('purchases as a')->select('a.id','b.id as idh')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$request->checked)->where('a.id_payment','=',$request->idpym)->where('a.status','=',1)->get();
            foreach ($id as $i) {
                $hrg2 = Barang_harga::find($i->idh);
                $hrg2->delete();
                $prc = Purchases::find($i->id);
                $prc->delete();
            }
        }
    }
    public function tambahpmb2(Request $request){
        DB::table('purchases')->where('id_payment','=',$request->idpympmb)->update([
            'status'=>2
        ]);
    }
    public function delhpmb($id){
        $prc = Purchases::find($id);
        $hrg = Barang_harga::find($prc->id_price);
        $hrg->delete();
        $prc->delete();
    }
    public function inshtpmb(Request $request){
        $prc = PurchasesPayment::find($request->idpympmb);
        $prc->total_payment = $request->sttlhpmb;
        $prc->save();
    }
    public function fdh_penjualan(){
        return view('history/fdpenjualan');
    }
    public function dh_penjualan(Request $request){
        $tgl1 = date('Y-m-d', strtotime($request->tglhst1));
        $tgl2 = date('Y-m-d', strtotime($request->tglhst2));
        $hst = DB::table('sales as a')->selectRaw('b.created_at,b.invoice,b.due_date,b.total_payment,f.name as namecus,g.name as namests,h.name as namesls,a.disc,sum(a.quantity) as qty,a.price,d.code_product,d.name as namebrg,e.name as nameu')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('unit as e', 'd.id_unit', '=', 'e.id')->join('customer as f', 'b.id_customer', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->join('sales_user as h', 'b.id_salesuser', '=', 'h.id')->whereRaw('(b.created_at >= ? AND b.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->groupBy('b.id','d.id')->orderBy('b.created_at','asc')->orderBy('d.name','asc')->get();
        return view('history/dpenjualan', ['hst' => $hst]);
    }
    public function fdh_pembelian(){
        return view('history/fdpembelian');
    }
    public function dh_pembelian(Request $request){
        $tgl1 = date('Y-m-d', strtotime($request->tglhst1));
        $tgl2 = date('Y-m-d', strtotime($request->tglhst2));
        $hst = DB::table('purchases as a')->select('g.name as namests','b.due_date','b.invoice','b.created_at','e.name as namespl','d.code_product','d.name as namebrg','f.name as nameu','a.quantity','c.capital','a.disc')->join('purchases_payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('supplier as e', 'c.id_supplier', '=', 'e.id')->join('unit as f', 'd.id_unit', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->whereRaw('(b.created_at >= ? AND b.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->orderBy('b.created_at','ASC')->orderBy('d.name','ASC')->get();
        return view('history/dpembelian', ['hst' => $hst]);
    }
    public function h_supplier($id){
        $hst = DB::table('purchases as a')->select('g.name as namests','b.invoice','b.created_at','e.name as namespl','d.code_product','d.name as namebrg','f.name as nameu','a.quantity','c.capital','a.disc')->join('purchases_payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('supplier as e', 'b.id_supplier', '=', 'e.id')->join('unit as f', 'd.id_unit', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->where('b.id_supplier','=',$id)->orderBy('b.created_at','ASC')->orderBy('d.name','ASC')->get();
        return view('history/supplier', ['hst' => $hst]);
    }
    public function h_customer($id){
        $hst = DB::table('sales as a')->selectRaw('a.disc,sum(a.quantity) as qty,a.price,b.created_at,b.invoice,f.name as namecus,d.code_product,d.name as namebrg,e.name as nameu')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('unit as e', 'd.id_unit', '=', 'e.id')->join('customer as f', 'b.id_customer', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->join('sales_user as h', 'b.id_salesuser', '=', 'h.id')->where('b.id_customer','=',$id)->groupBy('b.id','d.id')->orderBy('b.created_at','asc')->orderBy('d.name','asc')->get();
        return view('history/customer', ['hst' => $hst]);
    }
    public function h_sales($id){
        $hst = DB::table('sales as a')->selectRaw('a.disc,sum(a.quantity) as qty,a.price,b.created_at,b.invoice,h.name as namesls,d.code_product,d.name as namebrg,e.name as nameu')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('unit as e', 'd.id_unit', '=', 'e.id')->join('customer as f', 'b.id_customer', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->join('sales_user as h', 'b.id_salesuser', '=', 'h.id')->where('b.id_salesuser','=',$id)->groupBy('b.id','d.id')->orderBy('b.created_at','asc')->orderBy('d.name','asc')->get();
        return view('history/sales', ['hst' => $hst]);
    }
    public function h_brgpmb($id){
        $hst = DB::table('purchases as a')->select('g.name as namests','b.invoice','b.created_at','e.name as namespl','d.code_product','d.name as namebrg','f.name as nameu','a.quantity','c.capital','a.disc')->join('purchases_payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('supplier as e', 'b.id_supplier', '=', 'e.id')->join('unit as f', 'd.id_unit', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->where('d.id','=',$id)->orderBy('b.created_at','ASC')->orderBy('d.name','ASC')->get();
        return view('history/brgpmb', ['hst' => $hst]);
    }
    public function h_brgpnj($id){
        $hst = DB::table('sales as a')->selectRaw('a.disc,sum(a.quantity) as qty,a.price,b.created_at,b.invoice,f.name as namecus,h.name as namesls,d.code_product,d.name as namebrg,e.name as nameu')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('unit as e', 'd.id_unit', '=', 'e.id')->join('customer as f', 'b.id_customer', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->join('sales_user as h', 'b.id_salesuser', '=', 'h.id')->where('d.id','=',$id)->groupBy('b.id','d.id')->orderBy('b.created_at','asc')->orderBy('d.name','asc')->get();
        return view('history/brgpnj', ['hst' => $hst]);
    }
    public function invpnj($id){
        $sls = DB::table('payment as a')->select('a.invoice','b.name as namecus','a.created_at','a.due_date','b.address','c.code_sales','b.city','b.telp','a.total_payment')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('sales_user as c', 'a.id_salesuser', '=', 'c.id')->where('a.id','=',$id)->get();
        $stg = DB::table('setting_inv')->where('id','=',1)->get();
        $brg = DB::table('sales as a')->selectRaw('c.code_product,c.name as nameprod,sum(a.quantity) AS qtyp,d.name as nameu,a.price,a.disc')->join('price as b', 'a.id_price', '=', 'b.id')->join('product_name as c', 'b.id_product', '=', 'c.id')->join('unit as d', 'c.id_unit', '=', 'd.id')->where('a.id_payment','=',$id)->groupBy('b.id_product')->orderBy('c.code_product','asc')->get();
        $jds = DB::table('sales as a')->selectRaw('(a.price*sum(a.quantity))*(a.disc/100) as jml')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$id)->groupBy('b.id_product')->get();
        $jdis=[];
        foreach ($jds as $j) {
            array_push($jdis, round($j->jml));
        }
        $jdisc = array_sum($jdis);
        $customPaper = array(0,0,396.85,609.44);
        $pdf = PDF::loadview('history/invpnj',['sls'=>$sls, 'brg'=>$brg, 'stg'=>$stg, 'jdisc'=>$jdisc])->setPaper($customPaper, 'landscape');
        return $pdf->stream();
    }
}
