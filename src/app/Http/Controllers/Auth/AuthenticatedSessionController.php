<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $credentials = $request->only('email', 'password');

    Log::info('Attempting login', ['credentials' => $credentials]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('contacts'); // 適切なリダイレクト先に変更
    }

    Log::error('Login attempt failed', ['credentials' => $credentials]);
    
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}

}
