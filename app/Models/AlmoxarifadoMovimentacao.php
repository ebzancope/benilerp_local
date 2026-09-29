<?php
// app/Models/AlmoxarifadoMovimentacao.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlmoxarifadoMovimentacao extends Model
{
    use HasFactory;

    protected $table = 'almoxarifado_movimentacoes';

    protected $fillable = [
        'item_id',
        'tipo',
        'quantidade',
        'valor_unitario',
        'valor_total',
        'documento',
        'motivo',
        'fornecedor_id',
        'equipamento_id',
        'colaborador_id',
        'user_id',
        'data_movimentacao',
        'observacoes'
    ];

    protected $casts = [
        'quantidade' => 'decimal:2',
        'valor_unitario' => 'decimal:2',
        'valor_total' => 'decimal:2',
        'data_movimentacao' => 'date'
    ];

    // Relacionamentos
    public function item()
    {
        return $this->belongsTo(AlmoxarifadoItem::class, 'item_id');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Clieforne::class, 'fornecedor_id');
    }

    public function equipamento()
    {
        return $this->belongsTo(Equipamentos::class, 'equipamento_id');
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaboradores::class, 'colaborador_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Eventos
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($movimentacao) {
            $movimentacao->valor_total = $movimentacao->quantidade * $movimentacao->valor_unitario;
        });

        static::updating(function ($movimentacao) {
            $movimentacao->valor_total = $movimentacao->quantidade * $movimentacao->valor_unitario;
        });
    }
}
