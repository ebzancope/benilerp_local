<?php

namespace App\Http\Controllers;

use App\Models\Clieforne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ClieforneController extends Controller
{
    public function index(Request $request)
    {

        session(['place' => '1']);


        $query = Clieforne::whereNull('deleted_at');

        // Filtros
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('text_nome')) {
            $query->where(function($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->text_nome . '%')
                  ->orWhere('apelido', 'like', '%' . $request->text_nome . '%')
                  ->orWhere('email', 'like', '%' . $request->text_nome . '%')
                  ->orWhere('cpfj', 'like', '%' . $request->text_nome . '%');
            });
        }

        if ($request->filled('uf')) {
            $query->where('uf', $request->uf);
        }

        if ($request->filled('cidade')) {
            $query->where('cidade', 'like', '%' . $request->cidade . '%');
        }

        $cliefornes = $query->orderBy('nome')->paginate(15);

        // Contadores
        $totalClientes = Clieforne::whereNull('deleted_at')->where('tipo', 1)->count();
        $totalFornecedores = Clieforne::whereNull('deleted_at')->where('tipo', 2)->count();
        $totalAtivos = Clieforne::whereNull('deleted_at')->count();

        return view('cliefornes.index', compact('cliefornes', 'totalClientes', 'totalFornecedores', 'totalAtivos'));
    }

    public function create()
    {
        return view('cliefornes.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nome'  => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'cpfj'  => 'nullable|string|max:255',
        'tipo'  => 'required|in:1,2',
    ]);

    $data = $request->except(['_token']);

    // Garante que os campos validados entrem com os valores já tratados
    $data['nome']  = $validated['nome'];
    $data['email'] = $validated['email'] ?? null;
    $data['cpfj']  = $validated['cpfj'] ?? null;
    $data['tipo']  = $validated['tipo'];

    // Define user_id sem depender de campo enviado no form
    $data['user_id'] = session('user.id');

    Clieforne::create($data);

    return redirect()
        ->route('cliefornes.index')
        ->with('mensagem', 'Cadastro criado com sucesso!');
}

    public function show($id)
    {
        $clieforne = Clieforne::findOrFail($id);
        $user = $clieforne->user; // Obtém o usuário associado ao clieforne
        return view('cliefornes.show', compact('clieforne','user'));
    }


    public function edit($id)
    {
        try {
            $clieforne = Clieforne::findOrFail(Crypt::decrypt($id));
            $user = $clieforne->user; // Obtém o usuário associado ao clieforne
            return view('cliefornes.edit', compact('clieforne', 'user'));
        } catch (\Exception $e) {
            return redirect()->route('cliefornes.index')
                ->with('mensagem', 'Cadastro não encontrado!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email',
            'cpfj' => 'nullable|string|max:255',
            'tipo' => 'required|in:1,2',
        ]);

        try {
            $clieforne = Clieforne::findOrFail(Crypt::decrypt($id));
            $clieforne->update($request->all());

            return redirect()->route('cliefornes.index')
                ->with('mensagem', 'Cadastro atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('cliefornes.index')
                ->with('mensagem', 'Erro ao atualizar cadastro!');
        }
    }

    public function destroy($id)
    {
        try {
            $clieforne = Clieforne::findOrFail(Crypt::decrypt($id));
            $clieforne->delete();

            return redirect()->route('cliefornes.index')
                ->with('mensagem', 'Cadastro excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('cliefornes.index')
                ->with('mensagem', 'Erro ao excluir cadastro!');
        }
    }
}
