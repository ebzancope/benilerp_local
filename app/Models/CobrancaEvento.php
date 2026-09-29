<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CobrancaEvento extends Model
{
    use HasFactory;
    protected $fillable = ['cobranca_id','titulo','descricao','icon','badge_color'];
    public function cobranca()
    {
        return $this->belongsTo(Cobranca::class);
    }
}
