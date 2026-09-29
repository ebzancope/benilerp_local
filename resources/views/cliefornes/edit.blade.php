@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12"
                            style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                            <div class="row mb-4">
                                <div class="col-md-6 section-title fst-italic" style="color: #30a300; ">
                                    <h2><i class="fa-solid fa-user-edit"></i> Editar Cadastro</h2>
                                    <p class="mb-0" style="color: #666; font-size: 0.9rem;">Editando: {{
                                        $clieforne->nome }}</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('cliefornes.index') }}" class="btn btn-secondary rounded-pill">
                                        <i class="fa-solid fa-arrow-left"></i> Voltar
                                    </a>
                                     <div class="card-body">
                                            <p><strong>Criado por:</strong> {{ optional($clieforne->user)->name }}</p>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <form method="POST"
                            action="{{ route('cliefornes.update', ['id' => Crypt::encrypt($clieforne->id)]) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo">Tipo *</label>
                                        <select name="tipo" id="tipo" class="form-select rounded-pill" required>
                                             <option value="">Selecione </option>
                                            <option value="1" {{ $clieforne->tipo == 1 ? 'selected' : '' }}>Cliente
                                            </option>
                                            <option value="2" {{ $clieforne->tipo == 2 ? 'selected' : '' }}>Fornecedor
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome">Nome/Razão Social *</label>
                                        <input type="text" name="nome" id="nome" class="form-control rounded-pill"
                                            value="{{ $clieforne->nome }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apelido">Apelido/Nome Fantasia</label>
                                        <input type="text" name="apelido" id="apelido" class="form-control rounded-pill"
                                            value="{{ $clieforne->apelido }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" name="email" id="email" class="form-control rounded-pill"
                                            value="{{ $clieforne->email }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpfj">CPF/CNPJ</label>
                                        <input type="text" name="cpfj" id="cpfj" class="form-control rounded-pill"
                                            value="{{ $clieforne->cpfj }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="insc">Inscrição Estadual</label>
                                        <input type="text" name="insc" id="insc" class="form-control rounded-pill"
                                            value="{{ $clieforne->insc }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inscm">Inscrição Municipal</label>
                                        <input type="text" name="inscm" id="inscm" class="form-control rounded-pill"
                                            value="{{ $clieforne->inscm }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Espaço vazio para alinhamento -->
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fone">Telefone</label>
                                        <input type="text" name="fone" id="fone" class="form-control rounded-pill"
                                            value="{{ $clieforne->fone }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="celular">Celular</label>
                                        <input type="text" name="celular" id="celular" class="form-control rounded-pill"
                                            value="{{ $clieforne->celular }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <!-- Espaço vazio para alinhamento -->
                                </div>
                            </div>

                            <h5 class="mt-4" style="color: #30a300;">Endereço</h5>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cep">CEP</label>
                                        <input type="text" name="cep" id="cep" class="form-control rounded-pill"
                                            value="{{ $clieforne->cep }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="uf">UF</label>
                                        <select name="uf" id="uf" class="form-select rounded-pill">
                                            <option value="">Selecione</option>
                                            <option value="AC" {{ $clieforne->uf == 'AC' ? 'selected' : '' }}>AC
                                            </option>
                                            <option value="AL" {{ $clieforne->uf == 'AL' ? 'selected' : '' }}>AL
                                            </option>
                                            <option value="AP" {{ $clieforne->uf == 'AP' ? 'selected' : '' }}>AP
                                            </option>
                                            <option value="AM" {{ $clieforne->uf == 'AM' ? 'selected' : '' }}>AM
                                            </option>
                                            <option value="BA" {{ $clieforne->uf == 'BA' ? 'selected' : '' }}>BA
                                            </option>
                                            <option value="CE" {{ $clieforne->uf == 'CE' ? 'selected' : '' }}>CE
                                            </option>
                                            <option value="DF" {{ $clieforne->uf == 'DF' ? 'selected' : '' }}>DF
                                            </option>
                                            <option value="ES" {{ $clieforne->uf == 'ES' ? 'selected' : '' }}>ES
                                            </option>
                                            <option value="GO" {{ $clieforne->uf == 'GO' ? 'selected' : '' }}>GO
                                            </option>
                                            <option value="MA" {{ $clieforne->uf == 'MA' ? 'selected' : '' }}>MA
                                            </option>
                                            <option value="MT" {{ $clieforne->uf == 'MT' ? 'selected' : '' }}>MT
                                            </option>
                                            <option value="MS" {{ $clieforne->uf == 'MS' ? 'selected' : '' }}>MS
                                            </option>
                                            <option value="MG" {{ $clieforne->uf == 'MG' ? 'selected' : '' }}>MG
                                            </option>
                                            <option value="PA" {{ $clieforne->uf == 'PA' ? 'selected' : '' }}>PA
                                            </option>
                                            <option value="PB" {{ $clieforne->uf == 'PB' ? 'selected' : '' }}>PB
                                            </option>
                                            <option value="PR" {{ $clieforne->uf == 'PR' ? 'selected' : '' }}>PR
                                            </option>
                                            <option value="PE" {{ $clieforne->uf == 'PE' ? 'selected' : '' }}>PE
                                            </option>
                                            <option value="PI" {{ $clieforne->uf == 'PI' ? 'selected' : '' }}>PI
                                            </option>
                                            <option value="RJ" {{ $clieforne->uf == 'RJ' ? 'selected' : '' }}>RJ
                                            </option>
                                            <option value="RN" {{ $clieforne->uf == 'RN' ? 'selected' : '' }}>RN
                                            </option>
                                            <option value="RS" {{ $clieforne->uf == 'RS' ? 'selected' : '' }}>RS
                                            </option>
                                            <option value="RO" {{ $clieforne->uf == 'RO' ? 'selected' : '' }}>RO
                                            </option>
                                            <option value="RR" {{ $clieforne->uf == 'RR' ? 'selected' : '' }}>RR
                                            </option>
                                            <option value="SC" {{ $clieforne->uf == 'SC' ? 'selected' : '' }}>SC
                                            </option>
                                            <option value="SP" {{ $clieforne->uf == 'SP' ? 'selected' : '' }}>SP
                                            </option>
                                            <option value="SE" {{ $clieforne->uf == 'SE' ? 'selected' : '' }}>SE
                                            </option>
                                            <option value="TO" {{ $clieforne->uf == 'TO' ? 'selected' : '' }}>TO
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" name="cidade" id="cidade" class="form-control rounded-pill"
                                            value="{{ $clieforne->cidade }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" name="bairro" id="bairro" class="form-control rounded-pill"
                                            value="{{ $clieforne->bairro }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="endereco">Endereço</label>
                                        <input type="text" name="endereco" id="endereco"
                                            class="form-control rounded-pill" value="{{ $clieforne->endereco }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="numero">Número</label>
                                        <input type="text" name="numero" id="numero" class="form-control rounded-pill"
                                            value="{{ $clieforne->numero }}">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4" style="color: #30a300;">Contato</h5>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contato">Nome do Contato</label>
                                        <input type="text" name="contato" id="contato" class="form-control rounded-pill"
                                            value="{{ $clieforne->contato }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emailcontato">E-mail do Contato</label>
                                        <input type="email" name="emailcontato" id="emailcontato"
                                            class="form-control rounded-pill" value="{{ $clieforne->emailcontato }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefone">Telefone do Contato</label>
                                        <input type="text" name="telefone" id="telefone"
                                            class="form-control rounded-pill" value="{{ $clieforne->telefone }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="obs">Observações</label>
                                        <textarea name="obs" id="obs" class="form-control"
                                            rows="3">{{ $clieforne->obs }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-success rounded-pill">
                                        <i class="fa-solid fa-save"></i> Atualizar Cadastro
                                    </button>
                                    <a href="{{ route('cliefornes.index') }}" class="btn btn-secondary rounded-pill">
                                        <i class="fa-solid fa-times"></i> Cancelar
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Script para buscar CEP (opcional)
document.getElementById('cep').addEventListener('blur', function() {
    const cep = this.value.replace(/\D/g, '');

    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('endereco').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('uf').value = data.uf || '';
                }
            })
            .catch(error => console.error('Erro ao buscar CEP:', error));
    }
});
</script>
@endsection
