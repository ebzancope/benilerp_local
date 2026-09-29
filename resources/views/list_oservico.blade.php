@if (session('mensagem'))
<div class="alert alert-warning mt-3 fw-bold" style="border-radius: 15px;text-align: center; ">
    {{ session('mensagem') }}
</div>
@endif
<div style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86);padding: 0px">
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col order-5" style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                    Data</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">
                    nº OS / Cliente
                </th>

                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Descrição</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Status</th>


                <th scope="col" style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;">
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($oservico as $oservicos)
            <tr>
                <td>
                    {{ date('d/m/Y', strtotime($oservicos['dataoscli'])) }}
                </td>
                <td> OS Nº {{ $oservicos->idnumos }} / {{ $oservicos->nomeclie }}

                </td>


                <td>
                    {{ $oservicos->numos_descricao }}
                </td>
                <td>


                    @if ($oservicos->estatusos != '1')
                    <span class="badge badge-warning">
                        Aberta
                    </span>
                    @else <span class="badge badge-success">
                        Fechada
                    </span>
                    @endif


                </td>

                <td>



                    <a href="{{ route('fatura', ['id' => Crypt::encrypt($oservicos->idnumos)]) }}"
                        class="btn btn-outline-secondary btn-sm mx-1  rounded-pill"><i
                            class="fa-solid fa-folder-open"></i></a>



                    <a href="{{ route('editoservico', ['id' => Crypt::encrypt($oservicos->idnumos)]) }}"
                        class="btn btn-outline-secondary btn-sm mx-1  rounded-pill"><i
                            class="fa-regular fa-pen-to-square "></i></a>

                    @if ($oservicos->estatusos != '1')
                    <a href="{{ route('deleteoservico', ['id' => Crypt::encrypt($oservicos->idnumos)]) }}"
                        class="btn btn-outline-danger btn-sm mx-1  rounded-pill"> <i
                            class="fa-regular fa-trash-can"></i></a>
                    @endif






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
