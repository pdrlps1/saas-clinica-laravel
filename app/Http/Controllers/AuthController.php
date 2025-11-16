<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view ('auth.login');
    }

    public function login (AuthRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))->with('success', 'Login realizado com sucesso!');
        };

        return back()->withErrors(['email' => 'As credenciais fornecidas estão incorretas.'])->onlyInput('email');
    }

    public function logout (Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout realizado com sucesso!');
    }

    public function showRegisterForm ()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('success', 'Conta criada com sucesso! Bem-vindo(a)!');
    }
}
