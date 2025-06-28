<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

abstract class Controller
{
  //
}

class AdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        if ($email === 'admin@gmail.com' && $password === '12345678') {
            Session::put('is_admin', true);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout()
    {
        Session::forget('is_admin');
        return redirect()->route('admin.login');
    }
}

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
}