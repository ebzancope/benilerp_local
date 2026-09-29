<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $user = session('user');

        return view('settings.index', [
            'user' => $user,
            'pageTitle' => 'Configurações'
        ]);
    }

    public function users()
    {
        $user = session('user');

        return view('settings.users', [
            'user' => $user,
            'pageTitle' => 'Gerenciar Usuários'
        ]);
    }
}
