<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|exists:users',
            'password' => 'required'
        ]);

        if(!auth()->attempt($data)){
            return redirect()->route('auth.index')->with('failed', 'Password akun salah');
        }

        return redirect()->route('laundry.index');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('auth.index');
    }
}
