    <div class="form-layout ">
        <div class="row mg-b-25 ">
            <div class="col-lg-2  ">
                <div class="form-group ">
                    <label class="form-control-label btn-sm">Veículos: <span class="tx-danger">*</span></label>
                    <select name="tex_veiculos" class="form-select btn-sm" style="border-radius: 10px">
                        <option value="">
                            {{ $equipamentos->id ?? 'Selecione' }}</option>
                        @foreach ($equipamentos as $equipamento)
                            <option value="{{ $equipamento->id }}">
                                {{ $equipamento->codigo }} / {{ $equipamento->modelo }}
                            </option>
                        @endforeach
                    </select required>
                </div>
            </div><!-- col-2 -->
            <div class="col-lg-2  ">
                <div class="form-group ">
                    <label class="form-control-label btn-sm">Fornecedor: <span class="tx-danger">*</span></label>
                    <select name="tex_fornecedor" class="form-select  btn-sm" style="border-radius: 10px">
                        <option value="">
                            {{ $cliefornes->id ?? 'Selecione' }}</option>
                        @foreach ($cliefornes as $clieforne)
                            <option value="{{ $clieforne->id }}">{{ $clieforne->nome }}
                            </option>
                        @endforeach
                    </select required>
                </div>
            </div><!-- col-2 -->
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label btn-sm">Combustível: <span class="tx-danger">*</span></label>
                    <select name="tex_combustivel" class="form-select  btn-sm" style="border-radius: 10px">
                        <option value="">Selecione</option>
                        <option value="1">Disel S500</option>
                        <option value="1">Diesel S10 </option>
                        <option value="1">Gasolina </option>
                        <option value="1">Gasolina Aditivada</option>
                        <option value="1">Etanol </option>
                    </select required>
                </div>
            </div><!-- col-2 -->
            <div class="col-lg-2">
                <div class="form-group">
                    <label class="form-control-label btn-sm">Data: <span class="tx-danger">*</span></label>
                    <input class="form-control btn-sm" style="border-radius: 10px" type="date" name="tex_data"
                        value="{{ old('tex_data', $abastecimento->datacad ?? '') }}" required>
                </div>
            </div><!-- col-2 -->
        </div><!-- row  25 -->
        <div class="row mg-b-25 ">
            <div class="col-lg-1">
                <div class="form-group">
                    <label class="form-control-label btn-sm">Litros: <span class="tx-danger">*</span></label>
                    <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="qtda"
                        id="qtda" value="{{ old('qtda', $abastecimento->qtda ?? '') }}" required>
                </div>
            </div><!-- col-2 -->
            <div class="col-lg-1">
                <div class="form-group">
                    <label class="form-control-label btn-sm">Valor: <span class="tx-danger">*</span></label>
                    <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="valora"
                        id="valora" value="{{ old('valora', $abastecimento->valora ?? '') }}" required>
                </div>
            </div><!-- col-2 -->
            <div class="col-lg-1">
                <div class="form-group">
                    <label class="form-control-label btn-sm">Desconto :<span class="tx-danger">*</span></label>
                    <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="desconto"
                        id="desconto" value="{{ old('desconto', $abastecimento->desconto ?? '') }}" required>
                </div>
            </div><!-- col-2 -->
            <div class="col-lg-1">
                <div class="form-group">
                    <label class="form-control-label">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    <input class="form-control  btn btn-secondary btn-sm" style="border-radius: 10px" type="button"
                        name="Calcular" id="Calcular" value="Calcular" onclick="somacam()">
                </div>
            </div><!-- col-2 -->
            <div class="col-lg-1">
                <div class="form-group">
                    <label class="form-control-label btn-sm">Total R$ :</label>
                    <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="totala"
                        id="totala" value="{{ old('totala', $abastecimento->totala ?? '') }}" readonly required>
                </div>
            </div><!-- col-2 -->
        </div><!-- row  25 -->
    </div><!--layout form-->
