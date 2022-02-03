<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SalesUserController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SettingInvController;

Route::get('/', function () {
    return redirect('/home');
});
Route::get('/home', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/stg', [SettingInvController::class, 'index']);
Route::put('/stg/ubah/{id}', [SettingInvController::class, 'ubah']);

Route::get('/brg', [BarangController::class, 'index']);
Route::post('/brg/tmb', [BarangController::class, 'tambah']);
Route::put('/brg/ubah/{id_brg}', [BarangController::class, 'ubah']);
Route::get('/brg/sat', [UnitController::class, 'index']);
Route::post('/brg/sat/tmb', [UnitController::class, 'tambah']);
Route::put('/brg/sat/ubah/{id}', [UnitController::class, 'ubah']);
Route::get('/sld', [BarangController::class, 'saldo']);
Route::get('/psd', [BarangController::class, 'persediaan']);

Route::get('/spl', [SupplierController::class, 'index']);
Route::post('/spl/tmb', [SupplierController::class, 'tambah']);
Route::put('/spl/ubah/{id_spl}', [SupplierController::class, 'ubah']);
Route::get('/spl/namesplpmb', [SupplierController::class, 'load_namesplpmb']);
Route::get('/spl/getidsplpmb/{id}', [SupplierController::class, 'getidsplpmb']);

Route::get('/cus', [CustomerController::class, 'index']);
Route::post('/cus/tmb', [CustomerController::class, 'tambah']);
Route::put('/cus/ubah/{id_cus}', [CustomerController::class, 'ubah']);
Route::get('/cus/namecus', [CustomerController::class, 'load_cus']);
Route::get('/cus/getidcus/{id}', [CustomerController::class, 'getidcus']);

Route::get('/sls', [SalesUserController::class, 'index']);
Route::post('/sls/tmb', [SalesUserController::class, 'tambah']);
Route::put('/sls/ubah/{id_sls}', [SalesUserController::class, 'ubah']);
Route::get('/sls/namesls', [SalesUserController::class, 'load_sls']);
Route::get('/sls/getidsls/{id}', [SalesUserController::class, 'getidsls']);

Route::get('/trs/pnj', [TransaksiController::class, 'penjualan']);
Route::get('/trs/pnj/data', [TransaksiController::class, 'data_penjualan']);
Route::post('/trs/pnj/qtypnj', [TransaksiController::class, 'qtypnj']);
Route::post('/trs/pnj/hrgpnj', [TransaksiController::class, 'hrgpnj']);
Route::post('/trs/pnj/dispnj', [TransaksiController::class, 'dispnj']);
Route::post('/trs/pnj/tmbprc', [TransaksiController::class, 'tambah']);
Route::get('/trs/pnj/delprc/{id}', [TransaksiController::class, 'delprc']);
Route::post('/trs/pnj/inspympnj', [TransaksiController::class, 'inspympnj']);
Route::post('/trs/pnj/inspnj', [TransaksiController::class, 'inspnj']);
Route::get('/trs/pnj/inv', [TransaksiController::class, 'invpnj']);
Route::get('/trs/pmb', [TransaksiController::class, 'pembelian']);
Route::get('/trs/pmb/data', [TransaksiController::class, 'data_pembelian']);
Route::post('/trs/pmb/qtypmb', [TransaksiController::class, 'qtypmb']);
Route::post('/trs/pmb/hrgpmb', [TransaksiController::class, 'hrgpmb']);
Route::post('/trs/pmb/dispmb', [TransaksiController::class, 'dispmb']);
Route::post('/trs/pmb/brtpmb', [TransaksiController::class, 'brtpmb']);
Route::post('/trs/pmb/tmbprc', [TransaksiController::class, 'insprc']);
Route::get('/trs/pmb/delprc/{id}/{qty}', [TransaksiController::class, 'delprcpmb']);
Route::post('/trs/pmb/inspym', [TransaksiController::class, 'inspympmb']);
Route::post('/trs/pmb/inspmb', [TransaksiController::class, 'inspmb']);

Route::get('/hst/fpnj', [HistoryController::class, 'fh_penjualan']);
Route::post('/hst/pnj', [HistoryController::class, 'h_penjualan']);
Route::get('/hst/epnj/{id}', [HistoryController::class, 'e_penjualan']);
Route::get('/hst/epnj/data/{id}', [HistoryController::class, 't_penjualan']);
Route::post('/hst/epnj/tmbprc', [HistoryController::class, 'tambah']);
Route::post('/hst/epnj/tmbprc2', [HistoryController::class, 'tambah2']);
Route::get('/hst/epnj/edthpnj/{idpym}/{idb}', [HistoryController::class, 'edthpnj']);
Route::post('/hst/epnj/edtmhpnj', [HistoryController::class, 'medthpnj']);
Route::get('/hst/epnj/delhpnj/{idpym}/{idb}', [HistoryController::class, 'delhpnj']);
Route::post('/hst/epnj/inshtpnj', [HistoryController::class, 'inshtpnj']);
Route::post('/hst/epnj/inshpnj', [HistoryController::class, 'inshpnj']);
Route::get('/hst/epnj/inv/{id}', [HistoryController::class, 'invpnj']);
Route::get('/hst/fpmb', [HistoryController::class, 'fh_pembelian']);
Route::post('/hst/pmb', [HistoryController::class, 'h_pembelian']);
Route::get('/hst/epmb/{id}', [HistoryController::class, 'e_pembelian']);
Route::get('/hst/epmb/data/{id}', [HistoryController::class, 't_pembelian']);
Route::post('/hst/epmb/tmbprc', [HistoryController::class, 'tambahpmb']);
Route::post('/hst/epmb/tmbprc2', [HistoryController::class, 'tambahpmb2']);
Route::get('/hst/epmb/edthpmb/{id}', [HistoryController::class, 'edthpmb']);
Route::post('/hst/epmb/edtmhpmb', [HistoryController::class, 'medthpmb']);
Route::get('/hst/epmb/delhpmb/{id}', [HistoryController::class, 'delhpmb']);
Route::post('/hst/epmb/inshtpmb', [HistoryController::class, 'inshtpmb']);
Route::post('/hst/epmb/inshpmb', [HistoryController::class, 'inshpmb']);
Route::get('/hst/fdpnj', [HistoryController::class, 'fdh_penjualan']);
Route::post('/hst/dpnj', [HistoryController::class, 'dh_penjualan']);
Route::get('/hst/fdpmb', [HistoryController::class, 'fdh_pembelian']);
Route::post('/hst/dpmb', [HistoryController::class, 'dh_pembelian']);
Route::get('/hst/spl/{id}', [HistoryController::class, 'h_supplier']);
Route::get('/hst/cus/{id}', [HistoryController::class, 'h_customer']);
Route::get('/hst/sls/{id}', [HistoryController::class, 'h_sales']);
Route::get('/hst/brgpmb/{id}', [HistoryController::class, 'h_brgpmb']);
Route::get('/hst/brgpnj/{id}', [HistoryController::class, 'h_brgpnj']);

Route::get('/rtr/frpnj', [ReturController::class, 'fr_penjualan']);
Route::post('/rtr/rpnj', [ReturController::class, 'r_penjualan']);
Route::get('/rtr/drpnj/{id}', [ReturController::class, 'dr_penjualan']);
Route::post('/rtr/drpnj/insdrpnj', [ReturController::class, 'insdrpnj']);
Route::get('/rtr/frpmb', [ReturController::class, 'fr_pembelian']);
Route::post('/rtr/rpmb', [ReturController::class, 'r_pembelian']);
Route::get('/rtr/drpmb/{id}', [ReturController::class, 'dr_pembelian']);
Route::post('/rtr/drpmb/insdrpmb', [ReturController::class, 'insdrpmb']);

Route::get('/rpt/fpnj', [ReportController::class, 'f_penjualan']);
Route::post('/rpt/hpnj', [ReportController::class, 'h_penjualan']);

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');