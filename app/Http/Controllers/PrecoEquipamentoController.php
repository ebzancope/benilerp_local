<?php

namespace App\Http\Controllers;

use App\Models\PrecoEquipamento;
use App\Models\Equipamento;
use Illuminate\Http\Request;



class PrecoEquipamentoController extends Controller
{
    public function index(Request $request)




    {
        

         session(['place' => '5']);


        $query = PrecoEquipamento::with('equipamento');

        if ($text = $request->get('text_nome')) {
            $query->whereHas('equipamento', function ($q) use ($text) {
                $q->where(function ($qq) use ($text) {
                    $qq->where('id', $text)
                       ->orWhere('observacao', 'like', "%{$text}%")
                       ->orWhere('codigo', 'like', "%{$text}%");
                });
            });
        }

        $precos = $query->orderBy('equipamento')->paginate(35);

        $totais = [
            'todos'    => PrecoEquipamento::count(),
            'ativos'   => 0,
            'inativos' => 0,
        ];

        return view('preco-equipamentos.index', compact('precos', 'totais'));
    }

    public function create()
    
    {
        
        $equipamentos = Equipamento::all();
        $preco = new PrecoEquipamento();
        return view('preco-equipamentos.create', compact('equipamentos', 'preco'));
    }

    public function store(Request $request)
    {



        $data = $request->validate([
            'equipamento' => ['required',  'string'],
            'preco_unitario' => ['nullable', 'numeric', 'min:0'],
            'observacao'     => ['nullable', 'string'],
        ]);

        PrecoEquipamento::create($data);



        return redirect()->route('preco-equipamentos.index')
            ->with('success', 'Preço criado com sucesso.');
    }

    public function edit(PrecoEquipamento $preco)
    {
        $equipamentos = Equipamento::all();
        return view('preco-equipamentos.edit', compact('preco', 'equipamentos'));
    }

    public function update(Request $request, PrecoEquipamento $preco)
    {
        $data = $request->validate([
            'equipamento' => ['required',  'string'],
            'preco_unitario' => ['nullable', 'numeric', 'min:0'],
            'observacao'     => ['nullable', 'string'],
        ]);

        $preco->update($data);

        return redirect()->route('preco-equipamentos.index')
            ->with('success', 'Preço atualizado com sucesso.');
    }

    public function destroy(PrecoEquipamento $preco)
    {
        $preco->delete();

        return redirect()->route('preco-equipamentos.index')
            ->with('success', 'Preço excluído com sucesso.');
    }
}