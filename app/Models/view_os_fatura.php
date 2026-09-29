<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class view_os_fatura extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
