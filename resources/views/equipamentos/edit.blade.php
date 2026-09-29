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
                                    <h2><i class="fas fa-edit"></i> Editar Equipamento</h2>
                                    <p class="text-muted">Código: {{ $equipamento->codigo }} | ID: {{ $equipamento->id
                                        }}</p>
                                </div>
                                <div class="col-md-6 text-right ">
                                    <a href="{{ route('equipamentos.show', $equipamento->id) }}"
                                        class="btn btn-info rounded-pill">
                                        <i class="fas fa-eye"></i> Visualizar
                                    </a>
                                    <a href="{{ route('equipamentos.index') }}" class="btn btn-secondary rounded-pill">
                                        <i class="fas fa-arrow-left"></i> Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-body">
                            <form method="POST" action="{{ route('equipamentos.update', $equipamento->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <!-- Coluna 1 - Informações Básicas -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="codigo" class="form-label">Código *</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('codigo') is-invalid @enderror"
                                                id="codigo" name="codigo"
                                                value="{{ old('codigo', $equipamento->codigo) }}" required>
                                            @error('codigo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="modelo" class="form-label">Modelo *</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('modelo') is-invalid @enderror"
                                                id="modelo" name="modelo"
                                                value="{{ old('modelo', $equipamento->modelo) }}" required>
                                            @error('modelo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="categoria" class="form-label">Categoria *</label>
                                            <select
                                                class="form-control rounded-pill @error('categoria') is-invalid @enderror"
                                                id="categoria" name="categoria" required>
                                                <option value="">Selecione a categoria</option>
                                                @foreach ($categoriasComuns as $categoria)
                                                <option value="{{ $categoria }}" {{ old('categoria', $equipamento->
                                                    categoria) == $categoria ? 'selected' : '' }}>
                                                    {{ $categoria }}
                                                </option>
                                                @endforeach
                                                <option value="Outros" {{ old('categoria', $equipamento->categoria) ==
                                                    'Outros' ? 'selected' : '' }}>Outros</option>
                                            </select>
                                            @error('categoria')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="marca" class="form-label">Marca *</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('marca') is-invalid @enderror"
                                                id="marca" name="marca" value="{{ old('marca', $equipamento->marca) }}"
                                                required>
                                            @error('marca')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="cor" class="form-label">Cor</label>
                                                    <input type="text"
                                                        class="form-control rounded-pill @error('cor') is-invalid @enderror"
                                                        id="cor" name="cor" value="{{ old('cor', $equipamento->cor) }}">
                                                    @error('cor')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="ano" class="form-label">Ano</label>
                                                    <input type="text"
                                                        class="form-control rounded-pill @error('ano') is-invalid @enderror"
                                                        id="ano" name="ano" value="{{ old('ano', $equipamento->ano) }}"
                                                        maxlength="4">
                                                    @error('ano')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Coluna 2 - Documentação & Imagem -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="placa" class="form-label">Placa</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('placa') is-invalid @enderror"
                                                id="placa" name="placa" value="{{ old('placa', $equipamento->placa) }}"
                                                style="text-transform: uppercase;">
                                            @error('placa')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="renavam" class="form-label">RENAVAM</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('renavam') is-invalid @enderror"
                                                id="renavam" name="renavam"
                                                value="{{ old('renavam', $equipamento->renavam) }}">
                                            @error('renavam')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="chassi" class="form-label">Chassi</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('chassi') is-invalid @enderror"
                                                id="chassi" name="chassi"
                                                value="{{ old('chassi', $equipamento->chassi) }}">
                                            @error('chassi')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Imagem Atual -->
                                        <div class="form-group mb-3">
                                            <label class="form-label">Imagem Atual</label>
                                            <div class="text-center">
                                                <img src="{{ asset('../storage/app/public/equipamentos/' . $equipamento->image) }}"
                                                    alt="{{ $equipamento->modelo }}" class="img-thumbnail"
                                                    style="max-width: 200px; max-height: 150px; border-radius: 10px;">
                                            </div>
                                        </div>

                                        <!-- Nova Imagem -->
                                        <div class="form-group mb-3">
                                            <label for="image" class="form-label">Alterar Imagem</label>
                                            <input type="file"
                                                class="form-control rounded-pill @error('image') is-invalid @enderror"
                                                id="image" name="image" accept="image/*">
                                            @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">
                                                Deixe em branco para manter a imagem atual
                                            </small>
                                        </div>

                                        <!-- Preview da nova imagem -->
                                        <div class="text-center mt-3">
                                            <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail"
                                                style="max-width: 200px; max-height: 150px; border-radius: 10px; display: none;">
                                        </div>
                                    </div>
                                </div>

                                <!-- Especificações Técnicas -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="motor" class="form-label">Motor</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('motor') is-invalid @enderror"
                                                id="motor" name="motor" value="{{ old('motor', $equipamento->motor) }}">
                                            @error('motor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="potencia" class="form-label">Potência</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('potencia') is-invalid @enderror"
                                                id="potencia" name="potencia"
                                                value="{{ old('potencia', $equipamento->potencia) }}">
                                            @error('potencia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações Adicionais -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="prop" class="form-label">Proprietário</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('prop') is-invalid @enderror"
                                                id="prop" name="prop" value="{{ old('prop', $equipamento->prop) }}">
                                            @error('prop')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="valor" class="form-label">Valor (R$)</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('valor') is-invalid @enderror"
                                                id="valor" name="valor" value="{{ old('valor', $equipamento->valor) }}"
                                                data-mask="#.##0,00" data-mask-reverse="true">
                                            @error('valor')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="alienacao" class="form-label">Alienação</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('alienacao') is-invalid @enderror"
                                                id="alienacao" name="alienacao"
                                                value="{{ old('alienacao', $equipamento->alienacao) }}">
                                            @error('alienacao')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="apolice" class="form-label">Apólice</label>
                                            <input type="text"
                                                class="form-control rounded-pill @error('apolice') is-invalid @enderror"
                                                id="apolice" name="apolice"
                                                value="{{ old('apolice', $equipamento->apolice) }}">
                                            @error('apolice')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Seguro e Observações -->
                                <div class="row mt-4">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="venc" class="form-label">Vencimento Seguro</label>
                                            <input type="date"
                                                class="form-control rounded-pill @error('venc') is-invalid @enderror"
                                                id="venc" name="venc" value="{{ old('venc', $equipamento->venc) }}">
                                            @error('venc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="observacao" class="form-label">Observações</label>
                                            <textarea
                                                class="form-control rounded-pill @error('observacao') is-invalid @enderror"
                                                id="observacao" name="observacao"
                                                rows="3">{{ old('observacao', $equipamento->observacao) }}</textarea>
                                            @error('observacao')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Botões -->
                                <div class="form-group mt-4 text-center">
                                    <button type="submit" class="btn btn-success rounded-pill px-5">
                                        <i class="fas fa-save"></i> Atualizar Equipamento
                                    </button>
                                    <a href="{{ route('equipamentos.index') }}"
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
        // Preview da nova imagem
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Formatação de placa
        const placaInput = document.getElementById('placa');
        placaInput.addEventListener('input', function(e) {
            let value = e.target.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
            if (value.length > 3) {
                value = value.substring(0, 3) + '-' + value.substring(3, 7);
            }
            e.target.value = value;
        });

        // Máscara para valor monetário
        const valorInput = document.getElementById('valor');
        valorInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = (value / 100).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            e.target.value = value;
        });
    });
</script>
@endsection