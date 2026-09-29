<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Colaboradores;
use App\Models\Equipamentos;

class Abastecimento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'abastecimentos';

    protected $fillable = [
        'user_id',
        'datacad',
        'fornecedor',
        'requisicao',
        'veiculo',
        'colaborador',
        'litros',
        'descricao',
        'combustivel',
        'qtda',
        'valora',
        'desconto',
        'totala',
        'km',
        'horimini',
        'tipo'
    ];

    protected $dates = ['datacad', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'litros' => 'decimal:3',
        'qtda' => 'decimal:3',
        'totala' => 'decimal:2',
        'km' => 'decimal:1',
        'horimini' => 'decimal:1'
    ];

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function fornecedorInfo()
    {
        return $this->belongsTo(Clieforne::class, 'fornecedor');
    }

    public function veiculoInfo()
    {
        return $this->belongsTo(Equipamentos::class, 'veiculo');
    }

    public function colaboradorInfo()
    {
        return $this->belongsTo(Colaboradores::class, 'colaborador');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopePorPeriodo($query, $dataInicio, $dataFim)
    {
        return $query->whereBetween('datacad', [$dataInicio, $dataFim]);
    }

    public function scopePorVeiculo($query, $veiculo)
    {
        return $query->where('veiculo', $veiculo);
    }

    public function scopePorFornecedor($query, $fornecedor)
    {
        return $query->where('fornecedor', $fornecedor);
    }

    public function scopePorCombustivel($query, $combustivel)
    {
        return $query->where('combustivel', $combustivel);
    }

    // Accessors
    public function getTipoCombustivelAttribute()
    {
        $tipos = [
            1 => 'Álcool',
            2 => 'Gasolina Comum',
            3 => 'Gasolina Aditivada',
            4 => 'Diesel',
            5 => 'Diesel S10',
            6 => 'Etanol',
            7 => 'GNV'
        ];
        return $tipos[$this->combustivel] ?? 'Não informado';
    }

    public function getTipoAbastecimentoAttribute()
    {
        $tipos = [
            1 => 'Normal',
            2 => 'Completo',
            3 => 'Parcial',
            4 => 'Emergencial'
        ];
        return $tipos[$this->tipo] ?? 'Normal';
    }

    public function getValorPorLitroAttribute()
    {
        return $this->litros > 0 ? $this->totala / $this->litros : 0;
    }
}
