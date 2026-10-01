@php
$d = $despesa ?? null;
$get = function($key, $default = '') use ($d) {
    if (is_array($d)) return $d[$key] ?? $default;
    if (is_object($d)) return $d->{$key} ?? $default;
    return $default;
};
@endphp

<tr>
    <td>
        <input type="text" name="despesas[{{ $index }}][tipo]" class="form-control form-control-sm"
               value="{{ old("despesas.$index.tipo", $get('tipo')) }}" placeholder="Ex: Terraplanagem">
    </td>
    <td>
        <input type="text" name="despesas[{{ $index }}][descricao]" class="form-control form-control-sm"
               value="{{ old("despesas.$index.descricao", $get('descricao')) }}" placeholder="Ex: Terraplanagem da fundação">
    </td>
    <td>
        <input type="number" step="0.01" min="0" name="despesas[{{ $index }}][quantidade]" class="form-control form-control-sm"
               value="{{ old("despesas.$index.quantidade", $get('quantidade', 0)) }}" placeholder="Qty">
    </td>
    <td>
        <input type="text" name="despesas[{{ $index }}][unidade]" class="form-control form-control-sm"
               value="{{ old("despesas.$index.unidade", $get('unidade')) }}" placeholder="m², m³, un">
    </td>
    <td>
        <input type="number" step="0.01" min="0" name="despesas[{{ $index }}][custo_unitario]" class="form-control form-control-sm"
               value="{{ old("despesas.$index.custo_unitario", $get('custo_unitario', 0)) }}" placeholder="Preço unit.">
    </td>
    <td>
        <input type="number" step="0.01" min="0" name="despesas[{{ $index }}][total]" class="form-control form-control-sm" readonly
               value="{{ old("despesas.$index.total", $get('total', 0)) }}" style="background-color: #f5f5f5;">
    </td>
    <td>
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeDespesaRow(this)" title="Remover linha">×</button>
    </td>

    <input type="hidden" name="despesas[{{ $index }}][ordem]" value="{{ $index }}">
    <input type="hidden" name="despesas[{{ $index }}][obs]" value="{{ old("despesas.$index.obs", $get('obs')) }}">
</tr>