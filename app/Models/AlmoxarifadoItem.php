<?php
// app/Models/AlmoxarifadoItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlmoxarifadoItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'almoxarifado_itens';

    protected $fillable = [
        'codigo',
        'nome',
        'descricao',
        'categoria',
        'unidade_medida',
        'quantidade_minima',
        'quantidade_atual',
        'custo_medio',
        'ultimo_preco',
        'localizacao',
        'numero_serie',
        'fabricante',
        'modelo',
        'fornecedor_id',
        'ativo',
        'observacoes'
    ];

    protected $casts = [
        'quantidade_minima' => 'decimal:2',
        'quantidade_atual' => 'decimal:2',
        'custo_medio' => 'decimal:2',
        'ultimo_preco' => 'decimal:2',
        'ativo' => 'boolean'
    ];

    // Relacionamentos
    public function fornecedor()
    {
        return $this->belongsTo(Clieforne::class, 'fornecedor_id');
    }

    public function movimentacoes()
    {
        return $this->hasMany(AlmoxarifadoMovimentacao::class, 'item_id');
    }

    // Escopos
    public function scopeAtivo($query)
    {
        return $query->where('ativo', true);
    }

    public function scopeBaixoEstoque($query)
    {
        return $query->whereRaw('quantidade_atual <= quantidade_minima');
    }

    // Acessores
    public function getSituacaoEstoqueAttribute()
    {
        if ($this->quantidade_atual <= 0) {
            return 'esgotado';
        } elseif ($this->quantidade_atual <= $this->quantidade_minima) {
            return 'baixo';
        } else {
            return 'normal';
        }
    }

    public function getValorTotalEstoqueAttribute()
    {
        return $this->quantidade_atual * $this->custo_medio;
    }
}
