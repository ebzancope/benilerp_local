<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class faturas extends Model
{
    use SoftDeletes;
    //
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $table = 'faturas';

    protected $fillable = [

        'aprovada'

    ];

}
