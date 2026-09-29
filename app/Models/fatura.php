<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class fatura extends Model
{
    use SoftDeletes;
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

        protected $table = 'fatura';

    protected $fillable = [

        'aprovada'

    ];



}
