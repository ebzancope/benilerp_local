<input type="hidden" name="tex_idnumos" value="{{ Crypt:: encrypt($viewOSGeral->idnumos ??  '') }}">
<input type="hidden" name="tex_cliente" value="{{ Crypt::encrypt($viewOSGeral->idcliefornes ?? '') }}">
<div class="form-layout ">
    <div class="row mg-b-25 ">
        <label class="section-title fst-italic " style="color: #30a300; ">| Dados</label>
        <div class="col-lg-4  ">
            <div class="form-group ">
                <label class="form-control-label btn-sm">Cliente: </label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_unused"
                    value="{{ $viewOSGeral->nomeclie }}" disabled>
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Data: </label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="date" name="tex_datacadfat"
                    value="{{ date('Y-m-d', strtotime(old('tex_datacadfat', now()))) }}" required>
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Número da fatura: </label>
                <!-- Input HTML -->
                <input class="form-control btn-sm " style="border-radius: 10px" type="number" name="numnota"
                    id="numnota" value="{{ old('numnota') }}" required>
            </div>
        </div><!-- col-2 -->

        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Máquina / veículo: </label>
                <select name="tex_veiculo" class="form-select btn-sm" style="border-radius: 10px" required>
                    <option value="">
                        {{ $equipamentos->id ?? 'Selecione' }}</option>
                    @foreach ($equipamentos as $equipamento)
                    <option value="{{ $equipamento->id }}">
                        {{ $equipamento->codigo }} / {{ $equipamento->modelo }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Operador:</label>
                <select name="tex_operador" class="form-select  btn-sm" style="border-radius: 10px" required>
                    <option value="">
                        {{ $colaboradores->id ?? 'Selecione' }}</option>
                    @foreach ($colaboradores as $colaboradore)
                    <option value="{{ $colaboradore->id }}">
                        {{ $colaboradore->nome ?? '' }} /
                        {{ $colaboradore->funcao }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <label class="section-title fst-italic " style="color: #30a300; ">| Hora máquina: </label>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Horímetro Inicial: </label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="text" id="horimini" name="horimini"
                    value="{{ old('horimini', $faturaedit->horimini ??  '0,00') }}" placeholder="0,00">
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Horímetro Final: </label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="text" id="horimfim" name="horimfim"
                    value="{{ old('horimfim', $faturaedit->horimfim ?? '0,00') }}" placeholder="0,00">
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Valor Hora: </label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="text" id="valhora" name="valhora"
                    value="{{ old('valhora', $faturaedit->valhora ?? '0,00') }}" placeholder="0,00">
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Horas Trabalhadas: </label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="text" id="tothmaquina"
                    name="tothmaquina" readonly value="{{ old('tothmaquina', $faturaedit->tothmaquina ?? '0,00') }}">
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Valor Total: </label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="totmaquina"
                    id="totmaquina" readonly value="{{ old('totmaquina', $faturaedit->totmaquina ?? '0,00') }}">
            </div>
        </div><!-- col-2 -->

        <label class="section-title fst-italic " style="color: #30a300; ">| Diária / Frete / Material:</label>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Quantidade: </label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="qtda" id="qtda"
                    value="{{ old('qtda', $faturaedit->qtda ?? '0,000') }}" placeholder="0,000">
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-control-label btn-sm">Descrição: </label>
                <input class="form-control btn-sm" style="border-radius:  10px" type="text" name="tex_descri"
                    value="{{ old('tex_descri') }}">
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Valor Unit:</label>



                <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="valora" id="valora"
                    value="" placeholder="0,00">

            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Valor Total: </label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="totala" id="totala"
                    value="{{ old('totala', $faturaedit->totala ?? '0,00') }}" readonly>
            </div>
        </div><!-- col-2 -->

        <div class="col-lg-4">
            <div class="form-group">
                <label class="form-control-label btn-sm">Local :</label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_localservico"
                    id="tex_localservico" value="{{ old('tex_localservico') }}" required>
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Hora inicial :</label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="time" id="horaini" name="horaini"
                    value="{{ old('horaini', $faturaedit->horaini ?? '') }}" placeholder="hh:mm" required>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Hora final :</label>
                <input class="form-control btn-sm" style="border-radius: 10px" type="time" id="horafini" name="horafini"
                    value="{{ old('horafini', $faturaedit->horafini ?? '') }}" placeholder="hh:mm" required>
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Frete de terceiro? </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tex_fretecolhe" id="tex_fretecolhe_sim" value="1"
                        {{ old('tex_fretecolhe', $faturaedit->fretecolhe ?? 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tex_fretecolhe_sim">
                        Sim
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tex_fretecolhe" id="tex_fretecolhe_nao" value="0"
                        {{ old('tex_fretecolhe', $faturaedit->fretecolhe ?? 0) == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tex_fretecolhe_nao">
                        Não
                    </label>
                </div>
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-2">
            <div class="form-group">
                <label class="form-control-label btn-sm">Aprovada? </label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tex_aprovada" id="tex_aprovada_sim" value="1" {{
                        old('tex_aprovada', $faturaedit->aprovada ?? 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tex_aprovada_sim">
                        Sim
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tex_aprovada" id="tex_aprovada_nao" value="0" {{
                        old('tex_aprovada', $faturaedit->aprovada ?? 0) == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="tex_aprovada_nao">
                        Não
                    </label>
                </div>
            </div>
        </div><!-- col-2 -->
        <div class="col-lg-12">
            <div class="form-group">
                <label class="form-control-label btn-sm">Serviço Realizado :</label>
                <textarea class="form-control btn-sm" style="border-radius: 10px" name="text_servicos" rows="3"
                    required>{{ old('text_servicos', $faturaedit->servicos ?? '') }}</textarea>
            </div>
        </div><!-- col-2 -->
    </div><!-- row  25 -->
</div>
<!--layout form-->

<script>
    document.addEventListener('DOMContentLoaded', function() {
    // ===== SCRIPT PARA FOCAR HORAFINI APÓS HORAINI =====

    // ===== SCRIPT PARA CÁLCULOS =====
    // Elementos para cálculo de horas máquina
    const horiminiInput = document.getElementById('horimini');
    const horimfimInput = document.getElementById('horimfim');
    const valhoraInput = document.getElementById('valhora');
    const tothmaquinaInput = document. getElementById('tothmaquina');
    const totmaquinaInput = document.getElementById('totmaquina');

    // Elementos para cálculo de material/diária
    const qtdaInput = document.getElementById('qtda');
    const valoraInput = document.getElementById('valora');
    const totalaInput = document.getElementById('totala');

    // Função para converter string brasileira para número
    function brasileiroParaNumero(texto) {
        if (!texto) return 0;
        // Remove pontos de milhar e substitui vírgula decimal por ponto
        const valorLimpo = texto.toString().replace(/\./g, '').replace(',', '.');
        return parseFloat(valorLimpo) || 0;
    }

    // Função para formatar número para string brasileira COM ARREDONDAMENTO CORRETO
    function formatarNumeroArredondado(numero, casasDecimais = 2) {
        if (isNaN(numero)) return '0,' + '0'.repeat(casasDecimais);

        // Arredondar corretamente para o número de casas decimais
        const fator = Math.pow(10, casasDecimais);
        const numeroArredondado = Math.round((numero + Number.EPSILON) * fator) / fator;

        // Converter para string e formatar
        let partes = numeroArredondado.toString().split('.');
        let inteiro = partes[0];
        let decimal = partes[1] || '';

        // Completar com zeros se necessário
        while (decimal.length < casasDecimais) {
            decimal += '0';
        }

        return casasDecimais > 0 ?  inteiro + ',' + decimal : inteiro;
    }

    // Função para formatar horas (1 casa decimal) COM ARREDONDAMENTO CORRETO
    function formatarHoras(numero) {
        return formatarNumeroArredondado(numero, 1);
    }

    // Função para calcular horas máquina com precisão
    function calcularHorasMaquina() {
        const horimini = brasileiroParaNumero(horiminiInput.value);
        const horimfim = brasileiroParaNumero(horimfimInput.value);
        const valhora = brasileiroParaNumero(valhoraInput.value);

        console.log('Valores convertidos:', {
            horimini: horimini,
            horimfim: horimfim,
            valhora: valhora,
            'horimini original': horiminiInput.value,
            'horimfim original': horimfimInput.value
        });

        // Calcular horas trabalhadas - cálculo exato
        const horasTrabalhadas = horimfim - horimini;

        console.log('Horas trabalhadas calculadas:', horasTrabalhadas);

        // Usar formatação COM ARREDONDAMENTO CORRETO para 1 casa decimal
        tothmaquinaInput.value = horasTrabalhadas >= 0 ? formatarHoras(horasTrabalhadas) : '0,0';

        // Calcular valor total
        const totalMaquina = horasTrabalhadas * valhora;
        totmaquinaInput.value = totalMaquina > 0 ?  formatarNumeroArredondado(totalMaquina, 2) : '0,00';
    }

    // Função para calcular material/diária
    function calcularMaterial() {
        const qtda = brasileiroParaNumero(qtdaInput.value);
        const valora = brasileiroParaNumero(valoraInput.value);

        const total = qtda * valora;
        totalaInput.value = total > 0 ? formatarNumeroArredondado(total, 2) : '0,00';
    }

    // Event listeners para cálculo automático
    horiminiInput.addEventListener('input', calcularHorasMaquina);
    horimfimInput.addEventListener('input', calcularHorasMaquina);
    valhoraInput.addEventListener('input', calcularHorasMaquina);
    qtdaInput.addEventListener('input', calcularMaterial);
    valoraInput.addEventListener('input', calcularMaterial);

    // Converter valores com vírgula para ponto antes do envio do formulário
    const form = document. querySelector('form');
    form.addEventListener('submit', function(e) {
        // Converter campos decimais com vírgula para ponto
        const camposParaConverter = ['horimini', 'horimfim', 'valhora', 'tothmaquina', 'totmaquina', 'qtda', 'valora', 'totala'];

        camposParaConverter. forEach(function(campoName) {
            const campo = document.querySelector(`[name="${campoName}"]`);
            if (campo && campo.value) {
                // Substituir vírgula por ponto
                campo.value = campo.value.replace(',', '.');
            }
        });
    });

    // Inicializar cálculos
    calcularHorasMaquina();
    calcularMaterial();
});

// Script para Select2
$(document).ready(function() {
    $('. select2-veiculo').select2({
        placeholder: "Código",
        allowClear:  true,
        language: {
            noResults: function() {
                return "Nenhum resultado encontrado";
            },
            searching: function() {
                return "Buscando...";
            }
        },
        matcher: function(params, data) {
            if ($.trim(params. term) === '') {
                return data;
            }

            var term = params.term.toLowerCase();
            var text = data.text.toLowerCase();
            var codigo = $(data.element).data('codigo') || '';

            if (text.indexOf(term) > -1 || codigo.toString().toLowerCase().indexOf(term) > -1) {
                return data;
            }

            return null;
        }
    });

    $('.select2-operador').select2({
        placeholder: "Nome",
        allowClear:  true,
        language: {
            noResults: function() {
                return "Nenhum resultado encontrado";
            },
            searching: function() {
                return "Nenhum resultado encontrado";
            }
        }
    });
});
</script>
