<?php

namespace App\Http\Controllers;

use App\Mail\NewUserConfirmation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
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

    public function logout(): RedirectResponse
    {
        //logout
        Auth::logout();
        return redirect()->route('login');
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function store_user(Request $request): RedirectResponse|View
    {
        // form validation
        $request->validate(
            [
                'username' => 'required|min:3|max:30|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/',
                'password_confirmation' => 'required|same:password',
            ],
            [
                'username.required' => 'O utilizador é obrigatório',
                'username.min' => 'O utilizador deve ter no mínimo :min caracteres',
                'username.max' => 'O utilizador deve ter no maximo :max caracteres',
                'username.unique' => 'Este nome não pode ser usado',
                'email.required' => 'O email é obrigatório',
                'email.email' => 'O email deve ser um endereço do email válido',
                'email.unique' => 'Este email não pode ser usado',
                'password.required' => 'A password é obrigatória',
                'password.min' => 'A password  deve conter no mínimo :min caracteres',
                'password.max' => 'A password  deve conter no maximo :max caracteres',
                'password.regex' => 'O utilizador deve conter pelo menos uma letra maiúscula, uma letra minuscula  e um numero',
                'password_confirmation.required' => 'A confirmação da password é obrigatória',
                'password_confirmation.same' => 'A confirmação da password deve ser igual a password',
            ]
        );

        // vamos criar um novo user definindo um token de verificação de email
        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->token = Str::random(64);

        // gerar link
        $confirmation_link = route('new_user_confirmation', ['token' => $user->token]);

        // enviar email
        $result = Mail::to($user->email)->send(new NewUserConfirmation($user->username, $confirmation_link ));

        // verificar se o email foi enviado com sucesso
        if(!$result){
            return back()->withInput()->with([
                'server_error' => 'Ocorreu um erro ao enviar o email de confirmação.'
            ]);
        }

        // criar o utilizador na base de dados
        $user->save();

        // apresentar view de sucesso
        return view('auth.email_sent', ['email' => $user->email]);
        // dd($user );

        // definir novo user

    }

    public function new_user_confirmation($token)
    {
        //verificar se o token é válido
        $user = User::where('token', $token)->first();
        if(!$user){
            return redirect()->route('login');
        }

        // confirmar o registo do usúario
        $user->email_verified_at = Carbon::now();
        $user->token = null;
        $user->active = true;
        $user->save();

        // autenticação automática (login) do utilizador confirmado
        Auth::login($user);

        // apresenta uma mensagem de sucesso
        return view('auth.new_user_confirmation');
    }

    public function profile(): View
    {
        return view('auth.profile');
    }

    public function change_password(Request $request)
    {
        $request->validate(
            [
                'current_password'=> 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/',
                'new_password' => 'required|min:8|max:32|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).*$/|different:current_password',
                'new_password_confirmation' => 'required|same:new_password',
            ],
            [
                'current_password.required' => 'A password atual é obrigatória',
                'current_password.min' => 'A password atual deve conter no mínimo :min caracteres',
                'current_password.max' => 'A password atual deve conter no maximo :max caracteres',
                'current_password.regex' => 'O password atual deve conter pelo menos uma letra maiúscula, uma letra minuscula  e um numero',
                'new_password.required' => 'A nova password atual é obrigatória',
                'new_password.min' => 'A nova password deve conter no mínimo :min caracteres',
                'new_password.max' => 'A nova password deve conter no maximo :max caracteres',
                'new_password.regex' => 'O nova password deve conter pelo menos uma letra maiúscula, uma letra minuscula  e um numero',
                'new_password.different' => 'A nova password deve ser diferente da password atual',
                'new_password_confirmation.required' => 'A confirmação da nova password é obrigatória',
                'new_password_confirmation.same' => 'A confirmação da password deve ser igual a nova password',
            ]
        );

        // verificar se a password atual (current_password) está correta
        if(!password_verify($request->current_password, Auth::user()->password)){
            return back()->with([
                'server_error' => "A password atual não está correta"
            ]);
        }

        // atualizar a password na base de dados
        $user = Auth::user();
        $user->password = bcrypt($request->new_password);
        echo 'ok';
        $user->save();

        // atualizar a password na sessão
        Auth::user()->password = $request->new_password;

        //apresenta msm sucesso
        return redirect()->route('profile')->with([
        'success' => "A password foi atualizada com sucesso"
    ]);
    }

    public function forgot_password():View
    {
        return view('auth.forgot_password');
    }

    public function send_reset_password_link(Request $request)
    {
        // form validation
        $request -> validate(
            [
                'email' => 'required|email',
            ],
            [
                'email.required'=> 'O email é obrigatório',
                'email.email'=> 'O email deve ser um endereço de email válido.'
            ]

        );

        $generic_message = "Verifique a sua caixa de correio para prosseguir com a recuperação de password.";

        // verificar se email existe
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return back()->with([
                'server_message' => $generic_message
            ]);
        }

        // criar o link com token para enviar no email
        $user->token = Str::random(64);

        $token_link = route('reset_password', ['token' => $user->token]);

        // envio de email com link para recuperar a password
        // $result = Mail::to($request->user())->send(new MailableClass);

         return back()->with([
                'server_message' => $generic_message
            ]);


    }
}
