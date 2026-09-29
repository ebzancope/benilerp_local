<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrecoEquipamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ajuste conforme sua política
    }

    public function rules(): array
    {
        return [
            'equipamento_id' => ['sometimes', 'required', 'exists:equipamentos,id'],
            'preco_diario'   => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'preco_semanal'  => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'preco_mensal'   => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'observacao'     => ['sometimes', 'nullable', 'string'],
        ];
    }
}