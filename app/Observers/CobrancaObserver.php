<?php

namespace App\Observers;

use App\Models\Cobranca;
use App\Models\CobrancaEvento;

class CobrancaObserver
{
    public function created(Cobranca $c)
    {
        CobrancaEvento::create([
            'cobranca_id' => $c->id,
            'titulo' => 'Cobrança criada',
            'descricao' => 'Status: ' . $c->status,
            'icon' => 'fas fa-plus',
            'badge_color' => 'primary',
        ]);
    }

    public function updated(Cobranca $c)
    {
        if ($c->wasChanged('status')) {
            CobrancaEvento::create([
                'cobranca_id' => $c->id,
                'titulo' => 'Status atualizado',
                'descricao' => 'Novo status: ' . $c->status,
                'icon' => 'fas fa-sync',
                'badge_color' => 'info',
            ]);
        }
    }
}
