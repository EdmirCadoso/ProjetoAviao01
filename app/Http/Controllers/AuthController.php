<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        //form validation
        $credentials = $request->validate(
            [
                'username'=> 'required|min:3|max:30',
                'password' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/'            ],
            [
                'username.required' => 'O utilizador é obrigatório',
                'username.min' => 'O utilizador deve ter no mínimo :min caracteres',
                'username.max' => 'O utilizador deve ter no maximo :max caracteres',
                'password.required' => 'A password é obrigatória',
                'password.min' => 'A password  deve conter no mínimo :min caracteres',
                'password.max' => 'A password  deve conter no maximo :max caracteres',
                'password.regex' => 'O utilizador deve conter pelo menos uma letra maiúscula, uma letra minuscula  e um numero',
            ]
        );

        // verificar se o user existe
        $user = User::where('username', $credentials['username'])
            ->where('active', true)
            ->where(function($query){
                $query->whereNull('blocked_until')
                ->orWhere('blocked_until', '<=', now());
            })
            ->whereNotNull('email_verified_at')
            ->whereNull('deleted_at')
            ->first();

        // verificar se o user existe
        if(!$user){
            print("chegou");
            return back()->withInput()->with([
                'invalid_login' => 'Login inválido'
            ]);
        }
        // verificar se a password é valida
        if(!password_verify($credentials['password'], $user->password )){

               return back()->withInput()->with([
                'invalid_login' => 'Password inválido'
            ]);
        }
        // atualizar ultimo login (last_login_at)
        $user->last_login_at = now();
        $user->blocked_until = null;
        $user->save();

        //login propriamente dito!
        $request->session()->regenerate();
        Auth::login($user);

        // rederencionar
        return redirect()->intended(route('home'));


    }
}
