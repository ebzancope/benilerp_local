@if (session('mensagem'))
    <div class="alert alert-warning mt-3 fw-bold" style="border-radius: 15px;text-align: center; ">
        {{ session('mensagem') }}
    </div>
@endif
@php
    // Para datas no formato brasileiro (d/m/Y)
    function dataParaTimestamp($dataBr)
    {
        [$dia, $mes, $ano] = explode('/', $dataBr);
        return mktime(0, 0, 0, $mes, $dia, $ano);
    }

@endphp
<div style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86);">
    <table class="table table-hover  ">
        <thead>
            <tr>
                <th scope="col order-7" style="border-radius: 20px 0 0 20px; background-color: #dcecd3;color: #30a300;">
                    Cliente</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Descrição</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Inicio da Obra</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Qtd dias</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Fim da Obra</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Status</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Observação</th>
                <th scope="col" style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;">
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($agendas as $agenda)
                <tr>
                    <td>
                        {{ $agenda['titulo'] }}
                    </td>
                    <td>
                        {{ $agenda['mensagem'] }}
                    </td>
                    <td>
                        {{ date('d/m/Y', strtotime($agenda['agendata'])) }}
                    </td>
                    <td>
                        sss
                    </td>
                    <td>
                        {{ date('d/m/Y', strtotime($agenda['created_at'])) }}
                    </td>
                    <td>
                        Valor
                    </td>
                    <td>Confirmar</td>
                    <td>&nbsp;</td>
                    <td><a href="{{ route('editAgenda', ['id' => Crypt::encrypt($agenda['id'])]) }}"
                            class="btn btn-outline-secondary btn-sm mx-1  rounded-pill"><i
                                class="fa-regular fa-pen-to-square "></i></a>
                        <a href="{{ route('deleteAgenda', ['id' => Crypt::encrypt($agenda['id'])]) }}"
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
