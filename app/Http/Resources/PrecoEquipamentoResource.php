<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrecoEquipamentoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'equipamento_id' => $this->equipamento_id,
            'preco_diario'   => $this->preco_diario,
            'preco_semanal'  => $this->preco_semanal,
            'preco_mensal'   => $this->preco_mensal,
            'observacao'     => $this->observacao,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}