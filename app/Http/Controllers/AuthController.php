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
            'captcha' => 'required|captcha'
        ];
        $validator = Validator::make(request()->all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with(['message' => 'Giriş cəhdi uğursuz', 'type' => 'danger']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with(['message' => 'Çıxış etdiniz', 'type' => 'success']);
    }

}
