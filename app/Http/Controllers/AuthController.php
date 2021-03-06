<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller {


    public function login()
    {
        return view('admin.page.auth.login');
    }

    public function attempt(Request $request)
    {
        $rules = [
            'username'   => 'required',
            'password'=> 'required',
            'captcha' => session('attempt', 0) > 2 ? 'required|captcha' : ''
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $attempt = session('attempt', '0');

        if (Auth::attempt($request->only(['username', 'password']))) {
            session(['attempt' => 0]);
            activity()->log(auth()->user()->name.' sistemə giriş etdi.');
            return redirect()->route('dashboard');
        } else {

            session(['attempt' => $attempt+1]);
            return redirect()->back()->with(['message' => 'Giriş cəhdi uğursuz', 'type' => 'danger']);
        }
    }

    public function logout()
    {
        activity()->log(auth()->user()->name.' sistemdən çıxış etdi.');
        Auth::logout();
        return redirect()->route('login')->with(['message' => 'Çıxış etdiniz', 'type' => 'success']);
    }

}
