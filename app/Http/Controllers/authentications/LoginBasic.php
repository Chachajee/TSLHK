<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginBasic extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-login-basic', ['pageConfigs' => $pageConfigs]);
  }

  public function login(Request $request)
  {
    $request->validate([
      'email-username' => 'required|email',
      'password' => 'required',
    ]);

    $credentials = [
      'email' => $request->input('email-username'),
      'password' => $request->input('password'),
    ];

    if (Auth::attempt($credentials)) {
      $user = Auth::user();
      if ($user->email === 'admin@gmail.com') {
        Session::put('is_admin', true);
        return redirect('/admin/dashboard');
      } else {
        Auth::logout();
        return back()->withErrors(['email-username' => 'Only admin can login here'])->withInput();
      }
    }

    return back()->withErrors(['email-username' => 'Invalid credentials'])->withInput();
  }

  public function logout()
  {
    Session::forget('is_admin');
    Auth::logout();
    return redirect()->route('auth-login-basic');
  }
}