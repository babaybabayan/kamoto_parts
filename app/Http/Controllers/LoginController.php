<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller{
    public function login(){
    	if (Auth::check()) {
    		return redirect('ewe');
    	}else{
    		return view('login');
    	}
    }
    public function actionlogin(Request $request){
        $data = [
            'name' => $request->input('uname'),
            'password' => $request->input('password'),
        ];
        if (Auth::Attempt($data)) {
            return redirect('home');
        }else{
            Session::flash('error', 'Username atau Password Salah');
            return redirect('login');
        }
    }
    public function actionlogout(){
        Auth::logout();
        return redirect('login');
    }
}
