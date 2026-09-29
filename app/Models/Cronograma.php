<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cronograma extends Model
{
    use SoftDeletes;

    protected $table = 'cronogramas';

    protected $fillable = [
        'user_id',
        'cliente',
        'descricao',   // armazena o ID do equipamento
        'dataini',
        'datafim',
        'estatus',
        'valor',
        'vencimento',
        'observacao',
        'orcamento_id', // adicione aqui
        'obsercobra',
        'statuscobra',
        'tipo_pagamento', // novos campos
         'fatura_numos', // <-- obrigatório aqui
    ];

    protected $casts = [
        'dataini'    => 'date',
        'datafim'    => 'date',
        'vencimento' => 'datetime',
        'fatura_numos' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relaciona o equipamento (campo descricao armazena o id do equipamento)
    public function equipamento()
    {
        return $this->belongsTo(Equipamentos::class, 'descricao', 'id');
    }

    // Relaciona o cliente/fornecedor
    public function clienteInfo()
    {
        return $this->belongsTo(Clieforne::class, 'cliente', 'id');
    }

    // Helpers para exibir status no blade
    public function getStatusTextAttribute(): string
    {
        return [
            '1' => 'A Receber',
            '2' => 'Pago',
            '3' => 'Em Execução',
            '4' => 'Agendar',
            '5' => 'A Visitar',
            '6' => 'Finalizado',
            '7' => 'Agendado',
            '8' => 'Orçamento',
            '9' => 'Cortesia',
        ][$this->estatus] ?? 'Indefinido';
    }

    public function getStatusColorAttribute(): string
    {
        return [
            '1' => 'primary',
            '2' => 'success',
            '3' => 'warning',
            '4' => 'info',
            '5' => 'secondary',
            '6' => 'dark',
            '7' => 'danger',
            '8' => 'secondary',
            '9' => 'info',
        ][$this->estatus] ?? 'light';
    }

        public function getFinanceiroTextAttribute(): string
    {
        return match($this->statuscobra) {
            'boleto'    => 'Boleto',
            'pago'      => 'Pago',
            'cobrado'   => 'Cobrado',
            'a_cobrar'  => 'A Cobrar',
            'pendente'  => 'Pendente',
            default     => ucfirst($this->statuscobra ?? '—'),
        };
    }

    public function getFinanceiroColorAttribute(): string
    {
        return match($this->statuscobra) {
            'boleto'    => 'info',
            'pago'      => 'success',
            'cobrado'   => 'secondary',
            'a_cobrar'  => 'warning',
            'pendente'  => 'danger',
            default     => 'light',
        };
    }
        public function orcamento()
    {
        return $this->belongsTo(\App\Models\Orcamento::class, 'orcamento_id');
    }
}
