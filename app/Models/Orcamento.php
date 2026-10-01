<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orcamento extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'numero','cliente_id','titulo','local','descricao','status','data_emissao','data_validade',
        'condicoes_pagamento','prazo_execucao','desconto_total','acrescimo_total','valor_total',
        'created_by','updated_by','approved_by','converted_os_id'
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'data_validade' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Clieforne::class, 'cliente_id');
    }

    public function itens()
    {
        return $this->hasMany(OrcamentoItem::class);
    }

    public function despesas()
    {
        return $this->hasMany(OrcamentoDespesa::class);
    }

    /**
     * Calcula o total de despesas
     */
    public function getTotalDespesasAttribute()
    {
        return $this->despesas->sum('total') ?? 0;
    }

    /**
     * Calcula o lucro/prejuízo
     */
    public function getLucroAttribute()
    {
        return $this->valor_total - $this->total_despesas;
    }
}
