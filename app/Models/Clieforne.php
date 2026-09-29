<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clieforne extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cliefornes';

    protected $fillable = [
        'user_id',
        'nome',
        'apelido',
        'email',
        'cpfj',
        'tipo',
        'insc',
        'inscm',
        'fone',
        'celular',
        'cep',
        'uf',
        'cidade',
        'bairro',
        'endereco',
        'numero',
        'contato',
        'emailcontato',
        'telefone',
        'obs'
    ];

    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
