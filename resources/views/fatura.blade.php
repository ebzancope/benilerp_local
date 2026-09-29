@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5 ">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12 "
                            style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                            <div class="row mb-4">
                                <div class="col-md-6 section-title fst-italic" style="color: #30a300; ">
                                    <h2><i class="fa-solid fa-folder-open"></i> OS nº {{ $cliefornes->idnumos }} - {{
                                        $cliefornes->nomeclie }}</h2>
                                    <p class="mb-0" style="color: #666; font-size: 0.9rem;">{{
                                        $cliefornes->numos_descricao }}</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" onclick="imprimirOS()" class="btn btn-info rounded-pill">
                                        <i class="fa-solid fa-print"></i> Imprimir
                                    </button>
                                    <script>
                                        function imprimirOS() {
                                            // Mostrar loading
                                            const btn = event.target;
                                            const originalHtml = btn.innerHTML;
                                            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Imprimindo...';
                                            btn.disabled = true;
                                            // Fazer requisição para obter o conteúdo da OS
                                            fetch("{{ route('osprint', ['id' => Crypt::encrypt($cliefornes->idnumos)]) }}")
                                                .then(response => {
                                                    if (!response.ok) {
                                                        throw new Error('Erro ao carregar OS');
                                                    }
                                                    return response.text();
                                                })
                                                .then(html => {
                                                // Criar uma nova janela para impressão
                                                //  const printWindow = window.open('', '_blank', 'width=2000,height=600');
                                                    const printWindow = window.open('', '_blank',
                                            `width=${screen.width},height=600,left=0,top=0`
                                        );
                                            printWindow.document.write(`
                                                    ${html}
                                            `);
            printWindow.document.close();
            // Focar na janela e aguardar carregamento
            printWindow.onload = function() {
                // Restaurar botão
                btn.innerHTML = originalHtml;
                btn.disabled = false;
                // Opcional: imprimir automaticamente
                 printWindow.print();
            };
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao carregar OS para impressão');
            btn.innerHTML = originalHtml;
            btn.disabled = false;
        });
}
                                    </script>
                                    <a href="{{ route('cadfatura', ['id' => Crypt::encrypt($cliefornes->idnumos)]) }}"
                                        class="btn btn-success rounded-pill">
                                        <i class="fa-solid fa-circle-plus"></i> Nova Fatura
                                    </a>
                                    @if($totalPendentes >= 1)
                                    <span class="btn btn-danger rounded-pill">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Fatura Pendente
                                    </span>
                                    @else

                                    <form
                                        action="{{ route($cliefornes->estatusos != '1' ? 'oservico.marcar-fechada' : 'oservico.marcar-aberta', $cliefornes->idnumos) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn {{ $cliefornes->estatusos != '1' ? 'btn-danger' : 'btn-warning' }} rounded-pill"
                                            title="{{ $cliefornes->estatusos != '1' ? 'Fechar OS' : 'Reabrir OS' }}">
                                            <i
                                                class="fas {{ $cliefornes->estatusos != '1' ? 'fa-check' : 'fa-undo' }} mr-1"></i>
                                            {{ $cliefornes->estatusos != '1' ? 'Fechar OS' : 'Reabrir OS' }}
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                            <!-- Cards de Resumo - Faturas -->
                            <div class="row mb-4">
                                <div class="col">
                                    <div class="card bg-primary text-white rounded-pill hover-card">
                                        <div class="card-body text-center">
                                            <h6>Total Faturas</h6>
                                            <h5>{{ $totalFaturas }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <a href="?status=aprovada" class="text-decoration-none">
                                        <div class="card bg-success text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Aprovadas</h6>
                                                <h5>{{ $totalAprovadas }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <a href="?status=pending" class="text-decoration-none">
                                        <div class="card bg-warning text-white rounded-pill hover-card">
                                            <div class="card-body text-center">
                                                <h6>Pendentes</h6>
                                                <h5>{{ $totalPendentes }}</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col">
                                    <div class="card bg-info text-white rounded-pill hover-card">
                                        <div class="card-body text-center">
                                            <h6>Valor Total</h6>
                                            <h5>R$ {{ number_format($valorTotal, 2, ',', '.') }}</h5>
                                        </div>
                                    </div>
                                </div>
                                <style>
                                    .hover-card:hover {
                                        transform: translateY(-2px);
                                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                                        cursor: pointer;
                                        transition: all 0.3s ease;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Filtros -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>Status</label>
                                    <select name="status" class="form-select rounded-pill">
                                        <option value="">Todos</option>
                                        <option value="aprovada" {{ request('status')=='aprovada' ? 'selected' : '' }}>
                                            Aprovadas
                                        </option>
                                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>
                                            Pendentes
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Equipamento</label>
                                    <select name="equipamento" class="form-select rounded-pill">
                                        <option value="">Todos</option>
                                        @foreach ($equipamentos as $equipamento)
                                        <option value="{{ $equipamento->id }}" {{ request('equipamento')==$equipamento->
                                            id ? 'selected' : '' }}>
                                            {{ $equipamento->codigo }} - {{ $equipamento->modelo }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Data Início</label>
                                    <input type="date" name="data_inicio" class="form-control rounded-pill"
                                        vavalue="{{ old('data_inicio', now()->firstOfMonth()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-2">
                                    <label>Data Fim</label>
                                    <input type="date" name="data_fim" class="form-control rounded-pill"
                                        value="{{ old('data_fim', now()->endOfMonth()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block rounded-pill">
                                        <i class="fas fa-filter"></i> Filtrar
                                    </button>
                                    <a href="{{ url()->current() }}"
                                        class="btn btn-secondary btn-block rounded-pill mt-1">
                                        <i class="fas fa-times"></i> Limpar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Busca Rápida -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('fatura', ['id' => Crypt::encrypt($cliefornes->idnumos)]) }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Busca Rápida</label>
                                    <div class="search-box">
                                        <input type="text" class="form-control rounded-pill" name="text_fatura"
                                            id="text_fatura" placeholder="Fatura Nº "
                                            value="{{ request('text_fatura') }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label>&nbsp;</label>
                                    <button class="btn btn-success rounded-pill btn-block" type="submit">
                                        <i class="fa fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if (session('mensagem'))
                <div class="alert alert-warning mt-3 fw-bold" style="border-radius: 15px;text-align: center; ">
                    {{ session('mensagem') }}
                </div>
                @endif
                <!-- Tabela de Faturas -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Fatura Nº</th>
                                        <th>Equipamento</th>
                                        <th>Serviço Realizado</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($faturas as $fatura)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($fatura->datacadfat)) }}</td>
                                        <td>{{ $fatura->numnota }}</td>
                                        <td>
                                            @foreach ($equipamentos as $equipamento)
                                            @if ($equipamento->id == $fatura->veiculo)
                                            {{ $equipamento->codigo }} / {{ $equipamento->modelo }}
                                            @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $fatura->servicos }}</td>
                                        <td>
                                            @if ($fatura->totmaquina)
                                            R$ {{ number_format($fatura->totmaquina, 2, ',', '.') }}
                                            @else
                                            R$ {{ number_format($fatura->totala, 2, ',', '.') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($fatura->aprovada > '0' )
                                            <span class="badge badge-success">
                                                <i class="fa-solid fa-file-invoice-dollar"></i> Aprovada
                                            </span>
                                            @else
                                            <span class="badge badge-warning">
                                                <i class="fa-solid fa-file-invoice"></i> Pendente
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('editfatura') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ Crypt::encrypt($fatura->id) }}">
                                                <input type="hidden" name="idnumos"
                                                    value="{{ Crypt::encrypt($fatura->numos) }}">
                                                <button type="submit" class="btn btn-sm btn-warning rounded-pill"
                                                    title="Editar">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('deletefaturaConfirma', [
                                                        'faturas' => Crypt::encrypt($fatura->id),
                                                        'numos' => Crypt::encrypt($fatura->numos)
                                                    ]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                    title="Excluir"
                                                    onclick="return confirm('Tem certeza que deseja excluir esta fatura?')">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                            {{-- Ações rápidas de status --}}
                                            @if ($fatura->aprovada == '0')
                                            <form action="{{ route('faturas.aprovar', $fatura->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success  rounded-pill"
                                                    title="Aprovar Fatura">
                                                    <i class="fa-solid fa-undo"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('faturas.reprovar', $fatura->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning rounded-pill"
                                                    title="Marcar como Pendente">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </form>

                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Nenhuma fatura encontrada.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- Paginação -->
                        {{ $faturas->appends(['page' => request('page')])->links() }}
                        <!-- Resumo Financeiro -->
                        @if(count($faturas) > 0)
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title">Resumo Financeiro</h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <strong>Total Aprovado:</strong><br>
                                                <span class="text-success">R$ {{ number_format($totalAprovado, 2, ',',
                                                    '.') }} </span>
                                            </div>
                                            <div class="col-6">
                                                <strong>Total Pendente:</strong><br>
                                                <span class="text-warning">R$ {{ number_format($totalPendenteValor, 2,
                                                    ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div><!-- timeline- -->
        </div><!-- group -->
    </div><!-- card -->
</div><!-- ol lg-->
</div><!-- timeline-p5 -->
</div>
@endsection