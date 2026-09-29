<?php

namespace App\Http\Controllers;

use App\Models\Abastecimento;
use App\Models\Clieforne;
use App\Models\Colaboradores;
use App\Models\Agenda;
use App\Models\Equipamentos;
use App\Models\faturas;
use App\Models\numoservico;
use App\Models\numoservicos;
use App\Models\User;
use App\Models\view_abastecimento;
use App\Models\view_os_fatura;
use App\Models\view_os_geral;
use App\Services\Operations;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function home()

    { // load user's data

        try {


$dadosBoletos = DB::table('boletos')
    ->selectRaw('
        COUNT(*) as total_boletos,
        COUNT(CASE WHEN pago = 0 OR pago IS NULL THEN 1 END) as total_aberto,
        COALESCE(SUM(CASE WHEN pago = 0 OR pago IS NULL THEN valor END), 0) as valor_aberto,
        COUNT(CASE WHEN pago = 1 THEN 1 END) as total_pago,
        COALESCE(SUM(CASE WHEN pago = 1 THEN valor END), 0) as valor_pago,
        COUNT(CASE WHEN (pago = 0 OR pago IS NULL) AND vencimento < CURDATE() THEN 1 END) as vencidos,
        COUNT(CASE WHEN (pago = 0 OR pago IS NULL) AND vencimento >= CURDATE() AND vencimento <= DATE_ADD(CURDATE(), INTERVAL 7 DAY) THEN 1 END) as a_vencer
    ')
    ->whereNull('deleted_at')
    ->whereBetween('vencimento', [date('Y-m-d'), date('Y-m-d', strtotime('+7 days'))])
    // ADICIONE ESTA CONDIÇÃO SE FOR APLICAR O FILTRO DE PAGO=0 DO SEU CONTROLLER
    ->where('pago', 0)
    ->first();


            session(['place' => '0']);
            $id = session('user.id');
            $agendas = User::find($id)->agendas()->whereNull('deleted_at')->orderBy('agendata', 'desc')->get()->toArray();

             $dataFatura = $this->getTotaisFaturaDashboard();


            return view('home', [
                'totalAberto' => $dadosBoletos->total_aberto ?? 0,
                'valorAberto' => $dadosBoletos->valor_aberto ?? 0,
                'totalPago' => $dadosBoletos->total_pago ?? 0,
                'valorPago' => $dadosBoletos->valor_pago ?? 0,
                'vencidos' => $dadosBoletos->vencidos ?? 0,
                'aVencer' => $dadosBoletos->a_vencer ?? 0,
                'agendas' => $agendas,
                 'totais' => $dataFatura['totais'],
            ]);
        } catch (\Exception $e) {
            session(['place' => '0']);
            $id = session('user.id');
            $agendas = User::find($id)->agendas()->whereNull('deleted_at')->orderBy('agendata', 'desc')->get()->toArray();
            // Em caso de erro, retorna valores zerados
            return view('home', [
                'totalAberto' => 0,
                'valorAberto' => 0,
                'totalPago' => 0,
                'valorPago' => 0,
                'vencidos' => 0,
                'aVencer' => 0,
                'agendas' => $agendas
            ]);
        }
    }
    public function selectFatMaquina()
    {
        session(['place' => '4']);
        $querys = Equipamentos::query();
        $equipamentos = $querys->whereNull('deleted_at')->orderBy('codigo', 'ASC')->paginate(1000);


        $queryc = colaboradores::query();
        $colaboradores = $queryc->whereNull('deleted_at')->orderBy('nome', 'ASC')->paginate(1000);

        return view('selectFatMaquina', compact('equipamentos', 'colaboradores'));
    }




        public function fatprint(Request $request)

    {
        session(['place' => '4']);
        setlocale(LC_TIME, 'pt_BR.UTF-8');

        $request->validate([
            'tex_equipamento' => 'nullable|string',
            'tex_colaborador' => 'nullable|string',
            'tex_dataini'     => 'required|date',
            'tex_datafim'     => 'required|date|after_or_equal:tex_dataini',
        ]);

        $numcolab = $request->tex_colaborador ? Operations::decryptId($request->tex_colaborador) : 0;
        $numequi  = $request->tex_equipamento ? Operations::decryptId($request->tex_equipamento) : 0;

        $datainis = date('Y-m-d H:i:s', strtotime(str_replace(['/', '-'], '-', $request->tex_dataini)));
        $datafims = date('Y-m-d H:i:s', strtotime(str_replace(['/', '-'], '-', $request->tex_datafim)));

        //->whereMonth('vencimento', date('m'))
        //->whereYear('vencimento', date('Y'))

        $query = view_os_fatura::where('aprovada', '1')
            ->whereNull('deleted_at')
            ->when($datainis && $datafims, fn($q) => $q->whereBetween('datacadfat', [$datainis, $datafims]))
            ->when($numcolab > 0, fn($q) => $q->where('operador', $numcolab))
            ->when($numequi  > 0, fn($q) => $q->where('veiculo', $numequi))
            ->orderBy('datacadfat', 'asc');

        // coleção completa já filtrada
        $registros = $query->get();

        // separa por tipo de frota
        $maquinas  = $registros->filter(fn($f) => intval($f->codigo) >= 300);
        $caminhoes = $registros->filter(fn($f) => intval($f->codigo) <= 299);

        $totais = [
            'maquinas' => [
                'horas' => $maquinas->sum('tothmaquina'),
                'valor' => $maquinas->sum('totmaquina'),
            ],
            'caminhoes' => [
                'valor' => $caminhoes->sum('totala'),
            ],
        ];
        $totais['geral'] = $totais['maquinas']['valor'] + $totais['caminhoes']['valor'];

        return view('fatprint', [
            'maquinas'   => $maquinas,
            'caminhoes'  => $caminhoes,
            'registros'  => $registros,
            'totais'     => $totais,
            'datainis'   => $datainis,
            'datafims'   => $datafims,
            'numequi'    => $numequi,
            'numcolab'   => $numcolab,
        ]);
    }





private function getTotaisFaturaDashboard()
{
    $registros = view_os_fatura::where('aprovada', '1')
        ->whereNull('deleted_at')
        ->whereMonth('datacadfat', date('m'))
        ->whereYear('datacadfat', date('Y'))
        ->orderBy('datacadfat', 'asc')
        ->get();

    $maquinas  = $registros->filter(fn($f) => intval($f->codigo) >= 300);
    $caminhoes = $registros->filter(fn($f) => intval($f->codigo) <= 299);

    $totais = [
        'maquinas' => [
            'horas' => $maquinas->sum('tothmaquina'),
            'valor' => $maquinas->sum('totmaquina'),
        ],
        'caminhoes' => [
            'valor' => $caminhoes->sum('totala'),
        ],
    ];

    $totais['geral'] = $totais['maquinas']['valor'] + $totais['caminhoes']['valor'];

    return compact('maquinas', 'caminhoes', 'registros', 'totais');
}










    public function marcarComoAprovada(faturas $faturas)
    {
        $faturas->update(['aprovada' => '1']); // aprovada

        return redirect()->back()->withInput()
            ->with('success', 'Marcado como Aprovada');
    }


    public function marcarComoReprovada(faturas $faturas)
    {
        $faturas->update(['aprovada' => '0']); // reprovada

        return redirect()->back()->withInput()
            ->with('success', 'Marcado como Reprovada');
    }

     public function marcarComoDeletada(faturas $faturas)
    {
        $faturas->update(['aprovada' => '0']); // reprovada

        return redirect()->back()->withInput()
            ->with('success', 'Marcado como Reprovada');
    }

    public function fatura(Request $request, $id)
    {
    session(['place' => '2']);

    $id = Operations::decryptId($id);



    if ($id === null) {
        return redirect()->route('fatura')->with('mensagem', 'Erro, Tente Novamente');
    }

    // Query base para faturas
    $query = Faturas::where('numos', $id)->whereNull('deleted_at')->orderBy('numnota', 'desc');

    // Aplicar filtros
    if ($request->filled('status')) {
        if ($request->status == 'aprovada') {
            $query->where('aprovada', '>', '0');
        } elseif ($request->status == 'pending') {
            $query->where('aprovada', '0');
        }
    }

    if ($request->filled('equipamento')) {
        $query->where('veiculo', $request->equipamento);
    }

    if ($request->filled('data_inicio')) {
        $query->whereDate('datacadfat', '>=', $request->data_inicio);
    }

    if ($request->filled('data_fim')) {
        $query->whereDate('datacadfat', '<=', $request->data_fim);
    }

    if ($request->filled('text_fatura')) {
        $query->where('numnota', 'like', '%' . $request->text_fatura . '%');
    }

    // Executar query com paginação
    $faturas = $query->paginate(100);

    // Buscar dados relacionados
    $cliefornes = View_os_geral::where('idnumos', $id)->whereNull('numos_deleted')->first();
    $equipamentos = Equipamentos::whereNull('deleted_at')->get();

    // Calcular totais considerando todos os registros (sem filtros para os cards)
    $totalQuery = Faturas::where('numos', $id)->whereNull('deleted_at');
    $allFaturas = $totalQuery->get();

    $totalFaturas = $allFaturas->count();
    $totalAprovadas = $allFaturas->where('aprovada', '1')->count();
    $totalPendentes = $allFaturas->where('aprovada', '0')->count();



    $valorTotal = $allFaturas->where('aprovada', '1')->whereNull('deleted_at')->sum(function($fatura) {
        return ($fatura->totmaquina ?? 0) + ($fatura->totala ?? 0);
    });



    $totalAprovado = $allFaturas->where('aprovada', '1')->sum(function($fatura) {
        return ($fatura->totmaquina ?? 0) + ($fatura->totala ?? 0);
    });

    $totalPendenteValor = $allFaturas->where('aprovada', '0')->sum(function($fatura) {
        return ($fatura->totmaquina ?? 0) + ($fatura->totala ?? 0);
    });

    return view('fatura', compact(
        'cliefornes',
        'faturas',
        'equipamentos',
        'totalFaturas',
        'totalAprovadas',
        'totalPendentes',
        'valorTotal',
        'totalAprovado',
        'totalPendenteValor'
    ));
}



    public function cadfatura($id)
    {
        session(['place' => '2']);

        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('oservico')->with('mensagem',  'Erro , Tente Novamente');
        }

        $viewOSGeral = view_os_geral::where('idnumos', $id)->whereNull('numos_deleted')->first();

        $query = clieforne::query();
        $cliefornes = $query->whereNull('deleted_at')->orderBy('nome', 'ASC')->paginate(1000);

        $querys = Equipamentos::query();
        $equipamentos = $querys->whereNull('deleted_at')->orderBy('codigo', 'ASC')->paginate(1000);

        $querys = Colaboradores::query();
        $colaboradores = $querys->whereNull('deleted_at')->orderBy('nome', 'ASC')->paginate(1000);

        return view('cadfatura', compact('cliefornes', 'equipamentos', 'colaboradores', 'viewOSGeral'));
    }
    public function cadfaturaSubmit(Request $request)
    {
        session(['place' => '2']);






       // Validação (mantém)
       // $request->validate([
       //     'numnota' => 'required|numeric|unique:faturas,numnota'
       // ]);



        $idnumos = Operations::decryptId($request->tex_idnumos);
        if ($idnumos == null) {
            //die('erro');  Debugging C
            return redirect()->route('cadfatura')->with('mensagem', ' Erro tente novamente 1');
        }
        $cliente = Operations::decryptId($request->tex_cliente);
        if ($cliente == null) {
            //die('erro');  Debugging C
            return redirect()->route('cadfatura')->with('mensagem', ' Erro tente novamente 2');
        }


        // VERIFICAÇÃO DE DUPLICIDADE
        //  $faturaExistente = faturas::where('numnota', $request->tex_numoscli)
        //      ->whereNull('deleted_at')
        //      ->first();

        //  if ($faturaExistente) {
        //      return redirect()->route('cadfatura', ['id' => $numoscli])->with('mensagem', 'Já existe uma fatura cadastrada para esta OS');
        //  }

        //  print $faturaExistente . "<br>";
        //  print "CUIDADO ERRO FATAL !!!";
        //  exit();


        $datacad1 = $request->tex_datacadfat;
        $formattedDate = str_replace(['/', '-'], '-', $datacad1); // Replace '/' and '-' with '.'
        $datacadfat =  date('Y-m-d H:i:s', strtotime($formattedDate)); // Output: 2025-08-21 14:30:00


        $totmaquina1 = $request->totmaquina;
        $totmaquina = str_replace(['R$', ''], '', $totmaquina1); // Replace '/' and '-' with '.'

        $totala1 = $request->totala;
        $totala = str_replace(['R$', ''], '', $totala1); // Replace '/' and '-' with '.'

        //$valora1 = $request->valora;
        //$valora = str_replace(',', '.', $valora1);

        $valora = floatval(str_replace([',', 'R$', ' '], ['.',  '', ''], $request->valora));

        //$valhora1 = $request->valhora;
       // $valhora = str_replace(',', '.', $valhora1);

        $valhora = floatval(str_replace([',', 'R$', ' '], ['.',  '', ''], $request->valhora));

        // print $numoscli;
        // die();

        // create new fatura
        $cadfat = new  faturas();
        $cadfat->user_id = session('user.id');
        $cadfat->numos = $idnumos;
        $cadfat->cliente = $cliente;
        $cadfat->datacadfat = $datacadfat;
        $cadfat->numnota = $request->input('numnota');
        $cadfat->veiculo = $request->input('tex_veiculo');
        $cadfat->operador = $request->input('tex_operador');
        $cadfat->horimini = $request->input('horimini');
        $cadfat->horimfim = $request->input('horimfim');
        $cadfat->valhora = $valhora;
        $cadfat->tothmaquina = $request->input('tothmaquina');
        $cadfat->totmaquina = $totmaquina;
        $cadfat->qtda = $request->input('qtda');
        $cadfat->descri = $request->input('tex_descri');
        $cadfat->valora = $valora;
        $cadfat->totala = $totala;
        $cadfat->localservico = $request->input('tex_localservico');
        $cadfat->horaini = $request->input('horaini');
        $cadfat->horafini = $request->input('horafini');
        $cadfat->servicos = $request->input('text_servicos');
        $cadfat->questionada = $request->input('tex_questionada');
        $cadfat->aprovada = $request->input('tex_aprovada');
        $cadfat->fretecolhe = $request->input('tex_fretecolhe', 0);
        $cadfat->save();

        $faturas = faturas::where('numos', $idnumos)->whereNull('deleted_at')->orderBy('datacadfat', 'desc')->get();
        $cliefornes = view_os_geral::where('idnumos', $idnumos)->whereNull('numos_deleted')->first();
        $equipamentos = equipamentos::whereNull('deleted_at')->get();

        return redirect()->route('fatura', ['id' => Crypt::encrypt($idnumos)])
            ->with('faturas', $faturas)
            ->with('equipamentos', $equipamentos)
            ->with('cliefornes', $cliefornes)
            ->with('equipamentos', $equipamentos)
            ->with('mensagem', 'Fatura cadastrada com sucesso!');



        // return view('fatura', ['cliefornes' => $cliefornes, 'faturas' => $faturas, 'id' => $numoscli, 'equipamentos' => $equipamentos]);
    }
    public function editfatura(Request $request)
    {
        session(['place' => '2']);

        $id = Operations::decryptId($request->id);
        if ($id === null) {
            return redirect()->route('fatura')->with('mensagem',  'Erro , Tente Novamente');
        }


        $idnumos = Operations::decryptId($request->idnumos);
        if ($idnumos === null) {
            return redirect()->route('fatura')->with('mensagem',  'Erro , Tente Novamente');
        }

        $viewOSGeral = view_os_geral::where('idnumos', $idnumos)->whereNull('numos_deleted')->first();
        $query = clieforne::query();
        $cliefornes = $query->whereNull('deleted_at')->orderBy('nome', 'ASC')->paginate(1000);
        $querys = Equipamentos::query();
        $equipamentos = $querys->whereNull('deleted_at')->orderBy('codigo', 'ASC')->paginate(1000);
        $querys = Colaboradores::query();
        $colaboradores = $querys->whereNull('deleted_at')->orderBy('nome', 'ASC')->paginate(1000);
        $faturaedit = faturas::where('id', $id)->first();
        $user = $faturaedit->user; // Obtém o usuário associado ao clieforne
        return view('editfatura', compact('cliefornes', 'equipamentos', 'colaboradores', 'viewOSGeral', 'faturaedit', 'user'));
    }
    public function editfaturaSubmit(Request $request)
    {


        $id = Operations::decryptId($request->id);
        if ($id === null) {
            return redirect()->route('fatura')->with('mensagem',  'Erro , Tente Novamente');
        }

        $numoscli = Operations::decryptId($request->tex_numoscli);
        if ($numoscli == null) {
            //die('erro');  Debugging C
            return redirect()->route('cadfatura')->with('mensagem', ' Erro tente novamente');
        }
        $cliente = Operations::decryptId($request->tex_cliente);
        if ($cliente == null) {
            //die('erro');  Debugging C
            return redirect()->route('cadfatura')->with('mensagem', ' Erro tente novamente');
        }


        $datacad1 = $request->tex_datacadfat;
        $formattedDate = str_replace(['/', '-'], '-', $datacad1); // Replace '/' and '-' with '.'
        $datacadfat =  date('Y-m-d H:i:s', strtotime($formattedDate)); // Output: 2025-08-21 14:30:00

        $totmaquina1 = $request->totmaquina;
        $totmaquina = str_replace(['R$', ''], '', $totmaquina1); // Replace '/' and '-' with '.'

        $totala1 = $request->totala;
        $totala = str_replace(['R$', ''], '', $totala1); // Replace '/' and '-' with '.'

        $valora1 = $request->valora;
        $valora = str_replace(',', '.', $valora1);

        $valhora1 = $request->valhora;
        $valhora = str_replace(',', '.', $valhora1);

        $editfat = faturas::find($id);
        $editfat->user_id = session('user.id');
        $editfat->numos = $numoscli;
        $editfat->cliente = $cliente;
        $editfat->datacadfat = $datacadfat;
        $editfat->numnota = $request->input('tex_numnota');
        $editfat->veiculo = $request->input('tex_veiculo');
        $editfat->operador = $request->input('tex_operador');
        $editfat->horimini = $request->input('horimini');
        $editfat->horimfim = $request->input('horimfim');
        $editfat->valhora = $valhora;
        $editfat->tothmaquina = $request->input('tothmaquina');
        $editfat->totmaquina = $totmaquina;
        $editfat->qtda = $request->input('qtda');
        $editfat->descri = $request->input('tex_descri');
        $editfat->valora = $valora;
        $editfat->totala = $totala;
        $editfat->localservico = $request->input('tex_localservico');
        $editfat->horaini = $request->input('horaini');
        $editfat->horafini = $request->input('horafini');
        $editfat->servicos = $request->input('text_servicos');
        $editfat->questionada = $request->input('tex_questionada');
        $editfat->aprovada = $request->input('tex_aprovada');
        $editfat->fretecolhe = $request->input('tex_fretecolhe');

        // print $request->input('tex_fretecolhe');
        //die();


        $editfat->save();

        $faturas = faturas::where('numos', $numoscli)->whereNull('deleted_at')->get();
        $cliefornes = view_os_geral::where('idnumos', $numoscli)->whereNull('numos_deleted')->first();
        $equipamentos = Equipamentos::whereNull('deleted_at')->get();

        // $numosId = $request->input('tex_numoscli');

        return redirect()->route('fatura', ['id' => Crypt::encrypt($numoscli)])
            ->with('faturas', $faturas)
            ->with('cliefornes', $cliefornes)
            ->with('equipamentos', $equipamentos)
            ->with('mensagem', 'Fatura editada com sucesso!');


        //fatura pucha as os destes cliente
        // $faturas = faturas::where('numos', $id)->whereNull('deleted_at')->get();
        // $cliefornes = view_os_geral::where('idnumos', $id)->first();

        // return view('fatura', ['cliefornes' => $cliefornes, 'faturas' => $faturas]);

        /// print "I'm creating a new cadfatura.";
        // return redirect()->url()->previous();

        //return redirect()->to('/oservico')->with('mensagem', 'Editada com Sucesso!.');
    }
    public function faturadeltada($id)
    {
        session(['place' => '2']);
        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('fatura')->with('mensagem',  'Erro , Tente Novamente');
        }
        //fatura pucha as os destes cliente
        $faturas = faturas::where('numos', $id)->orderBy('datacadfat', 'desc')
            ->whereNull('deleted_at')->get();
        $cliefornes = view_os_geral::where('idnumos', $id)->whereNull('numos_deleted')->first();

        return view('fatura', ['cliefornes' => $cliefornes, 'faturas' => $faturas]);
    }
    public function deletefatura($id)
    {
        $ids = Crypt::decrypt($id);

        $query = faturas::query();
        $numos = $query->whereNull('deleted_at')->where('id', $ids)->first();

        if ($numos == null) {
            //die('erro');  Debugging C
            return redirect()->route('oservico')->with('mensagem', ' Erro tente novamente');
        }

        return view('deletefatura', ['id' => $id, 'numos' => $numos]);
    }
    public function deletefaturaConfirm(Request $request, $id)
    {

        // print "I'm Crsting deletefaturaConfirm ";
        // die();

        $idDecrypt = Operations::decryptId($id);
        $numoscli = $request->numos;


        //print $idDecrypt . "id <br>";
        //print $request->numos . " numos <br>";
        // die();


        $faturas = faturas::where('numos', $numoscli)->whereNull('deleted_at')->get();
        $cliefornes = view_os_geral::where('idnumos', $numoscli)->whereNull('numos_deleted')->first();
        $equipamentos = equipamentos::whereNull('deleted_at')->get();
        $mensagem = "Deletado com Sucesso!.";
        // $numosId = $request->input('tex_numoscli');
        $crono = faturas::find($idDecrypt);
        $crono->delete();

        return redirect()->route('fatura', ['id' => Crypt::encrypt($numoscli)])
            ->with('faturas', $faturas)
            ->with('cliefornes', $cliefornes)
            ->with('equipamentos', $equipamentos)
            ->with('mensagem', $mensagem);


        // find the agenda by id
        //$numoservico = numoservico::find($id);
        // find the agenda by id

        //  $fatura = faturas::find($id);
        // $fatura->delete();


        //   return redirect()
        //  ->route('deletefaturaConfirma')
        //  ->with('mensagem', 'Deletado com Sucesso!.')
        // ->with('id', $id);


        // $faturas = faturas::where('numos', $idDecrypt)->whereNull('deleted_at')->get();
        // $cliefornes = view_os_geral::where('idnumos', $idDecrypt)->first();


        //return view('deletefatura', ['id' => $id, 'numos' => $numos]);

        // print $cliefornes . "cliefornes <br>";
        //print $faturas . " faturas <br>";
        // print $mensagem . " mensagem <br>";
        // print $id . "id <br>";
        // print $numos . " numos <br>";
        //die();



        // return redirect()
        // ->route('fatura')
        //  ->with('mensagem', 'Deletado com Sucesso!.')
        // ->with('cliefornes', $cliefornes)
        // ->with('numos',  $faturas)
        //   ->with('id', $id);


        //return view('fatura', ['cliefornes' => $cliefornes, 'faturas' => $faturas, 'id' => $idDecrypt, 'mensagem' => $mensagem]);
    }
public function deletefaturaConfirma(Request $request, $faturas, $numos)
{
    try {
        // Decriptar os IDs
        $idFaturaDecrypt = Operations::decryptId($faturas);
        $numosDecrypt = Operations::decryptId($numos);

        // Encontrar e deletar a fatura
        $fatura = faturas::find($idFaturaDecrypt);

        if (!$fatura) {
            return redirect()->back()->with('error', 'Fatura não encontrada.');
        }

        $fatura->delete();

        return redirect()->route('fatura', ['id' => Crypt::encrypt($numosDecrypt)])
            ->with('mensagem', 'Fatura excluída com sucesso!');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Erro ao excluir fatura: ' . $e->getMessage());
    }
}






        public function marcarComoAberta(numoservicos $oservicos)
    {
        $oservicos->update(['estatus' => '0']); // Aberta

        return redirect()->back()->withInput()
            ->with('success', 'Marcado como Aberta!');
    }

     public function marcarComoFechada(numoservicos $oservicos)
    {
        $oservicos->update(['estatus' => '1']); // Fechada

        return redirect()->back()->withInput()
            ->with('success', 'Marcado como Fechada!');
    }


public function oservico(Request $request)
{
    session(['place' => '2']);

    // Buscar dados para filtros
    $equipamentos = Equipamentos::orderBy('codigo', 'asc')->get();
    $cliefornes = Clieforne::orderBy('nome', 'asc')->get();

    // Calcular próxima OS
    $totalnumos = view_os_geral:: whereNull('numos_deleted')->max('idnumos') + 1;

    // Query base
    $query = view_os_geral::whereNull('numos_deleted');

    // Aplicar filtros
    if ($request->filled('text_nome')) {
        $searchTerm = $request->text_nome;
        $query->where(function($q) use ($searchTerm) {
            $q->where('nomeclie', 'like', '%' . $searchTerm . '%')
              ->orWhere('apelidoclie', 'like', '%' . $searchTerm . '%')
              ->orWhere('idnumos', 'like', '%' . $searchTerm .  '%');
        });
    }

    // ✅ FILTRO DE STATUS (INCLUINDO FATURAS PENDENTES)
    if ($request->filled('status')) {
        if ($request->status == 'aberta') {
            $query->where('estatusos', '!=', '1');
        } elseif ($request->status == 'fechada') {
            $query->where('estatusos', '1');
        } elseif ($request->status == 'execucao') {
            $query->where('estatusos', '3');
        } elseif ($request->status == 'pendente') {
            // ✅ NOVO:  Filtrar por faturas pendentes (aprovada = 0)
            $query->whereIn('idnumos', function($subquery) {
                $subquery->select('numos')
                    ->from('faturas')
                    ->where('aprovada', '0')
                    ->whereNull('deleted_at');
            });
        }
    }

    if ($request->filled('cliente')) {
        $query->where('idcliefornes', $request->cliente);
    }

    if ($request->filled('data_inicio')) {
        $query->whereDate('dataoscli', '>=', $request->data_inicio);
    }

    if ($request->filled('data_fim')) {
        $query->whereDate('dataoscli', '<=', $request->data_fim);
    }

    // Ordenação e paginação
    $oservico = $query->orderBy('idnumos', 'DESC')->paginate(50);

    // Calcular totais para os cards (SEMPRE sem filtros)
    $totalAbertas = view_os_geral:: whereNull('numos_deleted')
        ->where('estatusos', '!=', '1')
        ->count();

    $totalFechadas = view_os_geral::whereNull('numos_deleted')
        ->where('estatusos', '1')
        ->count();

    $totalExecucao = view_os_geral:: whereNull('numos_deleted')
        ->where('estatusos', '3')
        ->count();

    $totalPendentes = view_os_geral:: whereNull('numos_deleted')
        ->where('estatusos', '4')
        ->count();

    // ✅ NOVO: Calcular faturas pendentes
    $totalFatPendentes = view_os_fatura::whereNull('deleted_at')
        ->where('aprovada', '0')
        ->count();

    // ✅ NOVO: Passar o status ativo para a view
    $statusFiltro = $request->input('status', null);

    return view('oservico', compact(
        'oservico',
        'totalnumos',
        'cliefornes',
        'equipamentos',
        'totalAbertas',
        'totalFechadas',
        'totalExecucao',
        'totalFatPendentes',
        'totalPendentes',
        'statusFiltro'  // ✅ NOVO
    ));
}
    public function cadoservico()
    {
        session(['place' => '2']);


        $query = clieforne::query();
        $cliefornes = $query->whereNull('deleted_at')->orderBy('nome', 'ASC')->paginate(9999);
        $totalnumos = view_os_geral::query()->whereNull('numos_deleted')
            ->max('idnumos') + 1;

        return view('cadoservico', compact('cliefornes', 'totalnumos'));
        // print "I'm creating a new cadoservico.";
    }
    public function cadoservicoSubmit(Request $request)
    {
        session(['place' => '2']);

        // tex_cliente
        // tex_data
        $datacad1 = $request->tex_data;
        $formattedDate = str_replace(['/', '-'], '-', $datacad1); // Replace '/' and '-' with '.'
        $datainis =  date('Y-m-d H:i:s', strtotime($formattedDate)); // Output: 2025-08-21 14:30:00

        // create new OS
        $oservico = new numoservicos();
        $oservico->user_id = session('user.id');
        $oservico->dataos = $datainis;
        $oservico->numos = $request->input('num_os');
        $oservico->cliente = $request->input('tex_cliente');
        $oservico->descricao = $request->input('tex_desc');
        $oservico->save();

        return redirect()->route('oservico')->with('mensagem', 'Cadastrado com Sucesso!');
    }
    public function editoservico($id)
    {



        session(['place' => '2']);

        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('oservico')->with('mensagem',  'Erro , Tente Novamente');
        }

        $query = clieforne::query();
        $cliefornes = $query->whereNull('deleted_at')->orderBy('nome', 'ASC')->paginate(9999);
        $numoservico = numoservico::find($id);
        return view('editoservico', ['numoservico' => $numoservico, 'cliefornes' => $cliefornes]);
        // print "I'm creating a new editcronograma.";
    }
     public function editoservicoSubmit(Request $request, $id)
    {
        session(['place' => '2']);


    // Em um controller
    //dd($id); // Verifique se $id existe




        $id = Operations::decryptId($request->id);
        if ($id == null) {
            //die('erro');  Debugging C
            return redirect()->route('oservico')->with('mensagem', ' Erro tente novamente');
        }



        $datacad1 = $request->tex_data;
        $formattedDate = str_replace(['/', '-'], '-', $datacad1); // Replace '/' and '-' with '.'
        $dataoss =  date('Y-m-d H:i:s', strtotime($formattedDate)); // Output: 2025-08-21 14:30:00


        $editoservico = numoservico::find($id);
        $editoservico->user_id = session('user.id');
        $editoservico->cliente = $request->tex_cliente;
        $editoservico->descricao = $request->input('tex_desc');
        $editoservico->estatus = $request->tex_estatus;
        $editoservico->dataos =  $dataoss;
        $editoservico->save();


        return redirect()->route('oservico')->with('mensagem', 'Editado com Sucesso!');
        //print "I'm creating a new editoservicoSubmit.";
    }
    public function deleteoservico($id)
    {
        session(['place' => '2']);
        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('oservico')->with('error', 'Erro tesnte novamente');
        }
        // find the agenda by id
        //$numoservico = numoservico::find($id);
        $numoservicoview = view_os_geral::where('idnumos', $id)->whereNull('numos_deleted')->first();
//print $id . " id <br>";
//print $numoservicoview->nomeclie . " numoservicoview <br>";
//die();

        // show delete confirmation view
        return view('deleteoservico', ['numoservicoview' => $numoservicoview]);
    }
    public function deleteoservicoConfirm($id)
    {
        session(['place' => '2']);
        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('oservico')->with('error', 'Erro tesnte novamente');
        }

//print $id . "numos = id <br>";

//die();


        faturas::where('numos', $id)->whereNull('deleted_at')->delete();





        $crono = numoservico::find($id);
        $crono->delete();






        // redirect to home with success message
        return redirect()->route('oservico')->with('mensagem', 'Deletado com Sucesso!.');

        //print "I'm creating a new deleteoservicoConfirm.";
    }
    public function osprint($id)
    {
        session(['place' => '4']);

        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('fatura')->with('mensagem',  'Erro , Tente Novamente');
        }

        $oservicos = view_os_geral::where('idnumos', $id)->whereNull('numos_deleted')->first();
        $totalMaquina = view_os_fatura::where('numos', $id)->where('aprovada', '1')->whereNull('deleted_at')->sum('totmaquina');

        $totala = view_os_fatura::where('numos', $id)->where('aprovada', '1')->whereNull('deleted_at')->sum('totala');
        $faturasrgeral =  view_os_fatura::where('numos', $id)->where('aprovada', '1')->whereNull('deleted_at')->get();
        $idclieid = view_os_fatura::query()->where('numos', $id)->whereNull('deleted_at')->first();
        $idclie = $idclieid->idclie;
        $cliefornes = clieforne::query()->where('id', $idclie)->first();
        $faturasz = faturas::where('numos', $id)->whereNull('deleted_at')->first();
        $faturas = faturas::where('numos', $id)->orderBy('datacadfat', 'desc')
            ->whereNull('deleted_at')->get();
        $i = 0;



        $totaisPorMaquina = view_os_fatura::where('numos', $id)
            ->where('aprovada', '1')
            ->whereNull('deleted_at')
            ->where('codigo', '>=', '300')
            ->select('modelo', DB::raw('SUM(tothmaquina) as total_maquina'))
            ->groupBy('modelo')
            ->get();

        return view('osprint', ['cliefornes' => $cliefornes, 'totaisPorMaquina' => $totaisPorMaquina, 'faturas' => $faturas, 'faturasz' => $faturasz, 'faturasrgeral' => $faturasrgeral, 'totala' => $totala, 'totalMaquina' => $totalMaquina, 'i' => $i, 'oservicos' => $oservicos]);
    }


    // Abastecimentos
    public function Abastecimento(Request $request)
    {
        session(['place' => '5']);
        $id = session('user.id');

        $query = view_abastecimento::query()->whereNull('abastecimentos_deleted');
        if ($request->has('text_nome') && !empty($request->text_nome)) {
            $searchTerm = $request->text_nome;
            $query->where('cliefornes_nome', 'like', '%' . $searchTerm . '%')
                ->orWhere('equipamentos_codigo', 'like', '%' . $searchTerm . '%')->orderByDesc('abastecimentos_id');
        }

        $Abastecimento = $query->paginate(1000);

        return view('Abastecimento', compact('Abastecimento'));
    }
    public function cadAbastecimento()
    {
        session(['place' => '5']);
        $query = clieforne::query();
        $cliefornes = $query->whereNull('deleted_at')->orderBy('nome', 'ASC')->paginate(1000);
        $querys = Equipamentos::query();
        $equipamentos = $querys->whereNull('deleted_at')->orderBy('codigo', 'ASC')->paginate(1000);

        return view('abastecimentos.create', compact('cliefornes', 'equipamentos'));
    }
    public function cadAbastecimentoSubmit(Request $request)
    {



        $qtdax = $request->input('qtda');
        $qtdas = str_replace(',', '.', $qtdax);

        $descontox = $request->input('desconto');
        $descontos = str_replace(',', '.', $descontox);

        $totalax = $request->input('totala');
        $totalas = str_replace(',', '.', $totalax);

        // create new Abastecimento
        $abastecimento = new Abastecimento();
        $abastecimento->user_id = session('user.id');


        $datacad1 = $request->tex_data;
        $formattedDate = str_replace(['/', '-'], '-', $datacad1); // Replace '/' and '-' with '.'
        $datacads =  date('Y-m-d H:i:s', strtotime($formattedDate)); // Output: 2025-08-21 14:30:00
        $abastecimento->datacad = $datacads;
        $abastecimento->fornecedor = $request->input('tex_fornecedor');
        $abastecimento->veiculo = $request->input('tex_veiculos');
        $abastecimento->combustivel = $request->input('tex_combustivel');
        $abastecimento->qtda = $qtdas;
        $abastecimento->desconto = $descontos;
        $abastecimento->totala = $totalas;
        $abastecimento->save();



        // redirec to home

        return redirect()->route('Abastecimento')->with('mensagem', 'Cadastrado com Sucesso!');
    }
    public function editAbastecimento($id)
    {
        session(['place' => '5']);
        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('Abastecimento')->with('mensagem', 'Erro , Tente Novamente');
        }

        $query = clieforne::query();
        $cliefornes = $query->whereNull('deleted_at')->orderBy('nome', 'ASC')->paginate(1000);
        $querys = Equipamentos::query();
        $equipamentos = $querys->whereNull('deleted_at')->orderBy('codigo', 'ASC')->paginate(1000);
        $abastecimento = Abastecimento::find($id);

        return view('editAbastecimento', ['cliefornes' => $cliefornes, 'equipamentos' => $equipamentos, 'abastecimento' => $abastecimento]);
    }
    public function editAbastecimentoSubmit(Request $request)
    {
        session(['place' => '5']);

        $id = Operations::decryptId($request->id);
        if ($id == null) {
            //die('erro');  Debugging C
            return redirect()->route('Abastecimento')->with('mensagem', ' Erro tente novamente');
        }


        $litrosx = $request->litros;
        $litross = str_replace(',', '.', $litrosx);

        $qtdax = $request->qtda;
        $qtdas = str_replace(',', '.', $qtdax);

        $descontox = $request->desconto;
        $descontos = str_replace(',', '.', $descontox);

        $totalax = $request->totala;
        $totalas = str_replace(',', '.', $totalax);

        $abastecimento = Abastecimento::find($id);
        $abastecimento->user_id = session('user.id');

        $datacad1 = $request->tex_data;
        $formattedDate = str_replace(['/', '-'], '-', $datacad1); // Replace '/' and '-' with '.'
        $datacads =  date('Y-m-d H:i:s', strtotime($formattedDate)); // Output: 2025-08-21 14:30:00

        $abastecimento->datacad = $datacads;
        $abastecimento->fornecedor = $request->tex_fornecedor;
        $abastecimento->veiculo = $request->tex_veiculos;
        $abastecimento->combustivel = $request->tex_combustivel;
        $abastecimento->litros = $litross;
        $abastecimento->qtda = $qtdas;
        $abastecimento->desconto = $descontos;
        $abastecimento->totala = $totalas;
        $abastecimento->save();

        return redirect()->route('Abastecimento')->with('mensagem', 'Editado com Sucesso!');
    }
    public function deleteAbastecimento($id)
    {

        session(['place' => '5']);
        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('Abastecimento')->with('error', 'Erro tesnte novamente');
        }
        // find the agenda by id
        $abastecimento = Abastecimento::find($id);


        // show delete confirmation view
        return view('deleteAbastecimento', ['abastecimento' => $abastecimento]);

        // show delete confirmation view


    }
    public function deleteAbastecimentoConfirm($id)
    {
        session(['place' => '5']);

        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('Abastecimento')->with('error', 'Erro tente novamente.');
        }
        // find the agenda by id
        $abastecimento = Abastecimento::find($id);
        $abastecimento->delete();

        // redirect to home with success message
        return redirect()->route('Abastecimento')->with('mensagem', 'Deletado com Sucesso!.');
    }
    // Colaboradores




    // Frota -> Equipamento
    public function Equipamentos(Request $request)
    {
        session(['place' => '5']);
        $id = session('user.id');

        $query = Equipamentos::query();
        if ($request->has('text_nome') && !empty($request->text_nome)) {
            $searchTerm = $request->text_nome;
            $query->where('codigo', 'like', '%' . $searchTerm . '%')
                ->orWhere('modelo', 'like', '%' . $searchTerm . '%')->orderByDesc('id');
        }


        $equipamentos = $query->whereNull('deleted_at')->orderBy('codigo', 'ASC')->paginate(2000);
        return view('equipamentos.index', compact('equipamentos'));
    }
    public function cadEquipamento()
    {
        session(['place' => '5']);
        return view('equipamentos.create',);
    }
    public function cadEquipamentoSubmit(Request $request)
    {
        session(['place' => '5']);


        // validade request
        $request->validate(

            //reules
            [

                'tex_codigo' => 'required|min:3|max:10'
            ],
            // error
            [

                'tex_codigo.required' => 'Código é obrigatório!',
                'tex_codigo.min' => 'Código é inválido!',
                'tex_codigo.max' => 'Código é inválido!',
            ]
        );

        $equipamentos = new equipamentos();

        if ($request->hasFile("image")) {
            $images = $request->file("image")->store("equipamentos", "public");
        }


        $equipamentos->user_id = session('user.id');
        $equipamentos->codigo = $request->input('tex_codigo');
        $equipamentos->modelo = $request->input('tex_modelo');
        $equipamentos->categoria = $request->input('tex_categoria');
        $equipamentos->marca = $request->input('tex_marca');
        $equipamentos->cor = $request->input('tex_cor');
        $equipamentos->placa = $request->input('tex_placa');
        $equipamentos->ano = $request->input('tex_ano');
        $equipamentos->renavam = $request->input('tex_renavam');
        $equipamentos->chassi = $request->input('tex_chassi');
        $equipamentos->potencia = $request->input('tex_potencia');
        $equipamentos->motor = $request->input('tex_motor');
        $equipamentos->prop = $request->input('tex_prop');
        $equipamentos->apolice = $request->input('tex_apolice');
        $equipamentos->valor = $request->input('tex_valor');
        $equipamentos->alienacao = $request->input('tex_alienacao');
        $equipamentos->venc = $request->input('tex_venc');
        $equipamentos->observacao = $request->input('tex_obs');
        if (!empty($request->image)) {
            $equipamentos->image = $images;
        }

        $equipamentos->save();



        // redirec to home

        return redirect()->route('equipamentos.index')->with('mensagem', 'Cadastrado com Sucesso!');
    }
    public function editEquipamento($id)
    {

        session(['place' => '5']);
        $id = Operations::decryptId($id);
        $equipamento = Equipamentos::find($id);
        return view('editEquipamento', ['equipamento' => $equipamento]);
    }
    public function editEquipamentoSubmit(Request $request)
    {
        session(['place' => '5']);

        // validade request
        $request->validate(

            //reules
            //reules
            [

                'tex_codigo' => 'required|min:3|max:10'
            ],
            // error
            [

                'tex_codigo.required' => 'Código é obrigatório!',
                'tex_codigo.min' => 'Código é inválido!',
                'tex_codigo.max' => 'Código é inválido!',
            ]
        );
        //check if id exists
        // decrypt the id
        $id = Operations::decryptId($request->id);
        if ($id == null) {
            //die('erro');  Debugging C
            return redirect()->route('equipamentos.edit', ['id' => $request->id])->with('mensagem', ' Erro tente novamente');
        }



        if ($request->hasFile("image")) {
            if ($request->image && Storage::disk("public")->exists($request->image)) {
                Storage::disk("public")->delete($request->image);
            }
            $images = $request->file("image")->store("equipamentos", "public");
        }




        // find the agenda by id
        $equipamentos = equipamentos::find($id);

        // update clieforne
        $equipamentos->user_id = session('user.id');
        $equipamentos->codigo = $request->tex_codigo;
        $equipamentos->modelo = $request->tex_modelo;
        $equipamentos->categoria = $request->tex_categoria;
        $equipamentos->marca = $request->tex_marca;
        $equipamentos->cor = $request->tex_cor;
        $equipamentos->placa = $request->tex_placa;
        $equipamentos->ano = $request->tex_ano;
        $equipamentos->renavam = $request->tex_renavam;
        $equipamentos->chassi = $request->tex_chassi;
        $equipamentos->potencia = $request->tex_potencia;
        $equipamentos->motor = $request->tex_motor;
        $equipamentos->prop = $request->tex_prop;
        $equipamentos->apolice = $request->tex_apolice;
        $equipamentos->valor = $request->tex_valor;
        $equipamentos->alienacao = $request->tex_alienacao;
        $equipamentos->venc = $request->tex_venc;
        $equipamentos->observacao = $request->tex_obs;
        if (!empty($request->image)) {
            $equipamentos->image = $images;
        }

        $equipamentos->save();

        // redirec to home

        return redirect()->route('equipamentos.index')->with('mensagem', 'Editado com Sucesso!');
    }
    public function deleteEquipamento($id)
    {
        session(['place' => '5']);

        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('equipamentos.index')->with('error', 'Invalid ID.');
        }
        // find the equipamento by id
        $equipamento = equipamentos::find($id);


        // show delete confirmation view
        return view('deleteEquipamento', ['equipamento' => $equipamento]);

        // show delete confirmation view




    }
    public function deleteEquipamentoConfirm($id)
    {
        session(['place' => '5']);

        $id = Operations::decryptId($id);
        if ($id === null) {
            return redirect()->route('equipamentos.index')->with('error', 'Invalid ID.');
        }
        // find the agenda by id
        $equipamentos = equipamentos::find($id);
        $equipamentos->delete();

        // redirect to home with success message
        return redirect()->route('equipamentos.index')->with('mensagem', 'Deletado com Sucesso!.');
    }
    // Cliente e Fornecedores

    public function Agenda(Request $request)
    {

        session(['place' => '2']);
        $id = session('user.id');

        $query = Agenda::query();

        if ($request->has('text_nome') && !empty($request->text_nome)) {
            $searchTerm = $request->text_nome;
            $query->where('titulo', 'like', '%' . $searchTerm . '%')
                ->orWhere('observacao', 'like', '%' . $searchTerm . '%')
                ->orWhere('mensagem', 'like', '%' . $searchTerm . '%')->orderByDesc('id');
        }

        // Aplicar ordenação
        if ($request->has('sortColumn') && $request->has('sortDirection')) {
            $query->orderBy($request->input('sortColumn'), $request->input('sortDirection'));
        }


        $agendas = $query->whereNull('deleted_at')->orderBy('agendata', 'ASC')->paginate(2000);

        // Area de testes

        // $agendatas = $query->whereBetween('age', [$agendata, $ageTo]);

        // $agendatas = $query->whereNull('agendata')->whereBetween('agendata');

        return view('Agenda', ['agendas' => $agendas]);
    }

    // Usuários
    public function usuarios()
    {
        session(['place' => '1']);
        $id = session('user.id');
        $usuarios = User::find($id)->usuarios()->whereNull('deleted_at')->get()->toArray();
        return view('Usuarios', ['usuarios' => $usuarios]);
    }
    // Orderm de Serviços - OS
    public function cados()
    {
        session(['place' => '2']);
        print "I'm creating a new .";
    }
    public function boletos()
    {
        session(['place' => '4']);
        $id = session('user.id');
        $boletos = User::find($id)->boletos()->whereNull('deleted_at')->get()->toArray();
        return view('Boletos', ['boletos' => $boletos]);
    }
    public function despesas()
    {
        session(['place' => '4']);
        $id = session('user.id');
        $despesas = User::find($id)->despesas()->whereNull('deleted_at')->get()->toArray();
        // $user = User::find($id)->toArray();
        return view('Despesas', ['despesas' => $despesas]);
    }
    public function relatorios()
    {
        session(['place' => '4']);
        $id = session('user.id');
        $relatorios = User::find($id)->relatorios()->whereNull('deleted_at')->get()->toArray();
        // $user = User::find($id)->toArray();
        return view('Relatorios', ['relatorios' => $relatorios]);
    }
    public function almoxarifado()
    {
        session(['place' => '3']);
        $id = session('user.id');
        $almoxarifado = User::find($id)->almoxarifado()->whereNull('deleted_at')->get()->toArray();
        // $user = User::find($id)->toArray();
        return view('Almoxarifado', ['almoxarifado' => $almoxarifado]);
    }


    public function termos()
    {
        session(['place' => '2']);
        print "I'm creating a new termos.";
        // $id = session('user.id');
        // $termos = User::find($id)->termos()->whereNull('deleted_at')->get()->toArray();
        // $termos = "x";
         return view('termos.index');
        }
}
