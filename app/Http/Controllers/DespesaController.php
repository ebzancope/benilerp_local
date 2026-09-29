<?php

namespace App\Http\Controllers;

use App\Models\Despesas;
use App\Models\Clieforne;
use App\Models\Colaboradores;
use App\Models\Equipamentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DespesaController extends Controller
{

private function applyFilters($query, Request $request)
{
    return $query
        ->when($request->filled('tipoconta'), fn($q) => $q->where('tipoconta', $request->tipoconta))
        ->when($request->filled('equipamento'), fn($q) => $q->where('equipamento', $request->equipamento))
        ->when($request->filled('fornecedor'), fn($q) => $q->where('fornecedor', $request->fornecedor))
        ->when($request->filled('data_inicio') && $request->filled('data_fim'),
            fn($q) => $q->whereBetween('competencia', [$request->data_inicio, $request->data_fim]))
        ->when($request->filled('centrocustos'), fn($q) => $q->where('centrocustos', $request->centrocustos))
        ->when($request->filled('descricao'),
            fn($q) => $q->where('descricao', 'like', '%'.$request->descricao.'%'))

             // 🔍 Busca livre em descrição OU nota fiscal
        ->when($request->filled('busca'), function ($q) use ($request) {
            $term = '%'.$request->busca.'%';
            $q->where(function ($qq) use ($term) {
                $qq->where('descricao', 'like', $term)
                   ->orWhere('notafiscal', 'like', $term);
            });
        })


        ->when($request->filled('valor_min'),
            fn($q) => $q->where(DB::raw('CAST(valortotal AS DECIMAL(12,2))'), '>=', $request->valor_min))
        ->when($request->filled('valor_max'),
            fn($q) => $q->where(DB::raw('CAST(valortotal AS DECIMAL(12,2))'), '<=', $request->valor_max));
}

private function totalPendenteQuery($query)
{
    return $query->where(function ($q) {
        $q->whereNull('status')
          ->orWhereNotIn('status', ['pago', 'Pago']);
    });
}


 public function index(Request $request)
{
    session(['place' => '4']);

    $base = Despesas::with(['clieforne', 'colaborador_rel', 'equipamento_rel'])
        ->whereNull('deleted_at');

    $query = $this->applyFilters(clone $base, $request);

    // Paginação
    $despesas = $query->whereNull('deleted_at')->orderBy('competencia', 'desc')->paginate(20);

    // Totais filtrados
    $filteredQuery = clone $query;
    $totalFiltrado = $filteredQuery->sum(DB::raw('CAST(valortotal AS DECIMAL(12,2))'));

    $totalMesFiltrado = ($request->filled('data_inicio') && $request->filled('data_fim'))
        ? (clone $filteredQuery)->sum(DB::raw('CAST(valortotal AS DECIMAL(12,2))'))
        : (clone $query)
            ->whereMonth('competencia', date('m'))
            ->whereYear('competencia', date('Y'))
            ->sum(DB::raw('CAST(valortotal AS DECIMAL(12,2))'));

    $totalPendenteFiltrado = $this->totalPendenteQuery(clone $filteredQuery)
        ->sum(DB::raw('CAST(valortotal AS DECIMAL(12,2))'));

    // Totais gerais
    $totalDespesas = Despesas::whereNull('deleted_at')
      ->whereYear('competencia', date('Y'))
        ->sum(DB::raw('CAST(valortotal AS DECIMAL(12,2))'));

    $totalMes = Despesas::whereNull('deleted_at')
        ->whereMonth('competencia', date('m'))
        ->whereYear('competencia', date('Y'))
        ->sum(DB::raw('CAST(valortotal AS DECIMAL(12,2))'));

    $totalPendente = $this->totalPendenteQuery(Despesas::whereNull('deleted_at'))
        ->sum(DB::raw('CAST(valortotal AS DECIMAL(12,2))'));

    $tiposContas     = $this->getTiposContas();
    $centrosCustos   = $this->getCentrosCustos();
    $tiposDocumentos = $this->getTiposDocumentos();
    $equipamentos    = Equipamentos::whereNull('deleted_at')->orderBy('codigo', 'ASC')->get();
    $fornecedores    = Clieforne::whereNull('deleted_at')->orderBy('nome', 'ASC')->get();
    $colaboradores   = Colaboradores::whereNull('deleted_at')->orderBy('nome', 'ASC')->get();

    return view('despesas.index', compact(
        'despesas',
        'tiposContas',
        'centrosCustos',
        'tiposDocumentos',
        'equipamentos',
        'fornecedores',
        'colaboradores',
        'totalDespesas',
        'totalMes',
        'totalPendente',
        'totalFiltrado',
        'totalMesFiltrado',
        'totalPendenteFiltrado'
    ));
}

    public function create()
    {
        $tiposContas = $this->getTiposContas();
        $centrosCustos = $this->getCentrosCustos();
        $tiposDocumentos = $this->getTiposDocumentos();
        $equipamentos = Equipamentos::whereNull('deleted_at')->orderBy('codigo', 'ASC')->get();
        $fornecedores = Clieforne::whereNull('deleted_at')->orderBy('nome', 'ASC')->get();
        $colaboradores = Colaboradores::whereNull('deleted_at')->orderBy('nome', 'ASC')->get();

        return view('despesas.create', compact(
            'tiposContas',
            'centrosCustos',
            'tiposDocumentos',
            'equipamentos',
            'fornecedores',
            'colaboradores'
        ));
    }


public function store(Request $request)
{
    // Remova a linha dd($request->all());

    $validated = $request->validate([
        'competencia' => 'required|date',
        'tipoconta' => 'required|string|max:255',
        'centrocustos' => 'nullable|string|max:255',
        'tipodocumento' => 'nullable|string|max:255',
        'fornecedor' => 'nullable|exists:cliefornes,id',
        'equipamento' => 'nullable|exists:equipamentos,id',
        'colaborador' => 'nullable|exists:colaboradores,id',
        'notafiscal.required' => 'Documento obrigatória',
        'notafiscal.string' => 'Documento deve ser uma string',
        'notafiscal.max' => 'Documento deve ter no máximo 255 caracteres',
        'notafiscal.unique' => 'Documento já cadastrado',
        'quantidade' => 'nullable|numeric|min:0',
        'valorunit' => 'nullable|numeric|min:0',
        'valortotal' => 'required|numeric|min:0.01|max:9999999.99',
        'descricao' => 'nullable|string|max:10000'

        // 'adm_senha.required' => 'Senha é obrigatório',
    ]);

    Log::info('✅ Validação passou!', $validated); // 👈 LOG 1

    try {
        DB::beginTransaction();

        $despesa = new Despesas();

        $despesa->user_id = session('user.id');
        $despesa->competencia = $request->competencia;
        $despesa->tipoconta = $request->tipoconta;
        $despesa->centrocustos = $request->centrocustos;
        $despesa->tipodocumento = $request->tipodocumento;
        $despesa->equipamento = $request->equipamento;
        $despesa->colaborador = $request->colaborador;
        $despesa->fornecedor = $request->fornecedor;
        $despesa->quantidade = $request->quantidade;
        $despesa->valorunit = $request->valorunit;
        $despesa->valortotal = $request->valortotal;
        $despesa->notafiscal = $request->notafiscal;
        $despesa->descricao = $request->descricao;
        $despesa->status = 'pendente';

       // Log::info('✅ Despesa objeto criado:', $despesa->toArray()); // 👈 LOG 2

        $despesa->save();

       // Log::info('✅ Despesa salva com ID:', ['id' => $despesa->id]); // 👈 LOG 3

        DB::commit();

        return redirect()->route('despesas.index')
            ->with('success', 'Despesa cadastrada com sucesso!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('❌ Erro ao salvar despesa:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]); // 👈 LOG 4



        // código 23000 normalmente indica violação de constraint
        return back()->withErrors(['notafiscal' => 'Nota fiscal já cadastrada.'])->withInput();

          // return redirect()->back()
          //  ->with('error', 'Erro ao cadastrar despesa:  ' . $e->getMessage())
          // ->withInput();
    }
}




    public function show($id)
    {
        $despesa = Despesas::with(['clieforne', 'colaborador_rel', 'equipamento_rel', 'user'])
            ->findOrFail($id);

        $tiposContas = $this->getTiposContas();
        $centrosCustos = $this->getCentrosCustos();
        $tiposDocumentos = $this->getTiposDocumentos();
        $equipamentos = Equipamentos::whereNull('deleted_at')->get();
        $fornecedores = Clieforne::whereNull('deleted_at')->get();
        $colaboradores = Colaboradores::whereNull('deleted_at')->get();

        return view('despesas.show', compact(
            'despesa',
            'tiposContas',
            'centrosCustos',
            'tiposDocumentos',
            'equipamentos',
            'fornecedores',
            'colaboradores'
        ));
    }

    public function edit($id)
    {
        $despesa = Despesas::findOrFail($id);
        $tiposContas = $this->getTiposContas();
        $centrosCustos = $this->getCentrosCustos();
        $tiposDocumentos = $this->getTiposDocumentos();
        $equipamentos = Equipamentos::whereNull('deleted_at')->get();
        $fornecedores = Clieforne::whereNull('deleted_at')->orderBy('nome', 'asc')->get();
        $colaboradores = Colaboradores::whereNull('deleted_at')->get();

        return view('despesas.edit', compact(
            'despesa',
            'tiposContas',
            'centrosCustos',
            'tiposDocumentos',
            'equipamentos',
            'fornecedores',
            'colaboradores'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
        'competencia' => 'required|date',
        'tipoconta' => 'required|string|max:255',
        'centrocustos' => 'nullable|string|max:255',
        'tipodocumento' => 'nullable|string|max:255',
        'fornecedor' => 'nullable|exists:cliefornes,id',
        'equipamento' => 'nullable|exists:equipamentos,id',
        'colaborador' => 'nullable|exists:colaboradores,id',
        'notafiscal' => 'nullable|string|max:255',
        'quantidade' => 'nullable|numeric|min:0',
        'valorunit' => 'nullable|numeric|min:0',
        'valortotal' => 'required|numeric|min:0.01',
        'descricao' => 'nullable|string:|max:10000',
        ], [
            'competencia.before_or_equal' => 'A data de competência não pode ser futura.',
            'tipoconta.in' => 'Tipo de conta inválido.',
            'valor.min' => 'O valor deve ser maior que zero.',
            'valor.max' => 'O valor não pode ser superior a R$ 9.999.999,99.',
            'fornecedor.exists' => 'Fornecedor selecionado não existe.',
            'equipamento.exists' => 'Equipamento selecionado não existe.',
            'colaborador.exists' => 'Colaborador selecionado não existe.',
            'descricao.max' => 'A descrição não pode ter mais que 10000 caracteres.'
        ]);

        try {
            DB::beginTransaction();
            $despesa = Despesas::findOrFail($id);
            $despesa->competencia = $request->competencia;
            $despesa->tipoconta = $request->tipoconta;
            $despesa->centrocustos = $request->centrocustos;
            $despesa->tipodocumento = $request->tipodocumento;
            $despesa->equipamento = $request->equipamento;
            $despesa->colaborador = $request->colaborador;
            $despesa->fornecedor = $request->fornecedor;
            $despesa->quantidade = $request->quantidade;
            $despesa->valorunit = $request->valorunit;
            $despesa->valortotal = $request->valortotal;
            $despesa->notafiscal = $request->notafiscal;
            $despesa->descricao = $request->descricao;
            $despesa->valor = $request->valor;
            $despesa->save();
            DB::commit();

            return redirect()->route('despesas.index')
                ->with('success', 'Despesa atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Erro ao atualizar despesa: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $despesa = Despesas::findOrFail($id);
            $despesa->deleted_at = now();
            $despesa->save();

            return redirect()->route('despesas.index')
                ->with('success', 'Despesa excluída com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Erro ao excluir despesa: ' . $e->getMessage());
        }
    }

    // Métodos auxiliares para os selects
    private function getTiposContas()
{
    return [
        '101' => 'Aluguel',
        '102' => 'Conta de Água',
        '103' => 'Conta de Energia',
        '104' => 'Conta de Telefone',
        '105' => 'Contribuição Sindical',
        '106' => 'Despesas Previdenciárias (GPS)',
        '107' => 'FGTS',
        '108' => 'Internet',
        '109' => 'IPTU',
        '110' => 'Vale Refeição',
        '111' => 'Salário',
        '112' => '13º Salário',
        '113' => 'Férias',
        '114' => 'IRRF (Darf)',
        '115' => 'Medicina do Trabalho',
        '116' => 'Rescisão Trabalhista',
        '117' => 'Taxa Bancária',
        '118' => 'Uniformes',
        '119' => 'Honorários',
        '120' => 'Retirada Pró-Labore',
        '121' => 'IPVA',

        '201' => 'Abastecimento da Frota',
        '202' => 'Alimentação',
        '203' => 'Comissão de Vnd e Gratificação',
        '204' => 'Hora Extra',
        '205' => 'Hospedagem',
        '206' => 'Pedágio',
        '207' => 'Manutenção Predial',
        '208' => 'Lubrificantes',
        '209' => 'Manutenção da Frota',
        '210' => 'Material de Consumo/Limpeza',
        '211' => 'Material de Escritório',
        '212' => 'Matéria Prima',
        '213' => 'Despesa Bancária e com Cartão',
        '214' => 'Despesa Eventual',
        '215' => 'IRPJ (Darf)',
        '216' => 'Saúde Pessoal e EPI',
        '217' => 'Serviços de Terceiros',
        '218' => 'Simples Nacional (DAS)',
        '219' => 'Seguros',
        '220' => 'Correios/Licitação/Sindicato',
        '221' => 'Fretes/Transportes',
        '222' => 'Tributo Municipal',
        '223' => 'Tributo Estadual (Dae)',

        '301' => 'Compra de Mercadoria Estoque',
        '302' => 'Propaganda e Publicidade',
        '303' => 'Consultoria e Assist Técnica',
        '304' => 'Treinamento',
        '305' => 'Software, Câmera, Som, TV',
        '306' => 'Compra de Imobilizado',
        '307' => 'Nova Sede',

        '401' => 'Empréstimos de Terceiros',
        '402' => 'Assessoria Contábil',
        '403' => 'Juros de empréstimos',
        '404' => 'Pagamento de empréstimos',
        '405' => 'Doação',
        '406' => 'Aumento de Capital',
        '407' => 'Adiantamento a Sócio',
        '408' => 'Assessoria Jurídica',
        '409' => 'Patrocínios',

        '501' => 'Receita da Locação',
        '502' => 'Receita de Vendas',
        '503' => 'Venda de Imobilizado',
        '504' => 'Multas de transito',
        '505' => 'Outros',
    ];
}
    private function getCentrosCustos()
    {
        return [
            '1' => 'Diária',
            '2' => 'Frete',
            '3' => 'H Máquina',
            '4' => 'Material'
        ];
    }

    private function getTiposDocumentos()
    {
        return [
            '1' => 'Boleto',
            '2' => 'Cartão',
            '3' => 'Cheque',
            '4' => 'Contrato',
            '5' => 'Darf',
            '6' => 'Débito aut',
            '7' => 'Duplicata',
            '8' => 'Honorário',
            '9' => 'N Fiscal',
            '12' => 'Recibo',
            '13' => 'Notinha',
            '10' => 'Pix',
            '11' => 'Outros'
        ];
    }


                /**
             * Exibir relatório para impressão
             */
            public function relatorio(Request $request)
            {
                $query = Despesas::with(['clieforne', 'colaborador_rel', 'equipamento_rel'])
                    ->whereNull('deleted_at');

                // Aplicar os mesmos filtros da listagem
                if ($request->filled('tipoconta')) {
                    $query->where('tipoconta', $request->tipoconta);
                }

                if ($request->filled('equipamento')) {
                    $query->where('equipamento', $request->equipamento);
                }

                if ($request->filled('fornecedor')) {
                    $query->where('fornecedor', $request->fornecedor);
                }

                if ($request->filled('data_inicio') && $request->filled('data_fim')) {
                    $query->whereBetween('competencia', [
                        $request->data_inicio,
                        $request->data_fim
                    ]);
                }

                if ($request->filled('centrocustos')) {
                    $query->where('centrocustos', $request->centrocustos);
                }

                if ($request->filled('descricao')) {
                    $query->where('descricao', 'like', '%' . $request->descricao . '%');
                }

                if ($request->filled('valor_min')) {
                    $query->where(DB::raw('CAST(valortotal AS DECIMAL(10,2))'), '>=', $request->valor_min);
                }

                if ($request->filled('valor_max')) {
                    $query->where(DB::raw('CAST(valortotal AS DECIMAL(10,2))'), '<=', $request->valor_max);
                }

                $despesas = $query->orderBy('competencia', 'desc')->get();

                // Cálculos
                $totalDespesas = Despesas::whereNull('deleted_at')
                    ->whereYear('competencia', date('Y'))
                    ->sum(DB::raw('CAST(valortotal AS DECIMAL(10,2))'));

                $totalMes = Despesas::whereNull('deleted_at')
                    ->whereMonth('competencia', date('m'))
                    ->whereYear('competencia', date('Y'))
                    ->sum(DB::raw('CAST(valortotal AS DECIMAL(10,2))'));

                $totalPendente = Despesas:: whereNull('deleted_at')
                    ->where(function($q) {
                        $q->whereNull('status')
                        ->orWhere('status', '!=', 'pago')
                        ->orWhere('status', '!=', 'Pago');
                    })
                    ->sum(DB::raw('CAST(valortotal AS DECIMAL(10,2))'));

                $tiposContas = $this->getTiposContas();
                $centrosCustos = $this->getCentrosCustos();
                $tiposDocumentos = $this->getTiposDocumentos();
                $fornecedores = Clieforne::whereNull('deleted_at')->orderBy('nome', 'ASC')->get();

                return view('despesas.relatorio-print', compact(
                    'despesas',
                    'tiposContas',
                    'centrosCustos',
                    'tiposDocumentos',
                    'fornecedores',
                    'totalDespesas',
                    'totalMes',
                    'totalPendente'
                ));
            }

                    /**
         * Exibir relatório para impressão
         */
        public function imprimir(Request $request)
        {
            session(['place' => '4']);

            $dataInicio = $request->data_inicio ?? date('Y-m-01');
            $dataFim = $request->data_fim ?? date('Y-m-t');

            try {
                // Formatar datas
                $dataInicioFormatada = \Carbon\Carbon::createFromFormat('Y-m-d', $dataInicio)->format('d/m/Y');
                $dataFimFormatada = \Carbon\Carbon::createFromFormat('Y-m-d', $dataFim)->format('d/m/Y');
            } catch (\Exception $e) {
                $dataInicioFormatada = date('d/m/Y');
                $dataFimFormatada = date('d/m/Y');
            }

            // Buscar despesas agrupadas por tipo
            $despesasPorTipo = Despesas::selectRaw('tipoconta, SUM(CAST(valortotal AS DECIMAL(10,2))) as total, COUNT(*) as count')
                ->whereBetween('competencia', [$dataInicio, $dataFim])
                ->whereNull('deleted_at')
                ->groupBy('tipoconta')
                ->orderByDesc('total')
                ->get();

            // Cálculos
            $totalDespesas = Despesas::whereBetween('competencia', [$dataInicio, $dataFim])
                ->whereNull('deleted_at')
                ->sum(DB::raw('CAST(valortotal AS DECIMAL(10,2))'));

            $totalRegistros = Despesas::whereBetween('competencia', [$dataInicio, $dataFim])
                ->whereNull('deleted_at')
                ->count();

            // Calcular média diária
            $dias = \Carbon\Carbon::createFromFormat('Y-m-d', $dataInicio)
                ->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d', $dataFim)) + 1;

            $mediaDiaria = $totalDespesas > 0 ? $totalDespesas / $dias : 0;

            // Maior despesa
            $maiorDespesaObj = Despesas::whereBetween('competencia', [$dataInicio, $dataFim])
                ->whereNull('deleted_at')
                ->orderByDesc(DB::raw('CAST(valortotal AS DECIMAL(10,2))'))
                ->first();

            $maiorDespesa = $maiorDespesaObj ? (float)$maiorDespesaObj->valortotal : 0;

            $tiposContas = $this->getTiposContas();

            return view('despesas.imprimir', compact(
                'despesasPorTipo',
                'totalDespesas',
                'totalRegistros',
                'mediaDiaria',
                'maiorDespesa',
                'tiposContas',
                'dataInicio',
                'dataFim',
                'dataInicioFormatada',
                'dataFimFormatada'
            ));
        }

        /**
 * Imprimir despesas respeitando os filtros aplicados
 */
public function imprimirFiltrado(Request $request)
{
    session(['place' => '4']);

    // Query base
    $base = Despesas::with(['clieforne', 'colaborador_rel', 'equipamento_rel'])
        ->whereNull('deleted_at');

    // Aplicar os mesmos filtros da listagem
    $query = $this->applyFilters(clone $base, $request);

    // Buscar todas as despesas (sem paginação para impressão)
    $despesas = $query->orderBy('competencia', 'asc')->get();

    // Calcular totais baseados no filtro
    $totalGeral = $despesas->sum(function($d) {
        return (float)$d->valortotal;
    });

    $totalRegistros = $despesas->count();

    // Agrupar por tipo de conta
    $despesasPorTipo = $despesas->groupBy('tipoconta')->map(function($grupo) {
        return [
            'total' => $grupo->sum(function($d) { return (float)$d->valortotal; }),
            'count' => $grupo->count()
        ];
    })->sortByDesc('total');

    // Agrupar por fornecedor
    $despesasPorFornecedor = $despesas->groupBy('fornecedor')->map(function($grupo) {
        return [
            'nome' => $grupo->first()->clieforne->nome ?? 'Sem Fornecedor',
            'total' => $grupo->sum(function($d) { return (float)$d->valortotal; }),
            'count' => $grupo->count()
        ];
    })->sortByDesc('total')->take(10);

    // Agrupar por centro de custos
    $despesasPorCentro = $despesas->groupBy('centrocustos')->map(function($grupo) {
        return [
            'total' => $grupo->sum(function($d) { return (float)$d->valortotal; }),
            'count' => $grupo->count()
        ];
    })->sortByDesc('total');

    // Calcular média diária se houver filtro de data
    $mediaDiaria = 0;
    $dataInicioFormatada = '';
    $dataFimFormatada = '';

    if ($request->filled('data_inicio') && $request->filled('data_fim')) {
        try {
            $inicio = \Carbon\Carbon::createFromFormat('Y-m-d', $request->data_inicio);
            $fim = \Carbon\Carbon::createFromFormat('Y-m-d', $request->data_fim);
            $dias = $inicio->diffInDays($fim) + 1;
            $mediaDiaria = $totalGeral > 0 ? $totalGeral / $dias : 0;
            $dataInicioFormatada = $inicio->format('d/m/Y');
            $dataFimFormatada = $fim->format('d/m/Y');
        } catch (\Exception $e) {
            // Fallback
        }
    } else {
        // Usar mês atual como padrão
        $dataInicioFormatada = date('01/m/Y');
        $dataFimFormatada = date('t/m/Y');
        $dias = date('t');
        $mediaDiaria = $totalGeral > 0 ? $totalGeral / $dias : 0;
    }

    // Maior despesa
    $maiorDespesa = $despesas->max(function($d) {
        return (float)$d->valortotal;
    }) ?? 0;

    // Menor despesa
    $menorDespesa = $despesas->min(function($d) {
        return (float)$d->valortotal;
    }) ?? 0;

    // Ticket médio
    $ticketMedio = $totalRegistros > 0 ? $totalGeral / $totalRegistros : 0;

    // Informações dos filtros aplicados
    $filtrosAplicados = [];
    if ($request->filled('tipoconta')) {
        $filtrosAplicados['Tipo de Conta'] = $this->getTiposContas()[$request->tipoconta] ?? $request->tipoconta;
    }
    if ($request->filled('equipamento')) {
        $equip = Equipamentos::find($request->equipamento);
        $filtrosAplicados['Equipamento'] = $equip->codigo ?? 'N/A';
    }
    if ($request->filled('fornecedor')) {
        $forn = Clieforne::find($request->fornecedor);
        $filtrosAplicados['Fornecedor'] = $forn->nome ?? 'N/A';
    }
    if ($request->filled('centrocustos')) {
        $filtrosAplicados['Centro de Custos'] = $this->getCentrosCustos()[$request->centrocustos] ?? $request->centrocustos;
    }
    if ($request->filled('descricao')) {
        $filtrosAplicados['Descrição'] = $request->descricao;
    }
    if ($request->filled('valor_min')) {
        $filtrosAplicados['Valor Mínimo'] = 'R$ ' . number_format($request->valor_min, 2, ',', '.');
    }
    if ($request->filled('valor_max')) {
        $filtrosAplicados['Valor Máximo'] = 'R$ ' . number_format($request->valor_max, 2, ',', '.');
    }

    $tiposContas = $this->getTiposContas();
    $centrosCustos = $this->getCentrosCustos();
    $tiposDocumentos = $this->getTiposDocumentos();

    return view('despesas.imprimir-filtrado', compact(
        'despesas',
        'despesasPorTipo',
        'despesasPorFornecedor',
        'despesasPorCentro',
        'totalGeral',
        'totalRegistros',
        'mediaDiaria',
        'maiorDespesa',
        'menorDespesa',
        'ticketMedio',
        'tiposContas',
        'centrosCustos',
        'tiposDocumentos',
        'dataInicioFormatada',
        'dataFimFormatada',
        'filtrosAplicados'
    ));
}
}
