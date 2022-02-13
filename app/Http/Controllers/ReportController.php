<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Sales_User;
use PDF;

class ReportController extends Controller{
    public function f_penjualan(){
        return view('report/fpenjualan');
    }
    public function h_penjualan(Request $request){
        $csls = DB::table('sales_user')->where('id','=',$request->idsls)->count();
        if ($csls==0) {
            return Redirect::back()->withErrors(['msg' => 'Nama Sales Tidak Ditemukan']);
        }else{
            $tgl1 = date('Y-m-d', strtotime($request->tgl1));
            $tgl2 = date('Y-m-d', strtotime($request->tgl2));
            $tglr1 = $request->tgl1;
            $tglr2 = $request->tgl2;
            $rpt = DB::table('sales as a')->selectRaw('a.disc,sum(a.quantity) as qty,c.capital,a.price,b.created_at,b.invoice,f.name as namecus,d.code_product,d.name as namebrg,e.name as nameu')->join('payment as b', 'a.id_payment', '=', 'b.id')->join('price as c', 'a.id_price', '=', 'c.id')->join('product_name as d', 'c.id_product', '=', 'd.id')->join('unit as e', 'd.id_unit', '=', 'e.id')->join('customer as f', 'b.id_customer', '=', 'f.id')->join('status as g', 'b.id_status', '=', 'g.id')->join('sales_user as h', 'b.id_salesuser', '=', 'h.id')->where('b.id_salesuser','=',$request->idsls)->whereRaw('(b.created_at >= ? AND b.created_at <= ?)',[$tgl1.' 00:00:00',$tgl2.' 23:59:59'])->groupBy('b.id','d.id','c.capital')->orderBy('b.created_at','asc')->orderBy('d.name','asc')->get();
            $sls = Sales_User::find($request->idsls);
            return view('report/hpenjualan', ['rpt' => $rpt, 'tgl1' => $tglr1, 'tgl2' => $tglr2, 'sls' => $sls]);
        }

    }
}
