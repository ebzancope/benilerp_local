@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12"
                            style="border-radius:2%;background-color:#f6faf4;color:#5a5656;padding:15px">
                            <div class="row mb-4">
                                <div class="col-md-6 section-title fst-italic" style="color:#30a300;">
                                    <h2><i class="fas fa-tools"></i> Tabela de Preços de Equipamentos</h2>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('preco-equipamentos.create') }}"
                                        class="btn btn-success rounded-pill">
                                        <i class="fas fa-plus"></i> Novo
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>



                <!-- Tabela -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Equipamento</th>
                                        <th>Preço</th>
                                        <th>Observação</th>
                                        <th>Criado em</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($precos as $item)
                                    <tr>
                                        <td>


                                            {{ $item->equipamento }}

                                        </td>
                                        <td>R$ {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                        <td>{{ $item->observacao }}</td>
                                        <td>{{ $item->created_at?->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('preco-equipamentos.edit', $item) }}"
                                                class="btn btn-sm btn-warning rounded-pill" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('preco-equipamentos.destroy', $item) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill"
                                                    onclick="return confirm('Excluir este registro?')" title="Excluir">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum registro encontrado.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $precos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection