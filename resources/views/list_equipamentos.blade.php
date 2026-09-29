@if (session('mensagem'))
    <div class="alert alert-warning mt-3 fw-bold" style="border-radius: 15px;text-align: center; ">
        {{ session('mensagem') }}
    </div>
@endif
<div style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86); ">
    <table class="table table-hover  ">
        <thead>
            <tr>
                <th scope="col order-5" style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                    Foto
                </th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Código</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Modelo</th>
                <th scope="col" style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;">
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($equipamentos as $equipamento)
                <tr>
                    <th scope="row">
                        @if (!empty($equipamento->image))
                            <img src="{{ asset('../storage/app/public/' . $equipamento->image) }}" class="mt-2 shadow"
                                width="100">
                        @endif
                    </th>
                    <td>

                        {{ $equipamento->codigo }} @if ($equipamento['created_at'] != $equipamento['updated_at'])
                            <span class="badge bg-warning">Editado:
                                {{ date('d/m/Y', strtotime($equipamento['updated_at'])) }}</span>
                        @endif
                    </td>
                    <td>
                        {{ $equipamento->modelo }}
                    </td>
                    <td><a href="{{ route('editEquipamento', ['id' => Crypt::encrypt($equipamento['id'])]) }}"
                            class="btn btn-outline-secondary btn-sm mx-1  rounded-pill"><i
                                class="fa-regular fa-pen-to-square "></i></a>
                        <a href="{{ route('deleteEquipamento', ['id' => Crypt::encrypt($equipamento['id'])]) }}"
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
