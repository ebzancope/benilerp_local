@csrf
<div class="row">
    <div class="col-md-6">
        <label>Nome *</label>
        <input type="text" name="nome" class="form-control rounded-pill" value="{{ old('nome', $item->nome ?? '') }}"
            required>
    </div>
    <div class="col-md-3">
        <label>Código</label>
        <input type="text" name="codigo" class="form-control rounded-pill"
            value="{{ old('codigo', $item->codigo ?? '') }}">
    </div>
    <div class="col-md-3">
        <label>Unidade</label>
        <input type="text" name="unidade_medida" class="form-control rounded-pill"
            value="{{ old('unidade_medida', $item->unidade_medida ?? 'un') }}" required>
    </div>

    <div class="col-md-4 mt-3">
        <label>Preço Diário</label>
        <input type="number" step="0.01" name="preco_diario" class="form-control rounded-pill"
            value="{{ old('preco_diario', $item->preco_diario ?? '') }}">
    </div>
    <div class="col-md-4 mt-3">
        <label>Preço Semanal</label>
        <input type="number" step="0.01" name="preco_semanal" class="form-control rounded-pill"
            value="{{ old('preco_semanal', $item->preco_semanal ?? '') }}">
    </div>
    <div class="col-md-4 mt-3">
        <label>Preço Mensal</label>
        <input type="number" step="0.01" name="preco_mensal" class="form-control rounded-pill"
            value="{{ old('preco_mensal', $item->preco_mensal ?? '') }}">
    </div>

    <div class="col-md-12 mt-3">
        <label>Observação</label>
        <textarea name="observacao" class="form-control"
            rows="3">{{ old('observacao', $item->observacao ?? '') }}</textarea>
    </div>

    <div class="col-md-3 mt-3">
        <div class="form-check form-switch">
            <input type="hidden" name="ativo" value="0">
            <input class="form-check-input" type="checkbox" name="ativo" value="1" {{ old('ativo', $item->ativo ?? true)
            ? 'checked' : '' }}>
            <label class="form-check-label">Ativo</label>
        </div>
    </div>
</div>

<div class="mt-4">
    <button type="submit" class="btn btn-success rounded-pill">
        <i class="fas fa-save"></i> Salvar
    </button>
    <a href="{{ route('preco-equipamentos.index') }}" class="btn btn-secondary rounded-pill">
        <i class="fas fa-undo"></i> Voltar
    </a>
</div>