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
            'email'   => 'required|email',
            'password'=> 'required',
            'captcha' => session('attempt', 0) > 2 ? 'required|captcha' : ''
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $attempt = session('attempt', '0');

        if (Auth::attempt($request->only(['email', 'password']))) {
            session(['attempt' => 0]);
            return redirect()->route('dashboard');
        } else {

            session(['attempt' => $attempt+1]);
            return redirect()->back()->with(['message' => 'Giriş cəhdi uğursuz', 'type' => 'danger']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with(['message' => 'Çıxış etdiniz', 'type' => 'success']);
    }

}
