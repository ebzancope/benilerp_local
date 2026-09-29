<div class="mb-3">
    <label>Equipamento</label>
    <input type="text" name="equipamento" class="form-control" value="{{ old('equipamento', $preco->equipamento) }}">
</div>

<div class="mb-3">
    <label>Preço Unitário</label>
    <input type="number" step="0.01" name="preco_unitario" class="form-control"
        value="{{ old('preco_unitario', $preco->preco_unitario) }}">
</div>

<div class="mb-3">
    <label>Observação</label>
    <textarea name="observacao" class="form-control" rows="3">{{ old('observacao', $preco->observacao) }}</textarea>
</div>