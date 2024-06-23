<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function index()
    {
        $data = [
            'title' => 'Login',
        ];
        return view('pages.auth.login', $data);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email' => ['required','email:dns'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($validatedData)) {
            return redirect()->intended('dashboard');
        }
        return back()->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    }

}
