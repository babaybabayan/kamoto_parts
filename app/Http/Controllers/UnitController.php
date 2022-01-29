<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;
use App\Models\Unit;

class UnitController extends Controller{
    public function index(){
    	$unit = Unit::orderBy('name','asc')->get();
        return view('unit/unit', ['unit' => $unit]);
    }
    public function tambah(Request $request){
    	$cdnu = DB::table('unit')->where('name', $request->name)->count();
        if ($cdnu == 0) {
            Unit::create([
	            'name' => $request->name
	        ]);
        }
        return Response::json(['success'=>true, 'info'=>$cdnu]);
    }
    public function ubah($id, Request $request){
        $unit = Unit::find($id);
        $unit->name = $request->uname;
        $unit->save();
        return redirect('/brg/sat');
    }
}
