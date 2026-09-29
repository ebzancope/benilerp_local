<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrcamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Garante que itens seja array, mesmo se vier vazio/null/int
        $itens = $this->input('itens', []);
        if (!is_array($itens)) {
            $itens = [];
        }
        // Reindexa
        $this->merge([
            'itens' => array_values($itens),
        ]);
    }

    public function rules(): array
    {
        return [
            'cliente_id' => ['required','exists:cliefornes,id'],
            'titulo' => ['nullable','string','max:190'],
            'descricao' => ['nullable','string'],
            'local' => ['nullable','string','max:255'],
            'status' => ['in:rascunho,enviado,aprovado,rejeitado,cancelado,convertido'],
            'data_emissao' => ['nullable','date'],
            'data_validade' => ['nullable','date','after_or_equal:data_emissao'],
            'condicoes_pagamento' => ['nullable','string'],
            'prazo_execucao' => ['nullable','string','max:120'],
            'desconto_total' => ['nullable','numeric','min:0'],

            // Itens
            'itens' => ['required','array','min:1'],
            'itens.*.tipo_item' => ['required','in:empreita,hora_maquina,viagem_caminhao,frete_maquinas,diaria_caminhao,tonelada,frete,outro'],
            'itens.*.descricao' => ['required','string','max:255'],
            'itens.*.local' => ['nullable','string','max:255'],
            'itens.*.quantidade' => ['required','numeric','gt:0'],
            'itens.*.unidade' => ['nullable','string','max:20'],
            'itens.*.preco_unitario' => ['required','numeric','gte:0'],
            'itens.*.desconto_percentual' => ['nullable','numeric','between:0,100'],
            'itens.*.desconto_valor' => ['nullable','numeric','gte:0'],
            'itens.*.ordem' => ['nullable','integer','gte:0'],
            'itens.*.obs' => ['nullable','string'],
        ];
    }
}
