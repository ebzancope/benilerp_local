@if (session('mensagem'))
    <div class="alert alert-warning mt-3 fw-bold" style="border-radius: 15px;text-align: center; ">
        {{ session('mensagem') }}
    </div>
@endif
<div style="border-radius: 20px; background-color: #eaf4e5; color: rgb(90, 86, 86);padding: 0px">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col order-10"
                    style="border-radius: 10px 0px 0px  0px;background-color: #dcecd3;color: #30a300;">
                    Cliente
                </th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Equipamento</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Início da Obra</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Fim da Obra</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Status</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Valor</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Vencimento</th>
                <th scope="col" style="border-radius: 0 10px 0px 10px;background-color: #dcecd3; color: #30a300;">
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cronograma as $cronogramas)
                <tr>
                    <th>
                        {{ $cronogramas->cliefornes_nome }}
                    </th>
                    <td>{{ $cronogramas->equipamentos_modelo }}
                    </td>
                    <td>{{ date('d/m/Y', strtotime($cronogramas['cronogramas_dataini'])) }}
                    </td>
                    <td>{{ date('d/m/Y', strtotime($cronogramas['cronogramas_datafim'])) }}
                    </td>
                    <td>
                        @if ($cronogramas->cronogramas_estatus == 1)
                            A Receber
                        @endif
                        @if ($cronogramas->cronogramas_estatus == 2)
                            Pago
                        @endif
                        @if ($cronogramas->cronogramas_estatus == 3)
                            Em execução
                        @endif
                        @if ($cronogramas->cronogramas_estatus == 4)
                            Agendar
                        @endif
                        @if ($cronogramas->cronogramas_estatus == 5)
                            A visitar
                        @endif
                    </td>
                    <td>R$ {{ number_format($cronogramas['cronogramas_valor'], 2, ',', '.') }}
                    </td>
                    <td>{{ date('d/m/Y', strtotime($cronogramas['cronogramas_vencimento'])) }}
                    </td>
                    <td><a href="{{ route('editcronograma', ['id' => Crypt::encrypt($cronogramas['cronogramas_id'])]) }}"
                            class="btn btn-outline-secondary btn-sm mx-1  rounded-pill"><i
                                class="fa-regular fa-pen-to-square "></i></a>
                        <a href="{{ route('deletecronograma', ['id' => Crypt::encrypt($cronogramas['cronogramas_id'])]) }}"
                            class="btn btn-outline-danger btn-sm mx-1  rounded-pill"> <i
                                class="fa-regular fa-trash-can"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Sem dados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
