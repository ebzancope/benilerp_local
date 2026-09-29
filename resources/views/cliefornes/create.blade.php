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
                                    <h2><i class="fa-solid fa-user-plus"></i> Novo Cadastro</h2>
                                    <p class="mb-0" style="color: #666; font-size: 0.9rem;">Cadastre um novo cliente ou
                                        fornecedor</p>
                                </div>
                                <div class="col-md-6 text-right">
                                    <a href="{{ route('cliefornes.index') }}" class="btn btn-secondary rounded-pill">
                                        <i class="fa-solid fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('cliefornes.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tipo">Tipo *</label>
                                        <select name="tipo" id="tipo" class="form-select rounded-pill" required>
                                            <option value="1">Cliente</option>
                                            <option value="2">Fornecedor</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nome">Nome/Razão Social *</label>
                                        <input type="text" name="nome" id="nome" class="form-control rounded-pill"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apelido">Apelido/Nome Fantasia</label>
                                        <input type="text" name="apelido" id="apelido"
                                            class="form-control rounded-pill">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" name="email" id="email" class="form-control rounded-pill">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cpfj">CPF/CNPJ</label>
                                        <input type="text" name="cpfj" id="cpfj" class="form-control rounded-pill">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fone">Telefone</label>
                                        <input type="text" name="fone" id="fone" class="form-control rounded-pill">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="celular">Celular</label>
                                        <input type="text" name="celular" id="celular"
                                            class="form-control rounded-pill">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="insc">Inscrição Estadual</label>
                                        <input type="text" name="insc" id="insc" class="form-control rounded-pill">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4" style="color: #30a300;">Endereço</h5>
                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cep">CEP</label>
                                        <input type="text" name="cep" id="cep" class="form-control rounded-pill">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="uf">UF</label>
                                        <select name="uf" id="uf" class="form-select rounded-pill">
                                            <option value="">Selecione</option>
                                            <option value="AC">AC</option>
                                            <option value="AL">AL</option>
                                            <option value="AP">AP</option>
                                            <option value="AM">AM</option>
                                            <option value="BA">BA</option>
                                            <option value="CE">CE</option>
                                            <option value="DF">DF</option>
                                            <option value="ES">ES</option>
                                            <option value="GO">GO</option>
                                            <option value="MA">MA</option>
                                            <option value="MT">MT</option>
                                            <option value="MS">MS</option>
                                            <option value="MG">MG</option>
                                            <option value="PA">PA</option>
                                            <option value="PB">PB</option>
                                            <option value="PR">PR</option>
                                            <option value="PE">PE</option>
                                            <option value="PI">PI</option>
                                            <option value="RJ">RJ</option>
                                            <option value="RN">RN</option>
                                            <option value="RS">RS</option>
                                            <option value="RO">RO</option>
                                            <option value="RR">RR</option>
                                            <option value="SC">SC</option>
                                            <option value="SP">SP</option>
                                            <option value="SE">SE</option>
                                            <option value="TO">TO</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" name="cidade" id="cidade" class="form-control rounded-pill">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" name="bairro" id="bairro" class="form-control rounded-pill">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="endereco">Endereço</label>
                                        <input type="text" name="endereco" id="endereco"
                                            class="form-control rounded-pill">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="numero">Número</label>
                                        <input type="text" name="numero" id="numero" class="form-control rounded-pill">
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4" style="color: #30a300;">Contato</h5>
                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="contato">Nome do Contato</label>
                                        <input type="text" name="contato" id="contato"
                                            class="form-control rounded-pill">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emailcontato">E-mail do Contato</label>
                                        <input type="email" name="emailcontato" id="emailcontato"
                                            class="form-control rounded-pill">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="telefone">Telefone do Contato</label>
                                        <input type="text" name="telefone" id="telefone"
                                            class="form-control rounded-pill">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="obs">Observações</label>
                                        <textarea name="obs" id="obs" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-success rounded-pill">
                                        <i class="fa-solid fa-save"></i> Salvar Cadastro
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
@endsection