<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrcamentoItem extends Model
{
    use HasFactory;

    protected $table = 'orcamento_itens'; // <-- ajuste aqui

    protected $fillable = [
        'orcamento_id','tipo_item','descricao','quantidade','unidade','preco_unitario',
        'desconto_percentual','desconto_valor','total_item','ordem','obs'
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class);
    }
}
