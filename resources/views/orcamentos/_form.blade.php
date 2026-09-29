@php
$isEdit = isset($orcamento) && $orcamento->exists;
@endphp

<div class="row g-3 mb-3">
    <div class="col-md-3">
        <label>Cliente:</label>
        <select name="cliente_id" class="form-select rounded-pill" required>
            <option value="">Selecione</option>
            @foreach($clientes as $c)
            <option value="{{ $c->id }}" {{ old('cliente_id', $orcamento->cliente_id ?? '') == $c->id ? 'selected' : ''
                }}>{{ $c->nome }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <label>Tipo de serviço:</label>
        <input type="text" name="titulo" value="{{ old('titulo', $orcamento->titulo ?? '') }}"
            class="form-control rounded-pill">
    </div>
    <div class="col-md-3">
        <label>Local:</label>
        <input type="text" name="local" value="{{ old('local', $orcamento->local ?? '') }}"
            class="form-control rounded-pill">
    </div>

    <div class="col-md-3">
        <label>Status</label>
        <select name="status" class="form-select rounded-pill">
            @foreach(['rascunho','enviado','aprovado','rejeitado','cancelado','convertido','hebert'] as $st)
            <option value="{{ $st }}" {{ old('status', $orcamento->status ?? 'rascunho') === $st ? 'selected' : '' }}>{{
                ucfirst($st) }}</option>
            @endforeach
        </select>
    </div>


    <div class="col-md-12">
        <label>Obs:</label>
        <textarea name="condicoes_pagamento" class="form-control"
            rows="2">{{ old('condicoes_pagamento', $orcamento->condicoes_pagamento ?? '') }}</textarea>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Itens</h6>
            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill" onclick="addItem()">Adicionar
                item</button>
        </div>
        <div class="table-responsive">
            <table class="table table-sm align-middle" id="itens-table">
                <thead>
                    <tr>
                        <th style="width:14%">Tipo</th>
                        <th>Descrição</th>
                        <th style="width:10%">Qtd</th>
                        <th style="width:10%">Unid</th>
                        <th style="width:12%">Preço</th>

                        <th style="width:12%">Total: </th>
                        <th style="width:6%"></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $oldItens = old('itens', $orcamento->itens ?? []);
                    @endphp
                    @forelse($oldItens as $i => $item)
                    @include('orcamentos._item-row', ['index' => $i, 'item' => $item])
                    @empty
                    @include('orcamentos._item-row', ['index' => 0, 'item' => null])
                    @endforelse
                </tbody>
            </table>






            <input type="hidden" name="data_emissao"
                value="{{ old('data_emissao', optional($orcamento->data_emissao ?? now())->format('Y-m-d')) }}">

            <input type="hidden" name="data_validade"
                value="{{ old('data_validade', optional($orcamento->data_validade ?? now()->addDays(29))->format('Y-m-d')) }}">

        </div>
    </div>

</div>

<div class="row g-3 mb-3">
    <div class="col-md-6">&nbsp;</div>

    <div class="col-md-3">
        <label>Desconto (R$)</label>
        <input type="number" step="0.01" name="desconto_total"
            value="{{ old('desconto_total', $orcamento->desconto_total ?? 0) }}" class="form-control rounded-pill">
    </div>
    <div class="col-md-3">
        <label>Total (R$)</label>
        <input type="number" step="0.01" id="totalGeral" class="form-control rounded-pill" readonly>
    </div>
</div>








<script>
    function bindRowEvents(row) {
    const inputs = row.querySelectorAll('input, select');
    inputs.forEach(el => {
        el.addEventListener('input', () => calculateRow(row));
    });
    calculateRow(row);
}

function calculateRow(row) {
    const qtd = parseFloat(row.querySelector('[name*="[quantidade]"]').value || 0);
    const preco = parseFloat(row.querySelector('[name*="[preco_unitario]"]').value || 0);
    const descPct = parseFloat(row.querySelector('[name*="[desconto_percentual]"]').value || 0);
    const descVal = parseFloat(row.querySelector('[name*="[desconto_valor]"]').value || 0);
    let total = qtd * preco;
    if (descPct > 0) total -= total * (descPct / 100);
    if (descVal > 0) total -= descVal;
    total = Math.max(0, total);
    const totalInput = row.querySelector('[name*="[total_item]"]');
    if (totalInput) totalInput.value = total.toFixed(2);
}

function addItem() {
    const tbody = document.querySelector('#itens-table tbody');
    const last = tbody.querySelector('tr:last-child');
    const clone = last.cloneNode(true);
    const index = tbody.querySelectorAll('tr').length;
    clone.querySelectorAll('input, select, textarea').forEach(el => {
        el.value = '';
        el.name = el.name.replace(/\[\d+\]/, '[' + index + ']');
    });
    tbody.appendChild(clone);
    bindRowEvents(clone);
}

function removeRow(btn) {
    const row = btn.closest('tr');
    if (row && row.parentNode.querySelectorAll('tr').length > 1) {
        row.remove();
    }
    // recalcula os restantes
    document.querySelectorAll('#itens-table tbody tr').forEach(r => calculateRow(r));
}

// Bind inicial
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#itens-table tbody tr').forEach(row => bindRowEvents(row));
});
</script>

<script>
    function calculateAll() {
    let sum = 0;
    document.querySelectorAll('[name*="[total_item]"]').forEach(el => {
        sum += parseFloat(el.value || 0);
    });
    const desc = parseFloat(document.querySelector('[name="desconto_total"]')?.value || 0);
    const total = Math.max(0, sum - desc);
    const out = document.getElementById('totalGeral');
    if (out) out.value = total.toFixed(2);
}

function bindRowEvents(row) {
    row.querySelectorAll('input, select').forEach(el => {
        el.addEventListener('input', () => { calculateRow(row); calculateAll(); });
    });
    calculateRow(row); // já existente
}

// após addItem() ou DOMContentLoaded, chame calculateAll()
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#itens-table tbody tr').forEach(row => bindRowEvents(row));
    const descInput = document.querySelector('[name="desconto_total"]');
    if (descInput) descInput.addEventListener('input', calculateAll);
    calculateAll();
});
</script>
