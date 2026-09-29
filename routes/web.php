<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ImportacaoController;
use App\Http\Controllers\ClieforneController;
use App\Http\Controllers\CronogramaController;
use App\Http\Controllers\EquipamentoController;
use App\Http\Controllers\BoletoController;
use App\Http\Controllers\AbastecimentoController;
use App\Http\Controllers\RelatorioAbastecimentoController;
use App\Http\Controllers\RelatorioDespesaController;
use App\Http\Controllers\DespesaController;
use App\Http\Controllers\AlmoxarifadoController;
use App\Http\Controllers\RelatorioFaturamentoController;
use App\Http\Controllers\ColaboradorController;
use App\Http\Controllers\RelatorioDespesasController;
use App\Http\Controllers\PrecoEquipamentoController;
use App\Http\Controllers\OrcamentoController;
use App\Http\Controllers\CobrancaController;


// Auth routes - user not logged
Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginSubmit'])->name('login.submit');
});

// Logout (acessível por todos)
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/// Recupera senha
    Route::get('/password/forgot', [AuthController::class, 'showForgotForm'])->name('password.request');
    Route::post('/password/email', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

    Route::get('/termos', function () {return view('termos.index');
});



// App routes - user logged
Route::middleware([CheckIsLogged::class])->group(function () {
    // Rotas principais
    Route::get('/', [MainController::class, 'home'])->name('home');
    Route::get('/home', [MainController::class, 'home'])->name('home');
    Route::get('/Usuarios', [MainController::class, 'Usuarios'])->name('Usuarios');
    Route::get('/Boletos', [MainController::class, 'Boletos'])->name('Boletos');
    Route::get('/Abastecimento', [MainController::class, 'Abastecimento'])->name('Abastecimento');
    Route::get('/Agenda', [MainController::class, 'Agenda'])->name('Agenda');
    Route::get('/Colaboradores', [MainController::class, 'Colaboradores'])->name('Colaboradores');
    Route::get('/Relatorios', [MainController::class, 'Relatorios'])->name('Relatorios');
    Route::get('/Despesas', [MainController::class, 'Despesas'])->name('Despesas');
    Route::get('/cados', [MainController::class, 'cados'])->name('cados');
    Route::get('/cadboleto', [MainController::class, 'cadboleto'])->name('cadboleto');
    Route::get('/os', [MainController::class, 'os'])->name('os');


    // ==================== USUÁRIOS ====================  Users Management
    Route::resource('users', UserController::class);
    Route::get('/users/{user}/toggle-approval', [UserController::class, 'toggleApproval'])->name('users.toggle-approval');
    Route::get('/users/report/access', [UserController::class, 'accessReport'])->name('users.access-report');


    // ==================== EQUIPAMENTOS ====================
    Route::prefix('equipamentos')->group(function () {
        // Rotas estáticas primeiro
        Route::get('/dashboard', [EquipamentoController::class, 'dashboard'])->name('equipamentos.dashboard');
        Route::get('/create', [EquipamentoController::class, 'create'])->name('equipamentos.create');

        // Rotas raiz
        Route::get('/', [EquipamentoController::class, 'index'])->name('equipamentos.index');
        Route::post('/', [EquipamentoController::class, 'store'])->name('equipamentos.store');

        // Rotas com parâmetros (ÚLTIMAS)
        Route::get('/{id}', [EquipamentoController::class, 'show'])->name('equipamentos.show');
        Route::get('/{id}/edit', [EquipamentoController::class, 'edit'])->name('equipamentos.edit');
        Route::put('/{id}', [EquipamentoController::class, 'update'])->name('equipamentos.update');
        Route::delete('/{id}', [EquipamentoController::class, 'destroy'])->name('equipamentos.destroy');
    });

    // ==================== ALMOXARIFADO ====================
    Route::resource('almoxarifado', AlmoxarifadoController::class);

    Route::prefix('almoxarifado')->group(function () {
        // Rotas estáticas primeiro
        Route::get('/relatorio/movimentacoes', [AlmoxarifadoController::class, 'relatorio'])->name('almoxarifado.relatorio');

        // Rotas com parâmetros (últimas)
        Route::get('/{almoxarifado}/entrada', [AlmoxarifadoController::class, 'createEntrada'])->name('almoxarifado.entrada');
        Route::post('/{almoxarifado}/entrada', [AlmoxarifadoController::class, 'storeEntrada'])->name('almoxarifado.entrada.store');
        Route::get('/{almoxarifado}/saida', [AlmoxarifadoController::class, 'createSaida'])->name('almoxarifado.saida');
        Route::post('/{almoxarifado}/saida', [AlmoxarifadoController::class, 'storeSaida'])->name('almoxarifado.saida.store');
    });

// ==================== CRONOGRAMA ====================

// rota de impressão precisa vir antes do resource
Route::get('cronograma/relatorio/print', [CronogramaController::class, 'print'])->name('cronograma.print');

Route::resource('cronograma', CronogramaController::class);

Route::prefix('cronograma')->group(function () {
    Route::post('/{cronograma}/marcar-pago', [CronogramaController::class, 'marcarComoPago'])->name('cronograma.marcar-pago');
    Route::post('/{cronograma}/marcar-execucao', [CronogramaController::class, 'marcarComoExecucao'])->name('cronograma.marcar-execucao');
    Route::post('/{cronograma}/marcar-agendar', [CronogramaController::class, 'marcarComoAgendar'])->name('cronograma.marcar-agendar');
    Route::post('/{cronograma}/marcar-Finalizado', [CronogramaController::class, 'marcarComoFinalizado'])->name('cronograma.marcar-Finalizado');
});

    // ==================== IMPORTAÇÃO ====================
    Route::prefix('importacao')->group(function () {
        Route::get('/abastecimento', [ImportacaoController::class, 'importForm'])->name('importacao.form');
        Route::post('/abastecimento', [ImportacaoController::class, 'import'])->name('importacao.processar');
    });

    // ==================== DESPESAS ====================

    Route::get('/relatorio/despesas', [RelatorioDespesasController::class, 'index'])
    ->name('relatorio.despesas');


    Route::prefix('despesas')->group(function () {
        // Rotas estáticas primeiro
        Route::get('/', [DespesaController::class, 'index'])->name('despesas.index');
        Route::get('/create', [DespesaController::class, 'create'])->name('despesas.create');
        Route::post('/', [DespesaController::class, 'store'])->name('despesas.store');

        // Rotas com parâmetros (últimas)
        Route::get('/{despesa}', [DespesaController::class, 'show'])->name('despesas.show');
        Route::get('/{despesa}/edit', [DespesaController::class, 'edit'])->name('despesas.edit');
        Route::put('/{despesa}', [DespesaController::class, 'update'])->name('despesas.update');
        Route::delete('/{despesa}', [DespesaController::class, 'destroy'])->name('despesas.destroy');
        Route::post('/{id}/restore', [DespesaController::class, 'restore'])->name('despesas.restore');

        Route::get('/despesas/relatorio', [DespesaController::class, 'relatorio'])->name('despesas.relatorio');

        Route::get('/despesas/imprimir', [DespesaController::class, 'imprimir'])->name('despesas.imprimir')->middleware('auth');
        Route::get('/despesas/imprimir-filtrado', [DespesaController::class, 'imprimirFiltrado'])->name('despesas.imprimir-filtrado');

    });

    // ==================== RELATÓRIOS ====================
    Route::prefix('relatorios')->group(function () {
        // Despesas
        Route::get('/despesas', [RelatorioDespesaController::class, 'index'])->name('relatorios.despesas.index');
        Route::get('/despesas/pdf', [RelatorioDespesaController::class, 'exportarPDF'])->name('relatorios.despesas.pdf');
        Route::get('/despesas/excel', [RelatorioDespesaController::class, 'exportarExcel'])->name('relatorios.despesas.excel');
        Route::get('/despesas/consolidado', [RelatorioDespesaController::class, 'relatorioConsolidado'])->name('relatorios.despesas.consolidado');
        Route::get('/despesas/exportar', [RelatorioDespesaController::class, 'exportarExcel'])->name('relatorios.despesas.exportar');

             Route::get('/relatorios/despesas/imprimir', [RelatorioDespesasController:: class, 'imprimir'])->name('relatorios.despesas.imprimir')->middleware('auth');



        // Abastecimentos
        Route::get('/abastecimentos/consumo-veiculos', [RelatorioAbastecimentoController::class, 'consumoVeiculos'])
            ->name('relatorios.abastecimentos.consumo-veiculos');
        Route::get('/abastecimentos/consumo-fornecedores', [RelatorioAbastecimentoController::class, 'consumoFornecedores'])
            ->name('relatorios.abastecimentos.consumo-fornecedores');
        Route::get('/abastecimentos/consumo-combustiveis', [RelatorioAbastecimentoController::class, 'consumoCombustiveis'])
            ->name('relatorios.abastecimentos.consumo-combustiveis');
        Route::get('/abastecimentos/evolucao-mensal', [RelatorioAbastecimentoController::class, 'evolucaoMensal'])
            ->name('relatorios.abastecimentos.evolucao-mensal');
    });

    // ==================== ABASTECIMENTOS ====================
    Route::resource('abastecimentos', AbastecimentoController::class);

    // ==================== BOLETOS ====================
    Route::resource('boletos', BoletoController::class);

    Route::prefix('boletos')->group(function () {
        Route::post('/{boleto}/marcar-pago', [BoletoController::class, 'marcarComoPago'])->name('boletos.marcar-pago');
        Route::post('/{boleto}/marcar-pendente', [BoletoController::class, 'marcarComoPendente'])->name('boletos.marcar-pendente');
    });

    // ==================== CLIEFORNES ====================
    Route::prefix('cliefornes')->group(function () {
        Route::get('/', [ClieforneController::class, 'index'])->name('cliefornes.index');
        Route::get('/create', [ClieforneController::class, 'create'])->name('cliefornes.create');
        Route::post('/', [ClieforneController::class, 'store'])->name('cliefornes.store');
        Route::get('/{id}', [ClieforneController::class, 'show'])->name('cliefornes.show');
        Route::get('/{id}/edit', [ClieforneController::class, 'edit'])->name('cliefornes.edit');
        Route::put('/{id}', [ClieforneController::class, 'update'])->name('cliefornes.update');
        Route::delete('/{id}', [ClieforneController::class, 'destroy'])->name('cliefornes.destroy');
    });

    // ==================== ORDEM DE SERVIÇO (OS) ====================
    Route::prefix('os')->group(function () {
        // Rotas estáticas
        Route::get('/', [MainController::class, 'oservico'])->name('oservico');
        Route::get('/create', [MainController::class, 'cadoservico'])->name('cadoservico');
        Route::post('/create', [MainController::class, 'cadoservicoSubmit'])->name('cadoservicoSubmit');
        Route::get('/print/{id}', [MainController::class, 'osprint'])->name('osprint');

        // Rotas com parâmetros
        Route::get('/{id}/edit', [MainController::class, 'editoservico'])->name('editoservico');
        Route::post('/{id}/edit', [MainController::class, 'editoservicoSubmit'])->name('editoservicoSubmit');
        Route::get('/{id}/delete', [MainController::class, 'deleteoservico'])->name('deleteoservico');
        Route::get('/{id}/confirm-delete', [MainController::class, 'deleteoservicoConfirm'])->name('deleteoservicoConfirm');

        Route::post('/{oservicos}/marcar-aberta', [MainController::class, 'marcarComoAberta'])->name('oservico.marcar-aberta');
        Route::post('/{oservicos}/marcar-fechada', [MainController::class, 'marcarComoFechada'])->name('oservico.marcar-fechada');
    });

    // ==================== FATURAS ====================
    Route::prefix('faturas')->group(function () {
        Route::get('/{id}', [MainController::class, 'fatura'])->name('fatura');
        Route::get('/{id}/create', [MainController::class, 'cadfatura'])->name('cadfatura');
        Route::post('/create', [MainController::class, 'cadfaturaSubmit'])->name('cadfaturaSubmit');

        Route::post('/{faturas}/aprovar', [MainController::class, 'marcarComoAprovada'])->name('faturas.aprovar');
        Route::post('/{faturas}/reprovar', [MainController::class, 'marcarComoReprovada'])->name('faturas.reprovar');
        Route::delete('/{faturas}/{numos}/delete', [MainController::class, 'deletefaturaConfirma'])->name('deletefaturaConfirma');

        Route::post('/edit', [MainController::class, 'editfatura'])->name('editfatura');
        Route::post('/edit-submit', [MainController::class, 'editfaturaSubmit'])->name('editfaturaSubmit');
        Route::post('/print', [MainController::class, 'fatprint'])->name('fatprint');


    });

    // ==================== ABASTECIMENTO (MAINCONTROLLER) ====================
    Route::prefix('abastecimento')->group(function () {
        Route::get('/', [MainController::class, 'Abastecimento'])->name('Abastecimento');
        Route::get('/create', [MainController::class, 'cadAbastecimento'])->name('cadAbastecimento');
        Route::post('/create', [MainController::class, 'cadAbastecimentoSubmit'])->name('cadAbastecimentoSubmit');

        Route::get('/{id}/edit', [MainController::class, 'editAbastecimento'])->name('editAbastecimento');
        Route::post('/{id}/edit', [MainController::class, 'editAbastecimentoSubmit'])->name('editAbastecimentoSubmit');

        Route::get('/{id}/delete', [MainController::class, 'deleteAbastecimento'])->name('deleteAbastecimento');
        Route::get('/{id}/confirm-delete', [MainController::class, 'deleteAbastecimentoConfirm'])->name('deleteAbastecimentoConfirm');
    });

    // ==================== AGENDA ====================
    Route::prefix('agenda')->group(function () {
        Route::get('/', [MainController::class, 'Agenda'])->name('Agenda');
        Route::get('/create', [MainController::class, 'cadAgenda'])->name('cadAgenda');
        Route::post('/create', [MainController::class, 'cadAgendaSubmit'])->name('cadAgendaSubmit');

        Route::get('/{id}/edit', [MainController::class, 'editAgenda'])->name('editAgenda');
        Route::post('/{id}/edit', [MainController::class, 'editAgendaSubmit'])->name('editAgendaSubmit');

        Route::get('/{id}/delete', [MainController::class, 'deleteAgenda'])->name('deleteAgenda');
        Route::get('/{id}/confirm-delete', [MainController::class, 'deleteAgendaConfirm'])->name('deleteAgendaConfirm');
    });



    // ==================== RELATÓRIOS ESPECÍFICOS ====================
    Route::get('/selectFatMaquina', [MainController::class, 'selectFatMaquina'])->name('selectFatMaquina');
    Route::post('/relFatMaquina', [MainController::class, 'relFatMaquina'])->name('relFatMaquina');
    Route::get('/faturaDashboard', [MainController::class, 'faturaDashboard'])->name('faturaDashboard');



        // ==================== COLABORADORES ====================
                // Rotas Resource para Colaboradores
        // Rotas para Colaboradores
        Route::get('/colaboradores', [ColaboradorController::class, 'index'])->name('colaboradores.index');
        Route::get('/colaboradores/create', [ColaboradorController::class, 'create'])->name('colaboradores.create');
        Route::post('/colaboradores', [ColaboradorController::class, 'store'])->name('colaboradores.store');
        Route::get('/colaboradores/{id}', [ColaboradorController::class, 'show'])->name('colaboradores.show');
        Route::get('/colaboradores/{id}/edit', [ColaboradorController::class, 'edit'])->name('colaboradores.edit');
        Route::put('/colaboradores/{id}', [ColaboradorController::class, 'update'])->name('colaboradores.update');
        Route::delete('/colaboradores/{id}', [ColaboradorController::class, 'destroy'])->name('colaboradores.destroy');

            // Relatórios de Faturamento
        Route::prefix('relatorios')->group(function () {
        Route::get('/faturamento', [RelatorioFaturamentoController::class, 'index'])->name('relatorios.faturamento.index');
        Route::get('/faturamento/dashboard', [RelatorioFaturamentoController::class, 'dashboard'])->name('relatorios.faturamento.dashboard');
        Route::get('/faturamento/exportar', [RelatorioFaturamentoController::class, 'exportarExcel'])->name('relatorios.faturamento.exportar');


      //  Route::post('/boletos/processar-codigo', [BoletoController::class, 'processarCodigo'])->name('boletos.processar-codigo');


 Route::prefix('orcamentos')->group(function () {
    Route::get('/dashboard', [OrcamentoController::class, 'dashboard'])->name('orcamentos.dashboard');
    Route::get('/', [OrcamentoController::class, 'index'])->name('orcamentos.index');
    Route::get('/create', [OrcamentoController::class, 'create'])->name('orcamentos.create');
    Route::post('/', [OrcamentoController::class, 'store'])->name('orcamentos.store');
    Route::get('/{id}', [OrcamentoController::class, 'show'])->name('orcamentos.show');
    Route::get('/{id}/edit', [OrcamentoController::class, 'edit'])->name('orcamentos.edit');
    Route::put('/{id}', [OrcamentoController::class, 'update'])->name('orcamentos.update');
    Route::delete('/{id}', [OrcamentoController::class, 'destroy'])->name('orcamentos.destroy');
    Route::post('/{id}/enviar', [OrcamentoController::class, 'enviar'])->name('orcamentos.enviar');
    Route::post('/{id}/aprovar', [OrcamentoController::class, 'aprovar'])->name('orcamentos.aprovar');
    Route::post('/{id}/rejeitar', [OrcamentoController::class, 'rejeitar'])->name('orcamentos.rejeitar');
    Route::post('/{id}/cancelar', [OrcamentoController::class, 'cancelar'])->name('orcamentos.cancelar');
    Route::post('/{id}/converter-os', [OrcamentoController::class, 'converterOs'])->name('orcamentos.converter-os');
    Route::get('/{id}/print', [OrcamentoController::class, 'print'])->name('orcamentos.print'); // imprimir (HTML)
    Route::get('/{id}/pdf', [OrcamentoController::class, 'downloadPdf'])->name('orcamentos.pdf'); // Nova rota

            });


                        });



     // Route::resource('preco-equipamentos', PrecoEquipamentoController::class);
    Route::resource('preco-equipamentos', PrecoEquipamentoController::class)
    ->parameters(['preco-equipamentos' => 'preco']); // opcional, deixa {preco} em vez de {preco_equipamento}

    Route::resource('cobrancas', CobrancaController::class);
    Route::post('cobrancas/{cobranca}/atualizar-status', [CobrancaController::class,'atualizarStatus'])->name('cobrancas.atualizar-status');
    Route::get('cobrancas/relatorio/print', [CobrancaController::class, 'printRelatorio'])->name('cobrancas.print');



});



