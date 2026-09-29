<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use App\Models\Clieforne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ColaboradorController extends Controller
{
    public function index(Request $request)
    {
        $query = Colaboradores::with(['empresaInfo'])->whereNull('deleted_at');

        // Filtros
        if ($request->filled('status')) {
            if ($request->status == 'ativo') {
                $query->where('ativo', 1);
            } elseif ($request->status == 'inativo') {
                $query->where('ativo', 0);
            }
        }

        if ($request->filled('cargo')) {
            $query->where('cargo', 'like', '%' . $request->cargo . '%');
        }

        if ($request->filled('setor')) {
            $query->where('setor', 'like', '%' . $request->setor . '%');
        }

        if ($request->filled('empresa')) {
            $query->where('empresa', $request->empresa);
        }

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }

        if ($request->filled('cpf')) {
            $query->where('cpf', 'like', '%' . $request->cpf . '%');
        }

        // Filtro por data de admissão
        if ($request->filled('admissao_inicio') && $request->filled('admissao_fim')) {
            $query->whereBetween('admissao', [
                $request->admissao_inicio,
                $request->admissao_fim
            ]);
        }

        $colaboradores = $query->orderBy('nome')->paginate(20);

        // Totais para os cards
        $totalColaboradores = Colaboradores::whereNull('deleted_at')->count();
        $totalAtivos = Colaboradores::whereNull('deleted_at')->where('ativo', 1)->count();
        $totalInativos = Colaboradores::whereNull('deleted_at')->where('ativo', 0)->count();
        $totalAdmitidosMes = Colaboradores::whereNull('deleted_at')
            ->whereMonth('admissao', date('m'))
            ->whereYear('admissao', date('Y'))
            ->count();

        // Listas para filtros
        $cargos = Colaboradores::whereNull('deleted_at')
            ->select('cargo')
            ->distinct()
            ->whereNotNull('cargo')
            ->orderBy('cargo')
            ->pluck('cargo');

        $setores = Colaboradores::whereNull('deleted_at')
            ->select('setor')
            ->distinct()
            ->whereNotNull('setor')
            ->orderBy('setor')
            ->pluck('setor');

        $empresas = Clieforne::whereNull('deleted_at')
            ->where('tipo', '1')
            ->orWhere('tipo', '0')
            ->orderBy('nome')
            ->get();

        $categorias = Colaboradores::whereNull('deleted_at')
            ->select('categoria')
            ->distinct()
            ->whereNotNull('categoria')
            ->orderBy('categoria')
            ->pluck('categoria');

        return view('colaboradores.index', compact(
            'colaboradores',
            'totalColaboradores',
            'totalAtivos',
            'totalInativos',
            'totalAdmitidosMes',
            'cargos',
            'setores',
            'empresas',
            'categorias'
        ));
    }

public function create()
{
    // Busca empresas (clientes e fornecedores) não deletadas
    $empresas = Clieforne::whereNull('deleted_at')
        ->whereIn('tipo', ['1', '0'])
        ->orderBy('nome')
        ->get();

    // Se não houver empresas, cria uma coleção vazia
    if (!$empresas) {
        $empresas = collect();
    }

    $ufs = [
        'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA',
        'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN',
        'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
    ];

    $niveis = [
        1 => 'Operacional',
        2 => 'Supervisão',
        3 => 'Gerência',
        4 => 'Diretoria',
        5 => 'Administrativo'
    ];

    $categorias = [
        'CLT',
        'PJ',
        'Autônomo',
        'Estagiário',
        'Terceirizado',
        'Temporário'
    ];

    $cargosComuns = [
        'Motorista',
        'Operador de Máquinas',
        'Auxiliar de Produção',
        'Técnico',
        'Supervisor',
        'Gerente',
        'Administrativo',
        'Vendedor',
        'Comprador',
        'Almoxarife',
        'Segurança',
        'Limpeza',
        'Outros'
    ];

    return view('colaboradores.create', compact(
        'empresas',
        'ufs',
        'niveis',
        'categorias',
        'cargosComuns'
    ));
}

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:45',
            'apelido' => 'nullable|string|max:45',
            'email' => 'nullable|email|max:45',
            'empresa' => 'nullable|exists:cliefornes,id',
            'telefone' => 'nullable|string|max:45',
            'cargo' => 'required|string|max:45',
            'admissao' => 'required|date',
            'funcao' => 'nullable|string|max:45',
            'cpf' => 'nullable|string|max:45',
            'cnh' => 'nullable|string|max:45',
            'setor' => 'nullable|string|max:45',
            'categoria' => 'nullable|string|max:45',
            'validade' => 'nullable|date',
            'salario' => 'nullable|numeric|min:0',
            'nascimento' => 'nullable|date',
            'nivel' => 'nullable|integer|min:1|max:5',
            'cep' => 'nullable|string|max:45',
            'uf' => 'nullable|string|max:2',
            'cidade' => 'nullable|string|max:45',
            'bairro' => 'nullable|string|max:45',
            'endereco' => 'nullable|string|max:45',
            'numero' => 'nullable|string|max:45',
            'contato' => 'nullable|string|max:45',
            'fone' => 'nullable|string|max:45',
            'ativo' => 'nullable|integer|in:0,1',
            'obs' => 'nullable|string'
        ], [
            'nome.required' => 'O nome do colaborador é obrigatório.',
            'cargo.required' => 'O cargo é obrigatório.',
            'admissao.required' => 'A data de admissão é obrigatória.',
            'admissao.date' => 'A data de admissão deve ser uma data válida.',
            'email.email' => 'O e-mail deve ser válido.',
            'empresa.exists' => 'A empresa selecionada não existe.',
            'salario.numeric' => 'O salário deve ser um valor numérico.',
            'nivel.min' => 'O nível deve ser entre 1 e 5.',
            'nivel.max' => 'O nível deve ser entre 1 e 5.',
            'uf.max' => 'A UF deve ter 2 caracteres.'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['user_id'] = session('user.id');
            $data['ativo'] = $request->has('ativo') ? 1 : 0;

            // Formatar CPF (remover caracteres não numéricos)
            if ($request->filled('cpf')) {
                $data['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);
            }

            // Formatar telefones
            if ($request->filled('telefone')) {
                $data['telefone'] = preg_replace('/[^0-9]/', '', $request->telefone);
            }

            if ($request->filled('fone')) {
                $data['fone'] = preg_replace('/[^0-9]/', '', $request->fone);
            }

            // Formatar CEP
            if ($request->filled('cep')) {
                $data['cep'] = preg_replace('/[^0-9]/', '', $request->cep);
            }

            // Formatar salário
            if ($request->filled('salario')) {
                $data['salario'] = str_replace(['.', ','], ['', '.'], $request->salario);
            }

            Colaboradores::create($data);

            DB::commit();

            return redirect()->route('colaboradores.index')
                ->with('success', 'Colaborador cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao cadastrar colaborador: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $colaborador = Colaboradores::with(['empresaInfo', 'usuario'])->findOrFail($id);

        // Formatar dados para exibição
        $colaborador->telefone_formatado = $this->formatarTelefone($colaborador->telefone);
        $colaborador->fone_formatado = $this->formatarTelefone($colaborador->fone);
        $colaborador->cpf_formatado = $this->formatarCPF($colaborador->cpf);
        $colaborador->cep_formatado = $this->formatarCEP($colaborador->cep);

        // Calcular tempo de empresa
        $tempoEmpresa = null;
        if ($colaborador->admissao) {
            $admissao = Carbon::parse($colaborador->admissao);
            $tempoEmpresa = $admissao->diff(now());
            $colaborador->tempo_empresa_formatado = $tempoEmpresa->y . ' anos, ' .
                $tempoEmpresa->m . ' meses e ' . $tempoEmpresa->d . ' dias';
        }

        return view('colaboradores.show', compact('colaborador'));
    }

    public function edit($id)
    {
        $colaborador = Colaboradores::findOrFail($id);



        $empresas = Clieforne::whereNull('deleted_at')
            ->where(function($query) {
                $query->where('tipo', '1')
                      ->orWhere('tipo', '0');
            })
            ->orderBy('nome')
            ->get();

        $ufs = [
            'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA',
            'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN',
            'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
        ];

        $niveis = [
            1 => 'Operacional',
            2 => 'Supervisão',
            3 => 'Gerência',
            4 => 'Diretoria',
            5 => 'Administrativo'
        ];

        $categorias = [
            'CLT',
            'PJ',
            'Autônomo',
            'Estagiário',
            'Terceirizado',
            'Temporário'
        ];

        $cargosComuns = [
            'Motorista',
            'Operador de Máquinas',
            'Auxiliar de Produção',
            'Técnico',
            'Supervisor',
            'Gerente',
            'Administrativo',
            'Vendedor',
            'Comprador',
            'Almoxarife',
            'Segurança',
            'Limpeza',
            'Outros'
        ];

        // Formatar datas para o input type="date"
        if ($colaborador->admissao) {
            $colaborador->admissao_format = $colaborador->admissao->format('Y-m-d');
        }
        if ($colaborador->nascimento) {
            $colaborador->nascimento_format = $colaborador->nascimento->format('Y-m-d');
        }
        if ($colaborador->validade) {
            $colaborador->validade_format = $colaborador->validade->format('Y-m-d');
        }

        return view('colaboradores.edit', compact(
            'colaborador',
            'empresas',
            'ufs',
            'niveis',
            'categorias',
            'cargosComuns'
        ));
    }

    public function update(Request $request, $id)
    {
        $colaborador = Colaboradores::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:45',
            'apelido' => 'nullable|string|max:45',
            'email' => 'nullable|email|max:45',
            'empresa' => 'nullable|exists:cliefornes,id',
            'telefone' => 'nullable|string|max:45',
            'cargo' => 'required|string|max:45',
            'admissao' => 'required|date',
            'funcao' => 'nullable|string|max:45',
            'cpf' => 'nullable|string|max:45',
            'cnh' => 'nullable|string|max:45',
            'setor' => 'nullable|string|max:45',
            'categoria' => 'nullable|string|max:45',
            'validade' => 'nullable|date',
            'salario' => 'nullable|numeric|min:0',
            'nascimento' => 'nullable|date',
            'nivel' => 'nullable|integer|min:1|max:5',
            'cep' => 'nullable|string|max:45',
            'uf' => 'nullable|string|max:2',
            'cidade' => 'nullable|string|max:45',
            'bairro' => 'nullable|string|max:45',
            'endereco' => 'nullable|string|max:45',
            'numero' => 'nullable|string|max:45',
            'contato' => 'nullable|string|max:45',
            'fone' => 'nullable|string|max:45',
            'ativo' => 'nullable|integer|in:0,1',
            'obs' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $data = $request->all();
            $data['ativo'] = $request->has('ativo') ? 1 : 0;

            // Formatar CPF (remover caracteres não numéricos)
            if ($request->filled('cpf')) {
                $data['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);
            }

            // Formatar telefones
            if ($request->filled('telefone')) {
                $data['telefone'] = preg_replace('/[^0-9]/', '', $request->telefone);
            }

            if ($request->filled('fone')) {
                $data['fone'] = preg_replace('/[^0-9]/', '', $request->fone);
            }

            // Formatar CEP
            if ($request->filled('cep')) {
                $data['cep'] = preg_replace('/[^0-9]/', '', $request->cep);
            }

            // Formatar salário
            if ($request->filled('salario')) {
                $data['salario'] = str_replace(['.', ','], ['', '.'], $request->salario);
            }

            $colaborador->update($data);

            DB::commit();

            return redirect()->route('colaboradores.index')
                ->with('success', 'Colaborador atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erro ao atualizar colaborador: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $colaborador = Colaboradores::findOrFail($id);
            $colaborador->delete();

            return redirect()->route('colaboradores.index')
                ->with('success', 'Colaborador excluído com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir colaborador: ' . $e->getMessage());
        }
    }

    public function toggleAtivo($id)
    {
        try {
            $colaborador = Colaboradores::findOrFail($id);
            $colaborador->ativo = $colaborador->ativo ? 0 : 1;
            $colaborador->save();

            $status = $colaborador->ativo ? 'ativado' : 'inativado';
            return redirect()->route('colaboradores.index')
                ->with('success', "Colaborador {$status} com sucesso!");
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao alterar status: ' . $e->getMessage());
        }
    }

    // Métodos auxiliares para formatação
    private function formatarTelefone($telefone)
    {
        if (!$telefone) return null;

        $telefone = preg_replace('/[^0-9]/', '', $telefone);
        $length = strlen($telefone);

        if ($length == 11) {
            return '(' . substr($telefone, 0, 2) . ') ' .
                   substr($telefone, 2, 5) . '-' .
                   substr($telefone, 7);
        } elseif ($length == 10) {
            return '(' . substr($telefone, 0, 2) . ') ' .
                   substr($telefone, 2, 4) . '-' .
                   substr($telefone, 6);
        }

        return $telefone;
    }

    private function formatarCPF($cpf)
    {
        if (!$cpf) return null;

        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) == 11) {
            return substr($cpf, 0, 3) . '.' .
                   substr($cpf, 3, 3) . '.' .
                   substr($cpf, 6, 3) . '-' .
                   substr($cpf, 9, 2);
        }

        return $cpf;
    }

    private function formatarCEP($cep)
    {
        if (!$cep) return null;

        $cep = preg_replace('/[^0-9]/', '', $cep);
        if (strlen($cep) == 8) {
            return substr($cep, 0, 5) . '-' . substr($cep, 5, 3);
        }

        return $cep;
    }
}
