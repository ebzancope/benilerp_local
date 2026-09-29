@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="row row-sm row-timeline pd-5 ">
        <div class="col-lg-12">
            <div class="card pd-15" style="border-radius: 10px">
                <div class="timeline-group">
                    <div class="row row-sm row-timeline">
                        <div class="col-lg-12 "
                            style="border-radius: 2%;background-color: #f6faf4; color: rgb(90, 86, 86); padding: 15px">
                            <div class="row mb-4">
                                <div class="col-md-6 section-title fst-italic" style="color: #30a300; ">
                                    <h2><i class="fas fa-user-plus"></i> Novo Colaborador</h2>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <a href="{{ route('colaboradores.index') }}" class="btn btn-secondary rounded-pill">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <form method="POST" action="{{ route('colaboradores.store') }}">
                                @csrf

                                <div class="row">
                                    <!-- Coluna 1 - Dados Pessoais -->
                                    <div class="col-md-6">
                                        <h5 class="border-bottom pb-2 mb-3">Dados Pessoais</h5>

                                        <div class="form-group mb-3">
                                            <label for="nome" class="form-label">Nome Completo *</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('nome') is-invalid @enderror"
                                                id="nome" name="nome" value="{{ old('nome') }}" required>
                                            @error('nome')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="apelido" class="form-label">Apelido</label>
                                                    <input type="text"
                                                        class="form-control rounded-pill @error('apelido') is-invalid @enderror"
                                                        id="apelido" name="apelido" value="{{ old('apelido') }}">
                                                    @error('apelido')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="nascimento" class="form-label">Data Nascimento</label>
                                                    <input type="date"
                                                        class="form-control rounded-pill @error('nascimento') is-invalid @enderror"
                                                        id="nascimento" name="nascimento"
                                                        value="{{ old('nascimento') }}">
                                                    @error('nascimento')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="cpf" class="form-label">CPF</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('cpf') is-invalid @enderror"
                                                id="cpf" name="cpf" value="{{ old('cpf') }}"
                                                placeholder="000.000.000-00">
                                            @error('cpf')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label">E-mail</label>
                                            <input type="email"
                                                class="form-control rounded-pill @error('email') is-invalid @enderror"
                                                id="email" name="email" value="{{ old('email') }}">
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Coluna 2 - Contato -->
                                    <div class="col-md-6">
                                        <h5 class="border-bottom pb-2 mb-3">Contato</h5>

                                        <div class="form-group mb-3">
                                            <label for="telefone" class="form-label">Telefone</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('telefone') is-invalid @enderror"
                                                id="telefone" name="telefone" value="{{ old('telefone') }}"
                                                placeholder="(00) 00000-0000">
                                            @error('telefone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="contato" class="form-label">Contato Emergencial</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('contato') is-invalid @enderror"
                                                id="contato" name="contato" value="{{ old('contato') }}">
                                            @error('contato')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="fone" class="form-label">Telefone Contato</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('fone') is-invalid @enderror"
                                                id="fone" name="fone" value="{{ old('fone') }}"
                                                placeholder="(00) 0000-0000">
                                            @error('fone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações Profissionais -->
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom pb-2 mb-3">Informações Profissionais</h5>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="empresa" class="form-label">Empresa</label>
                                            <select
                                                class="form-control rounded-pill @error('empresa') is-invalid @enderror"
                                                id="empresa" name="empresa">
                                                <option value="">Selecione a empresa</option>
                                                @foreach ($empresas as $empresa)
                                                <option value="{{ $empresa->id }}" {{ old('empresa')==$empresa->id ?
                                                    'selected' : '' }}>
                                                    {{ $empresa->nome }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('empresa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="cargo" class="form-label">Cargo *</label>
                                            <select
                                                class="form-control rounded-pill @error('cargo') is-invalid @enderror"
                                                id="cargo" name="cargo" required>
                                                <option value="">Selecione o cargo</option>
                                                @foreach ($cargosComuns as $cargo)
                                                <option value="{{ $cargo }}" {{ old('cargo')==$cargo ? 'selected' : ''
                                                    }}>
                                                    {{ $cargo }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('cargo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="admissao" class="form-label">Data Admissão *</label>
                                            <input type="date"
                                                class="form-control rounded-pill @error('admissao') is-invalid @enderror"
                                                id="admissao" name="admissao"
                                                value="{{ old('admissao', date('Y-m-d')) }}" required>
                                            @error('admissao')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="funcao" class="form-label">Função</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('funcao') is-invalid @enderror"
                                                id="funcao" name="funcao" value="{{ old('funcao') }}">
                                            @error('funcao')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="setor" class="form-label">Setor</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('setor') is-invalid @enderror"
                                                id="setor" name="setor" value="{{ old('setor') }}">
                                            @error('setor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="categoria" class="form-label">Categoria</label>
                                            <select
                                                class="form-control rounded-pill @error('categoria') is-invalid @enderror"
                                                id="categoria" name="categoria">
                                                <option value="">Selecione a categoria</option>
                                                @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria }}" {{ old('categoria')==$categoria
                                                    ? 'selected' : '' }}>
                                                    {{ $categoria }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('categoria')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="salario" class="form-label">Salário (R$)</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('salario') is-invalid @enderror"
                                                id="salario" name="salario" value="{{ old('salario') }}"
                                                placeholder="0,00" data-mask="#.##0,00" data-mask-reverse="true">
                                            @error('salario')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="nivel" class="form-label">Nível</label>
                                            <select
                                                class="form-control rounded-pill @error('nivel') is-invalid @enderror"
                                                id="nivel" name="nivel">
                                                <option value="">Selecione o nível</option>
                                                @foreach ($niveis as $key => $value)
                                                <option value="{{ $key }}" {{ old('nivel')==$key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('nivel')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="cnh" class="form-label">CNH</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('cnh') is-invalid @enderror"
                                                id="cnh" name="cnh" value="{{ old('cnh') }}">
                                            @error('cnh')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="validade" class="form-label">Validade CNH</label>
                                            <input type="date"
                                                class="form-control rounded-pill @error('validade') is-invalid @enderror"
                                                id="validade" name="validade" value="{{ old('validade') }}">
                                            @error('validade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Endereço -->
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h5 class="border-bottom pb-2 mb-3">Endereço</h5>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="cep" class="form-label">CEP</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('cep') is-invalid @enderror"
                                                id="cep" name="cep" value="{{ old('cep') }}" placeholder="00000-000">
                                            @error('cep')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label for="uf" class="form-label">UF</label>
                                            <select class="form-control rounded-pill @error('uf') is-invalid @enderror"
                                                id="uf" name="uf">
                                                <option value="">Selecione</option>
                                                @foreach ($ufs as $uf)
                                                <option value="{{ $uf }}" {{ old('uf')==$uf ? 'selected' : '' }}>
                                                    {{ $uf }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('uf')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="cidade" class="form-label">Cidade</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('cidade') is-invalid @enderror"
                                                id="cidade" name="cidade" value="{{ old('cidade') }}">
                                            @error('cidade')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="bairro" class="form-label">Bairro</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('bairro') is-invalid @enderror"
                                                id="bairro" name="bairro" value="{{ old('bairro') }}">
                                            @error('bairro')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label for="endereco" class="form-label">Endereço</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('endereco') is-invalid @enderror"
                                                id="endereco" name="endereco" value="{{ old('endereco') }}">
                                            @error('endereco')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="numero" class="form-label">Número</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('numero') is-invalid @enderror"
                                                id="numero" name="numero" value="{{ old('numero') }}">
                                            @error('numero')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Observações e Status -->
                                <div class="row mt-4">
                                    <div class="col-md-8">
                                        <div class="form-group mb-3">
                                            <label for="obs" class="form-label">Observações</label>
                                            <textarea
                                                class="form-control rounded-pill @error('obs') is-invalid @enderror"
                                                id="obs" name="obs" rows="3">{{ old('obs') }}</textarea>
                                            @error('obs')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <div class="form-check mt-4">
                                                <input type="checkbox" class="form-check-input" id="ativo" name="ativo"
                                                    value="1" checked>
                                                <label class="form-check-label" for="ativo">Colaborador Ativo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="form-group mt-4 text-center">
                                    <button type="submit" class="btn btn-success rounded-pill px-5">
                                        <i class="fas fa-save"></i> Cadastrar Colaborador
                                    </button>
                                    <a href="{{ route('colaboradores.index') }}"
                                        class="btn btn-secondary rounded-pill px-5">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Máscaras
        const cpfInput = document.getElementById('cpf');
        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 3 && value.length <= 6) {
                    value = value.replace(/(\d{3})(\d+)/, '$1.$2');
                } else if (value.length > 6 && value.length <= 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d+)/, '$1.$2.$3');
                } else if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d+)/, '$1.$2.$3-$4');
                }
                e.target.value = value;
            });
        }

        // Máscara para telefone
        const telefoneInputs = [document.getElementById('telefone'), document.getElementById('fone')];
        telefoneInputs.forEach(input => {
            if (input) {
                input.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length <= 10) {
                        value = value.replace(/(\d{2})(\d{4})(\d+)/, '($1) $2-$3');
                    } else if (value.length > 10) {
                        value = value.replace(/(\d{2})(\d{5})(\d+)/, '($1) $2-$3');
                    }
                    e.target.value = value;
                });
            }
        });

        // Máscara para CEP
        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 5) {
                    value = value.replace(/(\d{5})(\d+)/, '$1-$2');
                }
                e.target.value = value;
            });
        }

        // Máscara para salário
        const salarioInput = document.getElementById('salario');
        if (salarioInput) {
            salarioInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                value = (value / 100).toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                e.target.value = value;
            });
        }

        // Buscar CEP
        cepInput?.addEventListener('blur', function() {
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
    });
</script>
@endsection