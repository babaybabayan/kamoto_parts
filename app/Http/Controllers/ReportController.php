<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Sales_User;


class ReportController extends Controller{
    public function f_penjualan(){
        return view('report/fpenjualan');
    }
    public function h_penjualan(Request $request){
        $csls = DB::table('sales_user')->where('id','=',$request->idslsrpt)->count();
        if ($csls==0) {
            return Redirect::back()->withErrors(['msg' => 'Nama Sales Tidak Ditemukan']);
        }else{
            $tgl1 = date('Y-m-d', strtotime($request->tgl1));
            $tgl2 = date('Y-m-d', strtotime($request->tgl2));
            $tglr1 = $request->tgl1;
            $tglr2 = $request->tgl2;
            $rpt = DB::table('sales as a')->selectRaw('b.invoice,b.created_at,f.name as namecus,b.total_payment,round(sum(a.quantity*(c.capital-(c.capital*(i.disc/100))))) as mdl')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('unit as e', 'd.id_unit', '=', 'e.id')->join('customer as f', 'b.id_customer', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->join('sales_user as h', 'b.id_salesuser', '=', 'h.id')->join('purchases as i', 'i.id_price', '=', 'c.id')->where('b.id_salesuser','=',$request->idslsrpt)->whereRaw('(b.created_at >= ? AND b.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->groupBy('b.invoice')->orderBy('b.created_at','asc')->orderBy('d.name','asc')->get();
            $sls = DB::table('sales_user')->where('id','=',$request->idslsrpt)->get()->first();
            $tcb = DB::table('payment as a')->selectRaw('round(b.quantity*(c.capital-(c.capital*(d.disc/100)))) as jml')->join('sales as b', 'b.id_payment', '=', 'a.id')->join('price as c', 'b.id_price', '=', 'c.id')->join('purchases as d', 'd.id_price', '=', 'c.id')->where('a.id_salesuser','=',$request->idslsrpt)->whereRaw('(a.created_at >= ? AND a.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->get();
            $jml=[];
            foreach ($tcb as $t) {
                array_push($jml, $t->jml);
            }
            $tmdl = array_sum($jml);
            $tpnj = DB::table('payment')->where('id_salesuser','=',$request->idslsrpt)->whereRaw('(created_at >= ? AND created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->sum('total_payment');
            return view('report/hpenjualan', ['rpt' => $rpt, 'tgl1' => $tglr1, 'tgl2' => $tglr2, 'sls' => $sls, 'tpnj' => $tpnj, 'tmdl' => $tmdl]);

        }

    }
}
