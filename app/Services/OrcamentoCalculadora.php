<?php

namespace App\Services;

use App\Models\Orcamento;

class OrcamentoCalculadora
{
    public function recalcular(Orcamento $orcamento): Orcamento
    {
        $subtotalItens = 0;

        // Recalcula cada item do orçamento (faturamento)
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

            $subtotalItens += $item->total_item;
        }

        $totalDespesas = 0;

        // Recalcula cada despesa da obra
        foreach ($orcamento->despesas as $despesa) {
            $despesa->total = max(0, round(($despesa->quantidade ?? 0) * ($despesa->custo_unitario ?? 0), 2));
            $despesa->save();
            $totalDespesas += $despesa->total;
        }

        // Valor final = Faturamento - Desconto - Despesas
        $orcamento->valor_total = max(0, round($subtotalItens - ($orcamento->desconto_total ?? 0) - $totalDespesas, 2));

        return $orcamento;
    }
}
