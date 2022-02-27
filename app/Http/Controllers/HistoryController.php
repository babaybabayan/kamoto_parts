<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;
use App\Models\Barang_harga;
use App\Models\Purchases;
use App\Models\Transaksi;
use App\Models\PurchasesPayment;
use App\Models\H_sales;
use App\Models\H_purchases;
use PDF;

class HistoryController extends Controller{
    public function fh_penjualan(){
        $year = date('Y');
        $month = date('m');
        $hst = DB::table('payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name as namecus','c.name as namests','d.name as namesls')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->join('sales_user as d', 'a.id_salesuser', '=', 'd.id')->whereYear('a.created_at','=',$year)->whereMonth('a.created_at', '=', $month)->orderBy('a.created_at','ASC')->get();
        return view('history/fpenjualan', ['hst' => $hst]);
    }
    public function rh_penjualan(Request $request){
        $tgl1 = date('Y-m-d', strtotime($request->tglhst1));
        $tgl2 = date('Y-m-d', strtotime($request->tglhst2));
        return redirect('/hst/pnj/'.$tgl1.'/'.$tgl2);
    }
    public function h_penjualan($tgl1,$tgl2){
        $hst = DB::table('payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name as namecus','c.name as namests','d.name as namesls')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->join('sales_user as d', 'a.id_salesuser', '=', 'd.id')->whereRaw('(a.created_at >= ? AND a.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->orderBy('a.created_at','ASC')->get();
        return view('history/penjualan', ['hst' => $hst,'tgl1' => $tgl1,'tgl2' => $tgl2]);
    }
    public function e_penjualan($id,$tglaw,$tglak){
    	$pym = DB::table('payment as a')->select('a.created_at','a.due_date','a.invoice','b.name as namecus','c.name as namesls','a.id','b.id as idcus','c.id as idsls')->join('customer as b', 'a.id_customer', '=', 'b.id')->join('sales_user as c', 'a.id_salesuser', '=', 'c.id')->where('a.id','=',$id)->get();
        $ch = DB::table('h_sales')->where('id_payment','=',$id)->count();
        if ($ch==0) {
            DB::table('h_sales')->truncate();
            $sls = DB::table('sales as a')->selectRaw('a.id_payment,b.id_product,sum(a.quantity) as qty,a.price,a.disc,a.status')->join('price as b', 'a.id_price', '=', 'b.id')->where('id_payment','=',$id)->groupBy('b.id_product')->orderBy('a.created_at','asc')->get();
            foreach ($sls as $s) {
                H_sales::create([
                    'id_payment' => $s->id_payment,
                    'id_product' => $s->id_product,
                    'quantity' => $s->qty,
                    'price' => $s->price,
                    'disc' => $s->disc,
                    'status' => $s->status
                ]);
            }
        }
        return view('history/e_penjualan', ['pym' => $pym,'tglaw' => $tglaw,'tglak' => $tglak]);
    }
    public function t_penjualan($id){
        $pnj = DB::table('h_sales as a')->select('a.price','b.code_product','b.name','a.quantity AS qtyp','a.disc','a.id as idp','b.id as idb','c.name as nameu','a.id_payment')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('unit as c', 'b.id_unit', '=', 'c.id')->where('a.id_payment','=',$id)->orderBy('a.created_at','desc')->get();
    	return response()->json($pnj);
    }
    public function tmbrgpnj($id,$idpym,$idcus){
        $code = strtok($id, ' ');
        $fill = DB::table('price as a')->select('a.id','a.id_product')->join('product_name as b', 'a.id_product', '=', 'b.id')->where('b.code_product', '=', $code)->where('a.quantity','>',0)->orderBy('a.id','ASC')->take(1)->get();
        foreach ($fill as $f) {
            $cbrg = DB::table('sales')->where('id_price','=',$f->id)->where('id_payment','=',$idpym)->count();
            if ($cbrg==0) {
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
                    'id_payment' => $idpym,
                    'price' => $sellinglast,
                    'status' => 2
                ]);
                H_sales::create([
                    'id_product' => $f->id_product,
                    'id_payment' => $idpym,
                    'price' => $sellinglast,
                    'status' => 2
                ]);
            }
        }
    }
    public function qtyhpnj(Request $request){
        $prc = H_sales::find($request->id);
        $prc->quantity = $request->qty;
        $prc->save();
    }
    public function hrghpnj(Request $request){
        $prc = H_sales::find($request->id);
        $prc->price = $request->hrg;
        $prc->save();
    }
    public function dishpnj(Request $request){
        $prc = H_sales::find($request->id);
        $prc->disc = $request->dis;
        $prc->save();
    }
    public function hrgmhpnj($ids,$idb,$idcus){
        $hst = DB::table('sales as a')->select('b.created_at','a.price','a.id')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('c.id_product','=',$idb)->where('b.id_customer', '=', $idcus)->groupBy('b.id')->orderBy('b.created_at','DESC')->get();
        return view('history/hrgmhpnj', ['hsthrg' => $hst,'ids' => $ids]);
    }
    public function edthrgmhpnj($idh, Request $request){
        $sls = Sales::find($idh);
        $sls2 = H_sales::find($request->ids);
        $sls2->price = $sls->price;
        $sls2->save();
    }
    public function delhpnj($idp){
        $hs = H_sales::find($idp);
        $prc = DB::table('sales as a')->select('b.id','a.quantity','a.id as ids')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$hs->id_payment)->where('b.id_product','=',$hs->id_product)->get();
        foreach ($prc as $p) {
            $hrg = Barang_harga::find($p->id);
            $hrg->quantity = $hrg->quantity+$p->quantity;
            $hrg->save();
            $sls = Sales::find($p->ids);
            $sls->delete();
        }
        $hs->delete();
    }
    public function inshtpnj(Request $request){
        $hs = DB::table('h_sales')->where('id_payment','=',$request->idpympnj)->get();
        foreach ($hs as $h) {
            $qty = DB::table('sales as a')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$h->id_payment)->where('b.id_product','=',$h->id_product)->sum('a.quantity');
            if ($h->quantity>$qty) {
                $slsh = $h->quantity-$qty;
                $vhrg = DB::table('price')->where('id_product','=',$h->id_product)->where('quantity','>',0)->orderBy('created_at','ASC')->get();
                $apq = [];
                foreach ($vhrg as $v) {
                    array_push($apq, $v->quantity);
                    $japq = array_sum($apq);
                    if ($japq>=$slsh) {
                        $vhrg2 = DB::table('price')->where('id_product','=',$h->id_product)->where('quantity','>',0)->where('created_at','<=',$v->created_at)->orderBy('created_at','ASC')->get();
                        foreach ($vhrg2 as $v2) {
                            $ctrs = DB::table('sales')->where('id_price','=',$v2->id)->where('id_payment','=',$h->id_payment)->count();
                            if ($ctrs==0) {
                                Sales::create([
                                    'id_payment' => $h->id_payment,
                                    'id_price' => $v2->id,
                                    'status' => 2
                                ]);
                            }
                        }
                        $vhrg3 = DB::table('price')->where('id_product','=',$h->id_product)->where('quantity','>',0)->where('created_at','<',$v->created_at)->orderBy('created_at','ASC')->get();
                        $apq2 = [];
                        foreach ($vhrg3 as $v3) {
                            array_push($apq2, $v3->quantity);
                            $sls = DB::table('sales')->where('id_price','=',$v3->id)->where('id_payment','=',$h->id_payment)->get();
                            foreach ($sls as $s) {
                                $sls2 = Sales::find($s->id);
                                $sls2->quantity = $sls2->quantity+$v3->quantity;
                                $sls2->save();
                            }
                        }
                        $japq2 = array_sum($apq2);
                        $sls5 = DB::table('sales as a')->select('a.id')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$h->id_payment)->where('b.id','=',$v->id)->get();
                        foreach ($sls5 as $s5) {
                            $sls6 = Sales::find($s5->id);
                            $sls6->quantity = $sls6->quantity+$slsh-$japq2;
                            $sls6->save();
                        }
                        $vhrg4 = DB::table('price')->where('id_product','=',$h->id_product)->where('created_at','<',$v->created_at)->orderBy('created_at','ASC')->get();
                        foreach ($vhrg4 as $v4) {
                            $hrg = Barang_harga::find($v4->id);
                            $hrg->quantity = 0;
                            $hrg->save();
                        }
                        $hrg2 = Barang_harga::find($v->id);
                        $hrg2->quantity = $japq-$slsh;
                        $hrg2->save();
                        $sls3 = DB::table('sales as a')->select('a.id')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$h->id_payment)->where('b.id_product','=',$h->id_product)->get();
                        foreach ($sls3 as $s3) {
                            $sls4 = Sales::find($s3->id);
                            $sls4->price = $h->price;
                            $sls4->disc = $h->disc;
                            $sls4->save();
                        }
                        $jprice = DB::table('sales as a')->select('c.id')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('b.id_customer','=',$request->idcushpnj)->where('c.id_product','=',$h->id_product)->get();
                        foreach ($jprice as $jp) {
                            DB::table('price')->where('id','=',$jp->id)->update([
                                'selling'=>$h->price
                            ]);
                        }
                        break;
                    }
                }
            }elseif ($h->quantity<$qty) {
                $slsh = $qty-$h->quantity;
                $vhrg = DB::table('sales as a')->select('a.quantity','a.id','a.id_price')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$h->id_product)->where('a.id_payment','=',$h->id_payment)->orderBy('a.id','DESC')->get();
                $apq = [];
                foreach ($vhrg as $v) {
                    array_push($apq, $v->quantity);
                    $japq = array_sum($apq);
                    if ($japq>=$slsh) {
                        $vhrg2 = DB::table('sales as a')->select('a.quantity','a.id','a.id_price')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$h->id_product)->where('a.id','>',$v->id)->where('id_payment','=',$h->id_payment)->orderBy('id','DESC')->get();
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
                        $sls3 = DB::table('sales as a')->select('a.id')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$h->id_payment)->where('b.id_product','=',$h->id_product)->get();
                        foreach ($sls3 as $s3) {
                            $sls4 = Sales::find($s3->id);
                            $sls4->price = $h->price;
                            $sls4->disc = $h->disc;
                            $sls4->save();
                        }
                        $jprice = DB::table('sales as a')->select('c.id')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('b.id_customer','=',$request->idcushpnj)->where('c.id_product','=',$h->id_product)->get();
                        foreach ($jprice as $jp) {
                            DB::table('price')->where('id','=',$jp->id)->update([
                                'selling'=>$h->price
                            ]);
                        }
                        break;
                    }
                }
            }else{
                $vhrg = DB::table('sales as a')->select('a.id')->join('price as b', 'a.id_price', '=', 'b.id')->where('b.id_product','=',$h->id_product)->where('a.id_payment','=',$h->id_payment)->get();
                foreach ($vhrg as $v) {
                    $sls = Sales::find($v->id);
                    $sls->price = $h->price;
                    $sls->disc = $h->disc;
                    $sls->save();
                }
                $jprice = DB::table('sales as a')->select('c.id')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('b.id_customer','=',$request->idcushpnj)->where('c.id_product','=',$h->id_product)->get();
                foreach ($jprice as $jp) {
                    DB::table('price')->where('id','=',$jp->id)->update([
                        'selling'=>$h->price
                    ]);
                }
            }
        }
        $sls = Transaksi::find($request->idpympnj);
        if (date('Y-m-d', strtotime($sls->created_at))!=date('Y-m-d', strtotime($request->duedate))) {
            $sts=2;
        }else{
            $sts=1;
        }
        $sls->total_payment = $request->sttlhpnj;
        $sls->due_date = date('Y-m-d', strtotime($request->duedate));
        $sls->id_status = $sts;
        $sls->save();
        DB::table('h_sales')->truncate();
    }
    public function fh_pembelian(){
        $year = date('Y');
        $month = date('m');
        $hst = DB::table('purchases_payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name','c.name as namests')->join('supplier as b', 'a.id_supplier', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->whereYear('a.created_at','=',$year)->whereMonth('a.created_at', '=', $month)->orderBy('a.created_at','ASC')->get();
        return view('history/fpembelian', ['hst' => $hst]);
    }
    public function rh_pembelian(Request $request){
        $tgl1 = date('Y-m-d', strtotime($request->tglhst1));
        $tgl2 = date('Y-m-d', strtotime($request->tglhst2));
        return redirect('/hst/pmb/'.$tgl1.'/'.$tgl2);
    }
    public function h_pembelian($tgl1,$tgl2){
        $hst = DB::table('purchases_payment as a')->select('a.id','a.created_at','a.invoice','a.due_date','a.total_payment','b.name','c.name as namests')->join('supplier as b', 'a.id_supplier', '=', 'b.id')->join('status as c', 'a.id_status', '=', 'c.id')->whereRaw('(a.created_at >= ? AND a.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->orderBy('a.created_at','ASC')->get();
        return view('history/pembelian', ['hst' => $hst,'tgl1' => $tgl1,'tgl2' => $tgl2]);
    }
    public function e_pembelian($id,$tglaw,$tglak){
    	$pym = DB::table('purchases_payment as a')->select('a.created_at','a.due_date','a.invoice','b.name','a.id','b.id as idspl')->join('supplier as b', 'a.id_supplier', '=', 'b.id')->where('a.id','=',$id)->get();
        $ch = DB::table('h_purchases')->where('id_payment','=',$id)->count();
        if ($ch==0) {
            DB::table('h_purchases')->truncate();
            $sls = DB::table('purchases as a')->selectRaw('a.id_payment,a.id_price,a.quantity,b.capital,a.disc,a.status')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$id)->orderBy('a.created_at','asc')->get();
            foreach ($sls as $s) {
                H_purchases::create([
                    'id_payment' => $s->id_payment,
                    'id_price' => $s->id_price,
                    'quantity' => $s->quantity,
                    'price' => $s->capital,
                    'disc' => $s->disc,
                    'status' => $s->status
                ]);
            }
        }
        return view('history/e_pembelian', ['pym' => $pym,'tglaw' => $tglaw,'tglak' => $tglak]);
    }
    public function t_pembelian($id){
        $pmb = DB::table('price as a')->select('c.id','b.code_product','b.name','d.name as nameu','c.quantity','c.price','c.disc','b.id as idb')->join('product_name as b', 'a.id_product', '=', 'b.id')->join('h_purchases as c', 'c.id_price', '=', 'a.id')->join('unit as d', 'b.id_unit', '=', 'd.id')->where('c.id_payment','=',$id)->orderBy('c.created_at','desc')->get();
        return response()->json($pmb);
    }
    public function tmbrgpmb($id,$idpym,$idspl){
        $code = strtok($id, ' ');
        $fill = DB::table('product_name')->where('code_product', $code)->get();
        foreach ($fill as $f) {
            $cbrg = DB::table('purchases as a')->join('price as b', 'a.id_price', '=', 'b.id')->where('a.id_payment','=',$idpym)->where('b.id_product','=',$f->id)->count();
            if ($cbrg==0) {
                Barang_harga::create([
                    'id_product' => $f->id,
                    'id_supplier' => $idspl
                ]);
                $hrg = Barang_harga::orderBy('id', 'DESC')->take(1)->get();
                foreach ($hrg as $h) {
                    $idhrg = $h['id'];
                }
                Purchases::create([
                    'id_price' => $idhrg,
                    'id_payment' => $idpym,
                    'status' => 2
                ]);
                H_purchases::create([
                    'id_price' => $idhrg,
                    'id_payment' => $idpym,
                    'status' => 2
                ]);
            }
        }
    }
    public function qtyhpmb(Request $request){
        $prc = H_purchases::find($request->id);
        $prc->quantity = $request->qty;
        $prc->save();
    }
    public function hrghpmb(Request $request){
        $prc = H_purchases::find($request->id);
        $prc->price = $request->hrg;
        $prc->save();
    }
    public function dishpmb(Request $request){
        $prc = H_purchases::find($request->id);
        $prc->disc = $request->dis;
        $prc->save();
    }
    public function hrgmhpmb($idp,$idb,$idspl){
        $hst = DB::table('purchases as a')->select('b.created_at','c.capital','a.id')->join('purchases_payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->where('c.id_product','=',$idb)->where('b.id_supplier', '=', $idspl)->orderBy('b.created_at','DESC')->get();
        return view('history/hrgmhpmb', ['hsthrg' => $hst,'idp' => $idp]);
    }
    public function edthrgmhpmb($idh, Request $request){
        $prc = Purchases::find($idh);
        $hrg = Barang_harga::find($prc->id_price);
        $prc2 = H_purchases::find($request->idp);
        $prc2->price = $hrg->capital;
        $prc2->save();
    }
    public function delhpmb($id){
        $prc = H_purchases::find($id);
        $prc2 = DB::table('purchases')->where('id_payment','=',$prc->id_payment)->where('id_price','=',$prc->id_price)->get();
        foreach ($prc2 as $p) {
            $hrg = Barang_harga::find($p->id_price);
            $hrg->delete();
            $prc3 = Purchases::find($p->id);
            $prc3->delete();
        }
        $prc->delete();
    }
    public function inshtpmb(Request $request){
        $hs = DB::table('h_purchases')->where('id_payment','=',$request->idpympmb)->get();
        foreach ($hs as $h) {
            $prc = DB::table('purchases')->where('id_payment','=',$h->id_payment)->where('id_price','=',$h->id_price)->get();
            foreach ($prc as $p) {
                if ($h->quantity>$p->quantity) {
                    $slsh=$h->quantity-$p->quantity;
                    $prc2 = Purchases::find($p->id);
                    $prc2->quantity = $h->quantity;
                    $prc2->disc = $h->disc;
                    $prc2->save();
                    $hrg = Barang_harga::find($p->id_price);
                    $hrg->capital = $h->price;
                    $hrg->quantity = $hrg->quantity+$slsh;
                    $hrg->save();
                }elseif ($h->quantity<$p->quantity) {
                    $slsh=$p->quantity-$h->quantity;
                    $prc2 = Purchases::find($p->id);
                    $prc2->quantity = $h->quantity;
                    $prc2->disc = $h->disc;
                    $prc2->save();
                    $hrg = Barang_harga::find($p->id_price);
                    $hrg->capital = $h->price;
                    $hrg->quantity = $hrg->quantity-$slsh;
                    $hrg->save();
                }else{
                    $prc2 = Purchases::find($p->id);
                    $prc2->disc = $h->disc;
                    $prc2->save();
                    $hrg = Barang_harga::find($p->id_price);
                    $hrg->capital = $h->price;
                    $hrg->save();
                }
            }   
        }
        $pym = PurchasesPayment::find($request->idpympmb);
        if (date('Y-m-d', strtotime($pym->created_at))!=date('Y-m-d', strtotime($request->duedate))) {
            $sts=2;
        }else{
            $sts=1;
        }
        $pym->due_date = date('Y-m-d', strtotime($request->duedate));
        $pym->id_status = $sts;
        $pym->total_payment = $request->sttlhpmb;
        $pym->save();
        DB::table('h_purchases')->truncate();
    }
    public function fdh_penjualan(){
        $year = date('Y');
        $month = date('m');
        $hst = DB::table('sales as a')->selectRaw('b.created_at,b.invoice,b.due_date,b.total_payment,f.name as namecus,g.name as namests,h.name as namesls,a.disc,sum(a.quantity) as qty,a.price,d.code_product,d.name as namebrg,e.name as nameu')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('unit as e', 'd.id_unit', '=', 'e.id')->join('customer as f', 'b.id_customer', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->join('sales_user as h', 'b.id_salesuser', '=', 'h.id')->whereYear('b.created_at','=',$year)->whereMonth('b.created_at', '=', $month)->groupBy('b.id','d.id')->orderBy('b.created_at','asc')->orderBy('d.name','asc')->get();
        return view('history/fdpenjualan', ['hst' => $hst]);
    }
    public function dh_penjualan(Request $request){
        $tgl1 = date('Y-m-d', strtotime($request->tglhst1));
        $tgl2 = date('Y-m-d', strtotime($request->tglhst2));
        $hst = DB::table('sales as a')->selectRaw('b.created_at,b.invoice,b.due_date,b.total_payment,f.name as namecus,g.name as namests,h.name as namesls,a.disc,sum(a.quantity) as qty,a.price,d.code_product,d.name as namebrg,e.name as nameu')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('unit as e', 'd.id_unit', '=', 'e.id')->join('customer as f', 'b.id_customer', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->join('sales_user as h', 'b.id_salesuser', '=', 'h.id')->whereRaw('(b.created_at >= ? AND b.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->groupBy('b.id','d.id')->orderBy('b.created_at','asc')->orderBy('d.name','asc')->get();
        return view('history/dpenjualan', ['hst' => $hst]);
    }
    public function fdh_pembelian(){
        $year = date('Y');
        $month = date('m');
        $hst = DB::table('purchases as a')->select('g.name as namests','b.due_date','b.invoice','b.created_at','e.name as namespl','d.code_product','d.name as namebrg','f.name as nameu','a.quantity','c.capital','a.disc')->join('purchases_payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('supplier as e', 'c.id_supplier', '=', 'e.id')->join('unit as f', 'd.id_unit', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->whereYear('b.created_at','=',$year)->whereMonth('b.created_at', '=', $month)->orderBy('b.created_at','ASC')->orderBy('d.name','ASC')->get();
        return view('history/fdpembelian', ['hst' => $hst]);
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
