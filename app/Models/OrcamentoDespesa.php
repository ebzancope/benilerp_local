<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoDespesa extends Model
{
    use HasFactory;

    protected $table = 'orcamento_despesas';

    protected $fillable = [
        'orcamento_id',
        'tipo',
        'descricao',
        'quantidade',
        'unidade',
        'custo_unitario',
        'total',
        'obs',
        'ordem',
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class);
    }
}
