<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Boleto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'boletos';

    protected $fillable = [
        'user_id',
        'pagador',
        'beneficiario',
        'numdoc',
        'vencimento',
        'valor',
        'descricao',
        'pago'
    ];

    protected $dates = ['vencimento', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'valor' => 'decimal:2',
        'vencimento' => 'date'
    ];

    // Relacionamentos
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pagadorInfo()
    {
        return $this->belongsTo(Clieforne::class, 'pagador');
    }

    public function beneficiarioInfo()
    {
        return $this->belongsTo(Clieforne::class, 'beneficiario');
    }

    // Scopes
    public function scopeAtivos($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopePagos($query)
    {
        return $query->where('pago', 1);
    }

    public function scopePendentes($query)
    {
        return $query->where('pago', 0);
    }

    public function scopeVencidos($query)
    {
        return $query->where('vencimento', '<', now())->where('pago', 0);
    }

    public function scopeAVencer($query, $dias = 7)
    {
        return $query->whereBetween('vencimento', [now(), now()->addDays($dias)])->where('pago', 0);
    }

    // Accessors
    public function getStatusAttribute()
    {
        if ($this->pago) {
            return 'pago';
        } elseif ($this->vencimento < now()) {
            return 'vencido';
        } elseif ($this->vencimento->diffInDays(now()) <= 7) {
            return 'a_vencer';
        } else {
            return 'em_aberto';
        }
    }

    public function getStatusColorAttribute()
    {
        return [
            'pago' => 'success',
            'vencido' => 'danger',
            'a_vencer' => 'warning',
            'em_aberto' => 'info'
        ][$this->status];
    }

    public function getDiasVencimentoAttribute()
    {
        return now()->diffInDays($this->vencimento, false);
    }
}
