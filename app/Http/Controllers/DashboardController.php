<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\PurchasesPayment;
use Carbon\Carbon;

class DashboardController extends Controller{
    public function index(){
    	$year = date('Y');
    	$month = date('m');
    	$cpnj = Transaksi::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
    	$cpmb = PurchasesPayment::whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
    	$jml = Transaksi::select(\DB::raw("count(*) as count")) 
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->groupBy(\DB::raw("date(created_at)"))
                    ->pluck('count');
        $tgl = Transaksi::select(\DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as tgl')) 
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->groupBy(\DB::raw("date(created_at)"))
                    ->pluck('tgl');
        $jmlpmb = PurchasesPayment::select(\DB::raw("count(*) as count")) 
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->groupBy(\DB::raw("date(created_at)"))
                    ->pluck('count');
        $tglpmb = PurchasesPayment::select(\DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as tgl')) 
                    ->whereYear('created_at', '=', $year)
                    ->whereMonth('created_at', '=', $month)
                    ->groupBy(\DB::raw("date(created_at)"))
                    ->pluck('tgl');
        return view('dashboard', ['cpnj' => $cpnj, 'cpmb' => $cpmb], compact('jml','tgl','jmlpmb','tglpmb'));
    }
}
