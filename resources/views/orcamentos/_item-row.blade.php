@php
$i = $index;
$item = is_array($item ?? null) ? (object)$item : $item;
@endphp
<tr>
    <td>
        <select name="itens[{{ $i }}][tipo_item]" class="form-select form-select-sm">
            @foreach([
            'empreita'=>'Empreita',
            'hora_maquina'=>'Hora máquina',
            'viagem_caminhao'=>'Viagem caminhão',
            'frete_maquinas'=>'Frete máquinas',
            'diaria_caminhao'=>'Diária caminhão',
            'frete'=>'Frete',
            'outro'=>'Outro'] as $k=>$v)
            <option value="{{ $k }}" {{ ($item->tipo_item ?? '') == $k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>
    </td>
    <td><input name="itens[{{ $i }}][descricao]" class="form-control form-control-sm"
            value="{{ $item->descricao ?? '' }}" required></td>
    <td><input name="itens[{{ $i }}][quantidade]" type="number" step="0.01" class="form-control form-control-sm"
            value="{{ $item->quantidade ?? 1 }}" required></td>
    <td><input name="itens[{{ $i }}][unidade]" class="form-control form-control-sm" value="{{ $item->unidade ?? '' }}"
            placeholder="h, km, dia"></td>
    <td><input name="itens[{{ $i }}][preco_unitario]" type="number" step="0.01" class="form-control form-control-sm"
            value="{{ $item->preco_unitario ?? 0 }}" required></td>
    <input type="hidden" name="itens[{{ $i }}][desconto_valor]" type="number" step="0.01"
        class="form-control form-control-sm" value="{{ $item->desconto_valor ?? 0 }}">
    <input type="hidden" name="itens[{{ $i }}][desconto_percentual]" type="number" step="0.01"
        class="form-control form-control-sm" value="{{ $item->desconto_percentual ?? 0 }}">
    <td><input name="itens[{{ $i }}][total_item]" type="number" step="0.01" class="form-control form-control-sm"
            value="{{ $item->total_item ?? 0 }}" readonly></td>
    <td class="text-center">
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)"><i
                class="fas fa-trash"></i></button>
    </td>
</tr>
