<?php

namespace App\Http\Controllers;

use App\Models\view_os_geral;
use Illuminate\Http\Request;

class OservicoController extends Controller
{
    public function autocomplete(Request $request)
    {
        $term = $request->input('term');

        if (strlen($term) < 2) {
            return response()->json([]);
        }

        // Busca por número de OS se começar com número
        if (is_numeric($term)) {
            $resultados = view_os_geral::whereNull('numos_deleted')
                ->where('idnumos', 'like', $term . '%')
                ->orderBy('idnumos', 'asc')
                ->limit(15)
                ->get(['idnumos', 'nomeclie', 'apelidoclie', 'codclie']);
        } else {
            // Busca por nome (começando com a letra)
            $resultados = view_os_geral::whereNull('numos_deleted')
                ->where(function($query) use ($term) {
                    $query->where('nomeclie', 'like', $term . '%')
                          ->orWhere('apelidoclie', 'like', $term . '%');
                })
                ->orderBy('nomeclie', 'asc')
                ->orderBy('apelidoclie', 'asc')
                ->limit(15)
                ->get(['idnumos', 'nomeclie', 'apelidoclie', 'codclie']);
        }

        $sugestoes = [];
        foreach ($resultados as $resultado) {
            $sugestoes[] = [
                'value' => $resultado->idnumos . ' - ' . $resultado->nomeclie .
                          ($resultado->apelidoclie ? ' (' . $resultado->apelidoclie . ')' : ''),
                'label' => $resultado->idnumos . ' - ' . $resultado->nomeclie .
                          ($resultado->apelidoclie ? ' (' . $resultado->apelidoclie . ')' : ''),
                'idnumos' => $resultado->idnumos,
                'nomeclie' => $resultado->nomeclie,
                'apelidoclie' => $resultado->apelidoclie,
                'codclie' => $resultado->codclie
            ];
        }

        return response()->json($sugestoes);
    }

    // ... resto dos métodos (oservico, etc.)
}
