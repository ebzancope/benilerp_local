<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class view_os_geral extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
