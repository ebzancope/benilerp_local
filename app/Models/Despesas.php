<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Despesas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'despesas';

    protected $fillable = [
        'user_id',
        'nota_fiscal_id',
        'competencia',
        'tipoconta',
        'centrocustos',
        'tipodocumento',
        'equipamento',
        'colaborador',
        'fornecedor',
        'quantidade',
        'valorunit',
        'valortotal',
        'empresa',
        'notafiscal',
        'descricao',
        'status'
    ];

    protected $casts = [
        'competencia' => 'datetime',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    // Relacionamentos
    public function clieforne()
    {
        return $this->belongsTo(\App\Models\Clieforne::class, 'fornecedor');
    }

    public function colaborador_rel()
    {
        return $this->belongsTo(\App\Models\Colaboradores::class, 'colaborador');
    }

    public function equipamento_rel()
    {
        // Ajuste o nome da classe se o seu modelo for App\Models\Equipamentos (plural)
        return $this->belongsTo(\App\Models\Equipamento::class, 'equipamento')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // Acessores para formatar valores
    public function getValorFormatadoAttribute()
    {
        return 'R$ ' . number_format((float)$this->valortotal, 2, ',', '.');
    }

    public function getValorunitFormatadoAttribute()
    {
        return $this->valorunit ? 'R$ ' . number_format((float)$this->valorunit, 2, ',', '. ') : 'N/A';
    }

    public function getValortotalFormatadoAttribute()
    {
        return $this->valortotal ? 'R$ ' . number_format((float)$this->valortotal, 2, ',', '.') : 'N/A';
    }

    // Accessor Veículo/modelo
    public function getVeiculoModeloAttribute()
    {
        $equip = $this->equipamento_rel;

        if (!$equip) {
            return 'N/A';
        }

        $placa  = $equip->placa ? $equip->placa . ' - ' : '';
        $modelo = $equip->modelo ?: 'Sem modelo';

        return $placa . $modelo;
    }
}
