<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrecoEquipamento extends Model
{
    protected $table = 'preco_equipamentos';

    protected $fillable = [
        'equipamento',
        'preco_unitario',
        'observacao',
    ];

    protected $casts = [
        'preco_unitario' => 'decimal:2',
    ];

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class, 'equipamento_id');
    }
}