@php
$clientes = $clientes ?? collect();
$isEdit = isset($cobranca) && $cobranca->exists;
@endphp

<div class="card mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <label>Cliente</label>
                <select name="cliente_id" class="form-select rounded-pill" required>
                    <option value="">Selecione</option>
                    @foreach($clientes as $c)
                    <option value="{{ $c->id }}" {{ old('cliente_id', $cobranca->cliente_id ?? '') == $c->id ?
                        'selected' : '' }}>
                        {{ $c->nome }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>N. OS</label>
                <input type="number" step="0.01" name="numero_os" class="form-control rounded-pill"
                    value="{{ old('numero_os', $cobranca->numero_os ?? '') }}" required>
            </div>

            <div class="col-md-2">
                <label>Valor (R$)</label>
                <input type="number" step="0.01" name="valor" class="form-control rounded-pill"
                    value="{{ old('valor', $cobranca->valor ?? '') }}" required>
            </div>

            <div class="col-md-2">
                <label>Status</label>
                <select name="status" class="form-select rounded-pill" required>
                    @foreach(['a_cobrar'=>'A
                    cobrar','cobrado'=>'Cobrado','pago'=>'Pago','cancelado'=>'Cancelado','nilton'=>'Nilton','hebert'=>'Hebert','cortesia'=>'Cortesia','outros'=>'Outros']
                    as $k=>$v)
                    <option value="{{ $k }}" {{ old('status', $cobranca->status ?? 'a_cobrar') == $k ? 'selected' : ''
                        }}>
                        {{ $v }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>Pagto</label>
                <select name="tipo_pagamento" class="form-select rounded-pill" required>
                    @foreach(['pix'=>'PIX','boleto'=>'Boleto','cartao'=>'Cartão','cheque'=>'Cheque','dinheiro'=>'Dinheiro','outros'=>'Outros']
                    as $k=>$v)
                    as $k=>$v)
                    <option value="{{ $k }}" {{ old('tipo_pagamento', $cobranca->tipo_pagamento ?? 'pix') == $k ?
                        'selected' : '' }}>
                        {{ $v }}
                    </option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-2">
                <label>Conta Bancária</label>
                <select name="contabanc" class="form-select rounded-pill" required>
                    @foreach(['benloca' => 'Benil Locação', 'benpavi' => 'Benil Pavimentação', 'niltonm' => 'Nilton ME',
                    'outros' => 'Outros']
                    as $k => $v)
                    <option value="{{ $k }}" {{ old('contabanc', $cobranca->contabanc ?? 'benloca') == $k ?
                        'selected' : '' }}>
                        {{ $v }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label>Pagamento</label>
                <input type="date" name="data_vencimento" class="form-control rounded-pill"
                    value="{{ old('data_vencimento', optional($cobranca->data_vencimento ?? null)->format('Y-m-d')) }}">
            </div>

            <div class="col-md-6">
                <label>Observação</label>
                <textarea name="observacao" rows="3" class="form-control rounded-4"
                    placeholder="Notas internas, instruções ao cliente...">{{ old('observacao', $cobranca->observacao ?? '') }}</textarea>
            </div>
        </div>
    </div>
</div>