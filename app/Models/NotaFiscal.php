<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaFiscal extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notas_fiscais';

    protected $fillable = [
        'numero',
        'fornecedor',
        'data_emissao',
        'valor_total',
    ];

    protected $casts = [
        'data_emissao' => 'date',
        'valor_total' => 'decimal:2',
    ];

    /**
     * Relacionamento com Despesas
     */
    public function despesas()
    {
        return $this->hasMany(Despesas::class, 'nota_fiscal_id');
    }
}
