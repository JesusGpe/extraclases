<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
class LoginController extends Controller{

    public function __construct(){
        $this->middleware('guest',['only'=>'showLoginForm']);
    }

    public function showLoginForm(){

        return view('auth.login');
    }

    public function login(){

        $credentials=$this->validate(request(),[
            'usuario'=>'required|string',
            'password'=>'required|string'
        ]);

        if(Auth::attempt($credentials)){
          return redirect()->route('main');
        }
        return back()->withErrors(['usuario'=>'Estas credenciales no coinciden con nuestros registros'])->withInput(request(['usuario']));
   }

   public function logout(){
        Auth::logout();
        return redirect('/');
   }
}
