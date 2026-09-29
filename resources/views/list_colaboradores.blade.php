@if (session('mensagem'))
    <div class="alert alert-warning mt-3 fw-bold" style="border-radius: 15px;text-align: center; ">
        {{ session('mensagem') }}
    </div>
@endif
<div style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86);">
    <table class="table table-hover  ">
        <thead>
            <tr>
                <th scope="col order-5" style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                    Nome
                </th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">Telefone</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">email</th>
                <th scope="col" style="background-color: #dcecd3; color: #30a300;">&nbsp;</th>
                <th scope="col" style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;">
                    &nbsp;
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($colaboradores as $colaboradore)
                <tr>
                    <th scope="row">
                        {{ $colaboradore->nome }} @if ($colaboradore['created_at'] != $colaboradore['updated_at'])
                            <span class="badge bg-warning">Editado:
                                {{ date('d/m/Y', strtotime($colaboradore['updated_at'])) }}</span>
                        @endif
                    </th>
                    <td>
                        {{ $colaboradore->telefone }}
                    </td>
                    <td> {{ $colaboradore->email }}</td>
                    <td>&nbsp;</td>
                    <td><a href="{{ route('editColaborador', ['id' => Crypt::encrypt($colaboradore['id'])]) }}"
                            class="btn btn-outline-secondary btn-sm mx-1  rounded-pill"><i
                                class="fa-regular fa-pen-to-square "></i></a>
                        <a href="{{ route('deleteColaborador', ['id' => Crypt::encrypt($colaboradore['id'])]) }}"
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
