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

Route::get('/stg', [SettingInvController::class, 'index'])->middleware('auth');
Route::put('/stg/ubah/{id}', [SettingInvController::class, 'ubah']);

Route::get('/brg', [BarangController::class, 'index'])->middleware('auth');
Route::post('/brg/tmb', [BarangController::class, 'tambah']);
Route::put('/brg/ubah/{id_brg}', [BarangController::class, 'ubah']);
Route::get('/brg/sat', [UnitController::class, 'index'])->middleware('auth');
Route::post('/brg/sat/tmb', [UnitController::class, 'tambah']);
Route::put('/brg/sat/ubah/{id}', [UnitController::class, 'ubah']);
Route::get('/sld', [BarangController::class, 'saldo'])->middleware('auth');
Route::get('/psd', [BarangController::class, 'persediaan'])->middleware('auth');
Route::get('/brg/namebrgpmb', [BarangController::class, 'load_namebrgpmb']);
Route::get('/brg/namebrghpmb', [BarangController::class, 'load_namebrghpmb']);
Route::get('/product/get-search-product', [BarangController::class, 'getProductWithPrice']);
Route::get('/brg/namebrghpnj', [BarangController::class, 'load_namebrghpnj']);

Route::get('/spl', [SupplierController::class, 'index'])->middleware('auth');
Route::post('/spl/tmb', [SupplierController::class, 'tambah']);
Route::put('/spl/ubah/{id_spl}', [SupplierController::class, 'ubah']);
Route::get('/spl/namesplpmb', [SupplierController::class, 'load_namesplpmb']);
Route::get('/spl/getidsplpmb/{id}', [SupplierController::class, 'getidsplpmb']);

Route::get('/cus', [CustomerController::class, 'index'])->middleware('auth');
Route::post('/cus/tmb', [CustomerController::class, 'tambah']);
Route::put('/cus/ubah/{id_cus}', [CustomerController::class, 'ubah']);
Route::get('/cus/namecus', [CustomerController::class, 'load_cus']);
Route::get('/cus/getidcus/{id}', [CustomerController::class, 'getidcus']);

Route::get('/sls', [SalesUserController::class, 'index'])->middleware('auth');
Route::post('/sls/tmb', [SalesUserController::class, 'tambah']);
Route::put('/sls/ubah/{id_sls}', [SalesUserController::class, 'ubah']);
Route::get('/sls/namesls', [SalesUserController::class, 'load_sls']);
Route::get('/sls/getidsls/{id}', [SalesUserController::class, 'getidsls']);
Route::get('/sls/nameslsrpt', [SalesUserController::class, 'load_slsrpt']);

Route::get('/trs/pnj', [TransaksiController::class, 'penjualan'])->middleware('auth');
Route::get('/trs/pnj/data', [TransaksiController::class, 'data_penjualan']);
Route::get('/trs/pnj/tmbrg/{id}/{idcus}', [TransaksiController::class, 'insbrgpnj']);
Route::post('/trs/pnj/qtypnj', [TransaksiController::class, 'qtypnj']);
Route::post('/trs/pnj/hrgpnj', [TransaksiController::class, 'hrgpnj']);
Route::post('/trs/pnj/dispnj', [TransaksiController::class, 'dispnj']);
Route::get('/trs/pnj/hrgmpnj/{ids}/{idb}/{idcus}', [TransaksiController::class, 'hrgmpnj']);
Route::get('/trs/pnj/edthrgmpnj/{idh}/{ids}', [TransaksiController::class, 'edthrgmpnj']);
Route::get('/trs/pnj/delprc/{id}', [TransaksiController::class, 'delprc']);
Route::post('/trs/pnj/inspympnj', [TransaksiController::class, 'inspympnj']);
Route::post('/trs/pnj/inspnj', [TransaksiController::class, 'inspnj']);
Route::get('/trs/pnj/inv', [TransaksiController::class, 'invpnj']);
Route::get('/trs/pmb', [TransaksiController::class, 'pembelian'])->middleware('auth');
Route::get('/trs/pmb/data', [TransaksiController::class, 'data_pembelian']);
Route::get('/trs/pmb/tmbrg/{id}', [TransaksiController::class, 'insbrg']);
Route::post('/trs/pmb/qtypmb', [TransaksiController::class, 'qtypmb']);
Route::post('/trs/pmb/hrgpmb', [TransaksiController::class, 'hrgpmb']);
Route::post('/trs/pmb/dispmb', [TransaksiController::class, 'dispmb']);
Route::get('/trs/pmb/hrgmpmb/{idp}/{idb}/{idspl}', [TransaksiController::class, 'hrgmpmb']);
Route::get('/trs/pmb/edthrgmpmb/{idh}/{idp}', [TransaksiController::class, 'edthrgmpmb']);
Route::post('/trs/pmb/brtpmb', [TransaksiController::class, 'brtpmb']);
Route::post('/trs/pmb/tmbprc', [TransaksiController::class, 'insprc']);
Route::get('/trs/pmb/delprc/{id}/{qty}', [TransaksiController::class, 'delprcpmb']);
Route::post('/trs/pmb/inspym', [TransaksiController::class, 'inspympmb']);
Route::post('/trs/pmb/inspmb', [TransaksiController::class, 'inspmb']);

Route::get('/hst/fpnj', [HistoryController::class, 'fh_penjualan'])->middleware('auth');
Route::post('/hst/rpnj', [HistoryController::class, 'rh_penjualan']);
Route::get('/hst/pnj/{tgl1}/{tgl2}', [HistoryController::class, 'h_penjualan'])->middleware('auth');
Route::get('/hst/epnj/{id}/{tglaw}/{tglak}', [HistoryController::class, 'e_penjualan'])->middleware('auth');
Route::get('/hst/epnj/data/{id}', [HistoryController::class, 't_penjualan']);
Route::get('/hst/epnj/tmbrg/{id}/{idpym}/{idcus}', [HistoryController::class, 'tmbrgpnj']);
Route::post('/hst/epnj/qtypnj', [HistoryController::class, 'qtyhpnj']);
Route::post('/hst/epnj/hrgpnj', [HistoryController::class, 'hrghpnj']);
Route::post('/hst/epnj/dispnj', [HistoryController::class, 'dishpnj']);
Route::get('/hst/epnj/hrgmhpnj/{ids}/{idb}/{idcus}', [HistoryController::class, 'hrgmhpnj']);
Route::post('/hst/epnj/edthrgmhpnj/{idh}', [HistoryController::class, 'edthrgmhpnj']);
Route::get('/hst/epnj/delhpnj/{idp}', [HistoryController::class, 'delhpnj']);
Route::post('/hst/epnj/inshtpnj', [HistoryController::class, 'inshtpnj']);
Route::post('/hst/epnj/inshpnj', [HistoryController::class, 'inshpnj']);
Route::get('/hst/epnj/inv/{id}', [HistoryController::class, 'invpnj']);
Route::get('/hst/fpmb', [HistoryController::class, 'fh_pembelian'])->middleware('auth');
Route::post('/hst/rpmb', [HistoryController::class, 'rh_pembelian']);
Route::get('/hst/pmb/{tgl1}/{tgl2}', [HistoryController::class, 'h_pembelian'])->middleware('auth');
Route::get('/hst/epmb/{id}/{tglaw}/{tglak}', [HistoryController::class, 'e_pembelian'])->middleware('auth');
Route::get('/hst/epmb/data/{id}', [HistoryController::class, 't_pembelian']);
Route::get('/hst/epmb/tmbrg/{id}/{idpym}/{idspl}', [HistoryController::class, 'tmbrgpmb']);
Route::post('/hst/epmb/qtypmb', [HistoryController::class, 'qtyhpmb']);
Route::post('/hst/epmb/hrgpmb', [HistoryController::class, 'hrghpmb']);
Route::post('/hst/epmb/dispmb', [HistoryController::class, 'dishpmb']);
Route::get('/hst/epmb/hrgmhpmb/{idp}/{idb}/{idspl}', [HistoryController::class, 'hrgmhpmb']);
Route::post('/hst/epmb/edthrgmhpmb/{idh}', [HistoryController::class, 'edthrgmhpmb']);
Route::get('/hst/epmb/delhpmb/{id}', [HistoryController::class, 'delhpmb']);
Route::post('/hst/epmb/inshtpmb', [HistoryController::class, 'inshtpmb']);
Route::post('/hst/epmb/inshpmb', [HistoryController::class, 'inshpmb']);
Route::get('/hst/fdpnj', [HistoryController::class, 'fdh_penjualan'])->middleware('auth');
Route::post('/hst/dpnj', [HistoryController::class, 'dh_penjualan'])->middleware('auth');
Route::get('/hst/fdpmb', [HistoryController::class, 'fdh_pembelian'])->middleware('auth');
Route::post('/hst/dpmb', [HistoryController::class, 'dh_pembelian'])->middleware('auth');
Route::get('/hst/spl/{id}', [HistoryController::class, 'h_supplier'])->middleware('auth');
Route::get('/hst/cus/{id}', [HistoryController::class, 'h_customer'])->middleware('auth');
Route::get('/hst/sls/{id}', [HistoryController::class, 'h_sales'])->middleware('auth');
Route::get('/hst/brgpmb/{id}', [HistoryController::class, 'h_brgpmb'])->middleware('auth');
Route::get('/hst/brgpnj/{id}', [HistoryController::class, 'h_brgpnj'])->middleware('auth');

Route::get('/rtr/frpnj', [ReturController::class, 'fr_penjualan'])->middleware('auth');
Route::post('/rtr/rpnj', [ReturController::class, 'r_penjualan'])->middleware('auth');
Route::get('/rtr/drpnj/{id}', [ReturController::class, 'dr_penjualan'])->middleware('auth');
Route::post('/rtr/drpnj/insdrpnj', [ReturController::class, 'insdrpnj']);
Route::get('/rtr/frpmb', [ReturController::class, 'fr_pembelian'])->middleware('auth');
Route::post('/rtr/rpmb', [ReturController::class, 'r_pembelian'])->middleware('auth');
Route::get('/rtr/drpmb/{id}', [ReturController::class, 'dr_pembelian'])->middleware('auth');
Route::post('/rtr/drpmb/insdrpmb', [ReturController::class, 'insdrpmb']);

Route::get('/rpt/fpnj', [ReportController::class, 'f_penjualan'])->middleware('auth');
Route::post('/rpt/hpnj', [ReportController::class, 'h_penjualan'])->middleware('auth');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');