<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colaborador extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'colaboradores';

    protected $fillable = [
        'user_id',
        'nome',
        'apelido',
        'email',
        'empresa',
        'telefone',
        'cargo',
        'admissao',
        'funcao',
        'cpf',
        'cnh',
        'setor',
        'categoria',
        'validade',
        'salario',
        'nascimento',
        'nivel',
        'cep',
        'uf',
        'cidade',
        'bairro',
        'endereco',
        'numero',
        'contato',
        'fone',
        'ativo',
        'obs'
    ];

    protected $casts = [
        'admissao' => 'datetime',
        'validade' => 'datetime',
        'nascimento' => 'datetime',
        'salario' => 'decimal:2',
        'ativo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empresaInfo()
    {
        return $this->belongsTo(Clieforne::class, 'empresa');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->where('ativo', 1)->whereNull('deleted_at');
    }

    public function scopeInativos($query)
    {
        return $query->where('ativo', 0)->orWhereNotNull('deleted_at');
    }

    public function scopePorCargo($query, $cargo)
    {
        return $query->where('cargo', $cargo);
    }

    public function scopePorSetor($query, $setor)
    {
        return $query->where('setor', $setor);
    }

    // Accessors
    public function getStatusAttribute()
    {
        if ($this->deleted_at) {
            return 'inativo';
        }
        return $this->ativo ? 'ativo' : 'inativo';
    }

    public function getStatusColorAttribute()
    {
        if ($this->deleted_at) {
            return 'danger';
        }
        return $this->ativo ? 'success' : 'warning';
    }

    public function getStatusTextAttribute()
    {
        if ($this->deleted_at) {
            return 'Excluído';
        }
        return $this->ativo ? 'Ativo' : 'Inativo';
    }

    public function getSalarioFormatadoAttribute()
    {
        return $this->salario ? 'R$ ' . number_format($this->salario, 2, ',', '.') : 'Não informado';
    }

    public function getAdmissaoFormatadaAttribute()
    {
        return $this->admissao ? $this->admissao->format('d/m/Y') : 'Não informada';
    }

    public function getNascimentoFormatadoAttribute()
    {
        return $this->nascimento ? $this->nascimento->format('d/m/Y') : 'Não informado';
    }

    public function getEnderecoCompletoAttribute()
    {
        $endereco = '';
        if ($this->endereco) {
            $endereco .= $this->endereco;
            if ($this->numero) $endereco .= ', ' . $this->numero;
            if ($this->bairro) $endereco .= ' - ' . $this->bairro;
            if ($this->cidade) $endereco .= ', ' . $this->cidade;
            if ($this->uf) $endereco .= '/' . $this->uf;
            if ($this->cep) $endereco .= ' - CEP: ' . $this->cep;
        }
        return $endereco ?: 'Endereço não informado';
    }

    public function getIdadeAttribute()
    {
        if (!$this->nascimento) return null;
        return $this->nascimento->age;
    }

    public function getTempoEmpresaAttribute()
    {
        if (!$this->admissao) return null;
        return $this->admissao->diffInYears(now());
    }
}
