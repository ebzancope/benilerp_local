<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $user = session('user');

        return view('reports.index', [
            'user' => $user,
            'pageTitle' => 'Relatórios'
        ]);
    }

    public function sales()
    {
        $user = session('user');

        return view('reports.sales', [
            'user' => $user,
            'pageTitle' => 'Relatório de Vendas'
        ]);
    }
}
