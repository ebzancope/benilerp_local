<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrecoEquipamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ajuste conforme sua política
    }

    public function rules(): array
    {
        return [
            'equipamento_id' => ['required', 'exists:equipamentos,id'],
            'preco_diario'   => ['nullable', 'numeric', 'min:0'],
            'preco_semanal'  => ['nullable', 'numeric', 'min:0'],
            'preco_mensal'   => ['nullable', 'numeric', 'min:0'],
            'observacao'     => ['nullable', 'string'],
        ];
    }
}