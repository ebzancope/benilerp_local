@if (session('mensagem'))
    <div class="alert alert-warning mt-3 fw-bold" style="border-radius: 15px;text-align: center; ">
        {{ session('mensagem') }}
    </div>
@endif
<div style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86);padding: 0px">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col order-4" style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                    Data
                </th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;"> Fatura Nº</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Equipamento</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Serviço Realizado</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Valor</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                    &nbsp;
                </th>
                <th scope="col" style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;">
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($faturas as $fatura)
                <form action="{{ route('editfatura') }}" method="post">
                    @csrf
                    <tr>
                        <td> {{ date('d/m/Y', strtotime($fatura['datacadfat'])) }}
                        </td>
                        <td>
                            {{ $fatura->numnota }}
                        <td>
                            @foreach ($equipamentos as $equipamento)
                                @if ($equipamento->id == $fatura->veiculo ?? '')
                                    {{ $equipamento->codigo }} / {{ $equipamento->modelo }}
                                @endif
                            @endforeach
                        </td>
                        <td> {{ $fatura->servicos }}
                        </td>
                        <td>
                            @if ($fatura->totmaquina)
                                R$ {{ number_format($fatura->totmaquina, 2, ',', '.') }}
                            @else
                                R$ {{ number_format($fatura->totala, 2, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            <button type="submit" name="your_name" value="your_value"
                                class="btn btn-outline-secondary btn-sm mx-1  rounded-pill"><i
                                    class="fa-regular fa-pen-to-square "></i></button>
                            <input type="hidden" name="id" value="{{ Crypt::encrypt($fatura->id) }}">
                            <input type="hidden" name="idnumos" value="{{ Crypt::encrypt($fatura->numos) }}">

                            <a href="{{ route('deletefatura', ['id' => Crypt::encrypt($fatura->id)]) }}"
                                class="btn btn-outline-danger btn-sm mx-1  rounded-pill"> <i
                                    class="fa-regular fa-trash-can"></i></a>
                        </td>
                        <td>
                            @if ($fatura->aprovada > '0')
                                <div class="text-success"> <i class="fa-solid fa-file-invoice-dollar"></i></div>
                            @endif

                            @if ($fatura->aprovada == '0')
                                <div class="text-warning"> <i class="fa-solid fa-file-invoice"></i></div>
                            @endif
                        </td>
                    </tr>
                </form>
            @empty
                <tr>
                    <td colspan="5">Sem dados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
