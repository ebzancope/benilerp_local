<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipamentos extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipamentos';

    protected $fillable = [
        'user_id',
        'codigo',
        'modelo',
        'categoria',
        'marca',
        'cor',
        'placa',
        'ano',
        'renavam',
        'chassi',
        'potencia',
        'motor',
        'prop',
        'apolice',
        'valor',
        'alienacao',
        'venc',
        'observacao',
        'image'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function abastecimentos()
    {
        return $this->hasMany(Abastecimento::class, 'veiculo');
    }

    public function manutencoes()
    {
        return $this->hasMany(Manutencao::class, 'veiculo_id');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    public function scopeComPlaca($query, $placa)
    {
        return $query->where('placa', 'like', "%{$placa}%");
    }

    // Accessors
    public function getStatusAttribute()
    {
        return $this->deleted_at ? 'inativo' : 'ativo';
    }

    public function getValorFormatadoAttribute()
    {
        return $this->valor ? 'R$ ' . number_format($this->valor, 2, ',', '.') : 'Não informado';
    }

    public function getAnoModeloAttribute()
    {
        return $this->ano ?: 'Não informado';
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('../storage/app/public/' . $this->image);
        }
        return asset('../storage/app/public/vehicle-placeholder.png');
    }

    // Métodos
    public function consumoMedio()
    {
        $abastecimentos = $this->abastecimentos()->whereNotNull('km')->get();

        if ($abastecimentos->count() < 2) {
            return null;
        }

        $primeiro = $abastecimentos->first();
        $ultimo = $abastecimentos->last();

        $kmPercorridos = $ultimo->km - $primeiro->km;
        $litrosConsumidos = $abastecimentos->sum('litros') - $primeiro->litros;

        return $litrosConsumidos > 0 ? $kmPercorridos / $litrosConsumidos : null;
    }

    public function custoTotalAbastecimento()
    {
        return $this->abastecimentos()->sum('totala');
    }
}