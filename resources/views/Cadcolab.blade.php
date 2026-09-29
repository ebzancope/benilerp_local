@extends('layouts.main_layout')
@include('top_bar')
@section('content')
    <div class="row row-sm row-timeline pd-5">
        <div class="col-lg-12">
            <div class="card pd-50">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12">
                            <form action="" method="POST">
                                <div class="form-layout">
                                    <div class="row mg-b-25">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Nome: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="nome" id="nome"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Apelido: </label>
                                                <input class="form-control" type="text" name="apelido" id="apelido">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">CPF: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cpf" id="cpf"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <label class="form-control-label">Empresa: <span
                                                    class="tx-danger">*</span></label>
                                            <select class="form-control select2" data-placeholder="Selecione" name="empresa"
                                                id="empresa" required>
                                                <option label="Selecione"></option>
                                                <option value="1">Benil Terraplanagem</option>
                                                <option value="2">Benil Pavimentação</option>
                                                <option value="3">Nilton ME</option>
                                            </select>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Função: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="funcao" id="funcao"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Admissão: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="date" name="admissao" id="admissao"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">CNH: </label>
                                                <input class="form-control" type="text" name="cnh" id="cnh">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Categoria: </label>
                                                <input class="form-control" type="text" name="categoria" id="categoria">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Validade: </label>
                                                <input class="form-control" type="date" name="validade" id="validade">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Telefone: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="telefone" id="telefone"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Salário:</label>
                                                <input class="form-control" type="text" name="salario" id="salario"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Nascimento: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="date" name="nascimento"
                                                    id="nascimento" required>
                                            </div>
                                        </div><!-- col-4 -->
                                    </div><!-- row -->
                                    <label class="section-title">Endereço:</label>
                                    <div class="row mg-b-25">
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label">Cep: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cep" id="cep"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-2">
                                            <div class="form-group">
                                                <label class="form-control-label">UF: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="uf" id="uf"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Cidade: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="cidade" id="cidade"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Bairro <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="bairro" id="bairro"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-8">
                                            <div class="form-group">
                                                <label class="form-control-label">Endereço: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="endereco"
                                                    id="endereco" equired>
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Numero: <span
                                                        class="tx-danger">*</span></label>
                                                <input class="form-control" type="text" name="numero" id="numero"
                                                    required>
                                            </div>
                                        </div><!-- col-4 -->
                                    </div><!-- row -->
                                    <label class="section-title">Contato:</label>
                                    <div class="row mg-b-25">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Pessoa de contato: </label>
                                                <input class="form-control" type="text" name="contato"
                                                    id="contato">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Fone: </label>
                                                <input class="form-control" type="text" name="fone"
                                                    id="fone">
                                            </div>
                                        </div><!-- col-4 -->
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-control-label">Email: </label>
                                                <input class="form-control" type="text" name="email"
                                                    id="email">
                                            </div>
                                        </div><!-- col-4 -->
                                    </div><!-- row -->
                                    <div class="form-layout-footer">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-sm">
                                                    <a href="?572d4e421e5e6b9bc11d815e8a027112=<?php print md5('list_colaborador'); ?>"
                                                        class="btn btn-secondary bd-0 rounded-pill"
                                                        onClick="document.getElementById('mail_form').submit();">
                                                        &nbsp; &nbsp;
                                                        &nbsp;
                                                        &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor"
                                                            class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
                                                            <path fill-rule="evenodd"
                                                                d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0z" />
                                                            <path fill-rule="evenodd"
                                                                d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                                                        </svg>
                                                        Voltar &nbsp; &nbsp; &nbsp; &nbsp;</a>
                                                    </button>
                                                </div>
                                                <div class="col-sm">
                                                    &nbsp;
                                                </div>
                                                <div class="col-sm">
                                                    <input type="hidden" id="ativo" name="ativo"
                                                        value="1" />
                                                    <button class="btn btn-success bd-0 rounded-pill" type="submit"
                                                        style=" float: right;"><svg xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            class="bi bi-save" viewBox="0 0 16 16">
                                                            <path
                                                                d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2a.5.5 0 0 1 .354.854l-2.5 2.5a.5.5 0 0 1-.708 0l-2.5-2.5A.5.5 0 0 1 5.5 6.5h2V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1z" />
                                                        </svg>
                                                        &nbsp;&nbsp;&nbsp;Salvar
                                                        <?php //   ($id == -1) ? "Editar" : "Salvar"
                                                        ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div><!-- container -->
                                    </div><!-- form-layout-footer -->
                                </div><!-- form-layout -->
                        </div><!-- section-wrapper -->
                        </form>


                    </div><!-- col-9 -->
                </div><!-- row -->
            </div><!-- timeline-group -->
        </div><!-- card -->
    </div><!-- col-9 -->
    </div><!-- row -->
@endsection
