<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password; // <- faltou
use Illuminate\Support\Facades\Hash;     // <- faltou
use Illuminate\Support\Str;              // <- faltou
use Illuminate\Auth\Events\PasswordReset; // <- faltou

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate(
            [
                'adm_login' => 'required|email',
                'adm_senha' => 'required|min:6|max:16',
            ],
            [
                'adm_login.required' => 'Usuário é obrigatório',
                'adm_login.email' => 'Usuário deve ser um email',
                'adm_senha.required' => 'Senha é obrigatório',
                'adm_senha.min' => 'Usuário ou Senha incorreta',
                'adm_senha.max' => 'Usuário ou Senha incorreta',
            ]
        );

        $email = $request->input('adm_login');
        $password = $request->input('adm_senha');

        // Buscar usuário - remova a condição do updated_at se estiver causando problemas
        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('LoginError', 'Dados incorretos, tente novamente.');
        }

        if (! password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('LoginError', 'Dados incorretos, tente novamente');
        }

        // Verificar se usuário está aprovado
        if (! $user->approved) {
            return redirect()
                ->back()
                ->withInput()
                ->with('LoginError', 'Usuário aguardando aprovação.');
        }

        // Configurações de data e hora para português do Brasil
        setlocale(LC_TIME, 'pt_BR.UTF-8');
        date_default_timezone_set('America/Sao_Paulo');

        // **CORREÇÃO: Usar DB::table para garantir a atualização**
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'last_login' => now(),
                'login_count' => DB::raw('COALESCE(login_count, 0) + 1'),
                'updated_at' => now(),
            ]);

        // **CORREÇÃO: Recarregar o usuário com os dados atualizados**
        $user = User::find($user->id);

        session([
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'access_level' => $user->access_level,
                'photo' => $user->photo,
            ],
        ]);

        // $accessLevels
        //  1 => 'Usuário',
        //  2 => 'Administrador',
        //  3 => 'Super Admin'

        // AGORA pode verificar a session
        if (session('user.access_level') == 3 || session('user.access_level') == 2) {
            return redirect()->to('/cronograma');
        } else {
            return redirect()->to('/os');
        }

    }

    public function showForgotForm()
    {
        return view('auth.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('auth.reset', ['token' => $token, 'email' => request('email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|max:16|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    // return redirect()->to('/oservico');
    public function logout()
    {
        session()->forget('user');

        return redirect()->to('/login');
    }
}
