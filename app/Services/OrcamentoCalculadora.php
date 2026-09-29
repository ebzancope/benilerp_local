<?php

namespace App\Services;

use App\Models\Orcamento;

class OrcamentoCalculadora
{
    public function recalcular(Orcamento $orcamento): Orcamento
    {
        $subtotal = 0;
        foreach ($orcamento->itens as $item) {
            $valorBruto = $item->quantidade * $item->preco_unitario;
            $descPct = max(0, $item->desconto_percentual);
            $descVal = max(0, $item->desconto_valor);
            $total = $valorBruto;
            if ($descPct > 0) {
                $total -= ($valorBruto * ($descPct / 100));
            }
            if ($descVal > 0) {
                $total -= $descVal;
            }
            $item->total_item = max(0, round($total, 2));
            $item->save();
            $subtotal += $item->total_item;
        }

        $orcamento->valor_total = max(0, round($subtotal - $orcamento->desconto_total + $orcamento->acrescimo_total, 2));
        return $orcamento;
    }
}
