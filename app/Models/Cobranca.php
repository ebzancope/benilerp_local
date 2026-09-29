<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clieforne;

class Cobranca extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id','valor','status','contabanc','tipo_pagamento','data_vencimento','observacao','numero_os'
    ];

    protected $casts = [
        'data_vencimento' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Clieforne::class);
    }

    public function eventos()
    {
        return $this->hasMany(CobrancaEvento::class)->latest();
    }
}
