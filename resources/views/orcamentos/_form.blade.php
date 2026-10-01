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
            <option value="{{ $st }}" {{ old('status', $orcamento->status ?? 'rascunho') === $st ? 'selected' : '' }}>{{  ucfirst($st) }}</option>
            @endforeach
        </select>
    </div>


    <div class="col-md-12">
        <label>Obs:</label>
        <textarea name="condicoes_pagamento" class="form-control"
            rows="2">{{ old('condicoes_pagamento', $orcamento->condicoes_pagamento ?? '') }}</textarea>
    </div>
</div>

<!-- SEÇÃO: ITENS DO ORÇAMENTO (FATURAMENTO) -->
<div class="card mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0"><i class="fas fa-list"></i> Itens do orçamento</h6>
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

                        <th style="width:12%">Total</th>
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

<!-- SEÇÃO: DESPESAS DA OBRA -->
<div class="card mb-3" style="border-left: 4px solid #dc3545;">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0"><i class="fas fa-hammer"></i> Despesas da obra</h6>
            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="addDespesa()">Adicionar
                despesa</button>
        </div>
        <p class="text-muted small mb-3">Ex: Terraplanagem = 3000m² × R$ 300/m² = R$ 900.000</p>
        <div class="table-responsive">
            <table class="table table-sm align-middle" id="despesas-table">
                <thead>
                    <tr>
                        <th style="width:14%">Tipo</th>
                        <th>Descrição</th>
                        <th style="width:10%">Qtd</th>
                        <th style="width:10%">Unid</th>
                        <th style="width:12%">Preço Unit.</th>
                        <th style="width:12%">Total</th>
                        <th style="width:6%"></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $oldDespesas = old('despesas', $orcamento->despesas ?? []);
                    @endphp
                    @forelse($oldDespesas as $i => $despesa)
                    @include('orcamentos._despesa-row', ['index' => $i, 'despesa' => $despesa])
                    @empty
                    @include('orcamentos._despesa-row', ['index' => 0, 'despesa' => null])
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- RESUMO FINANCEIRO -->
<div class="row g-3 mb-3">
    <div class="col-md-2">&nbsp;</div>

    <div class="col-md-2">
        <label class="form-label fw-bold">Faturamento (R$)</label>
        <input type="number" step="0.01" id="valorOrcamento" class="form-control rounded-pill text-success fw-bold" readonly style="background-color: #e8f5e9;">
    </div>

    <div class="col-md-2">
        <label class="form-label fw-bold">Despesas (R$)</label>
        <input type="number" step="0.01" id="totalDespesas" class="form-control rounded-pill text-danger fw-bold" readonly style="background-color: #ffebee;">
    </div>

    <div class="col-md-2">
        <label class="form-label fw-bold">Desconto (R$)</label>
        <input type="number" step="0.01" name="desconto_total"
            value="{{ old('desconto_total', $orcamento->desconto_total ?? 0) }}" class="form-control rounded-pill">
    </div>

    <div class="col-md-4">
        <label class="form-label fw-bold">Resultado Final - Lucro/Prejuízo (R$)</label>
        <input type="number" step="0.01" id="totalGeral" class="form-control rounded-pill fw-bold" readonly style="font-size: 1.1em; background-color: #fff3e0;">
    </div>
</div>

<script>
    // ===== ITENS DO ORÇAMENTO =====
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
        calcularTotais();
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
        document.querySelectorAll('#itens-table tbody tr').forEach(r => calculateRow(r));
        calcularTotais();
    }

    // ===== DESPESAS DA OBRA =====
    function calcularLinhaDespesa(row) {
        const qtd = parseFloat(row.querySelector('[name*="[quantidade]"]').value || 0);
        const preco = parseFloat(row.querySelector('[name*="[custo_unitario]"]').value || 0);
        const total = qtd * preco;

        const totalInput = row.querySelector('[name*="[total]"]');
        if (totalInput) totalInput.value = total.toFixed(2);

        calcularTotais();
    }

    function addDespesa() {
        const tbody = document.querySelector('#despesas-table tbody');
        const last = tbody.querySelector('tr:last-child');
        const clone = last.cloneNode(true);

        const index = tbody.querySelectorAll('tr').length;
        clone.querySelectorAll('input, select').forEach(el => {
            el.value = '';
            el.name = el.name.replace(/\[\d+\]/, '[' + index + ']');
        });

        tbody.appendChild(clone);
        bindDespesaEvents(clone);
    }

    function removeDespesaRow(btn) {
        const row = btn.closest('tr');
        if (row && row.parentNode.querySelectorAll('tr').length > 1) {
            row.remove();
        }
        calcularTotais();
    }

    function bindDespesaEvents(row) {
        row.querySelectorAll('input').forEach(el => {
            el.addEventListener('input', () => calcularLinhaDespesa(row));
        });
        calcularLinhaDespesa(row);
    }

    // ===== CÁLCULO TOTAL =====
    function calcularTotais() {
        let totalItens = 0;
        document.querySelectorAll('#itens-table [name*="[total_item]"]').forEach(el => {
            totalItens += parseFloat(el.value || 0);
        });

        let totalDespesas = 0;
        document.querySelectorAll('#despesas-table [name*="[total]"]').forEach(el => {
            totalDespesas += parseFloat(el.value || 0);
        });

        const desconto = parseFloat(document.querySelector('[name="desconto_total"]')?.value || 0);

        const valorOrcamento = document.getElementById('valorOrcamento');
        const totalDespesasInput = document.getElementById('totalDespesas');
        const totalGeral = document.getElementById('totalGeral');

        if (valorOrcamento) valorOrcamento.value = totalItens.toFixed(2);
        if (totalDespesasInput) totalDespesasInput.value = totalDespesas.toFixed(2);

        const resultado = totalItens - desconto - totalDespesas;
        if (totalGeral) {
            totalGeral.value = resultado.toFixed(2);
            // Muda cor conforme resultado
            if (resultado >= 0) {
                totalGeral.style.color = '#2e7d32';
                totalGeral.style.backgroundColor = '#e8f5e9';
            } else {
                totalGeral.style.color = '#c62828';
                totalGeral.style.backgroundColor = '#ffebee';
            }
        }
    }

    // ===== INICIALIZAÇÃO =====
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#itens-table tbody tr').forEach(row => bindRowEvents(row));
        document.querySelectorAll('#despesas-table tbody tr').forEach(row => bindDespesaEvents(row));
        const descInput = document.querySelector('[name="desconto_total"]');
        if (descInput) descInput.addEventListener('input', calcularTotais);
        calcularTotais();
    });
</script>