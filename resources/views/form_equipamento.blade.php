       <input type="hidden" name="id" value="{{ Crypt::encrypt($equipamento->id ?? '') }}">
       <div class="form-layout ">
           <div class="row mg-b-25 ">
               <div class="col-lg-1  ">
                   <div class="form-group ">
                       <label class="form-control-label btn-sm">Código: <span class="tx-danger">*</span></label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_codigo"
                           required value="{{ old('tex_codigo', $equipamento->codigo ?? '') }}">
                       {{-- Show Error --}}
                       @error('tex_codigo')
                           <div class="text-danger">{{ $message }}</div>
                       @enderror
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-2">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Marca:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_marca"
                           value="{{ old('tex_marca', $equipamento->marca ?? '') }}" required>
                   </div>
               </div><!-- col-4 -->


               <div class="col-lg-2">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Modelo:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_modelo"
                           value="{{ old('tex_modelo', $equipamento->modelo ?? '') }}">
                   </div>
               </div><!-- col-4 -->

               <div class="col-lg-2">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Categoria:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text"
                           name="tex_categoria" value="{{ old('tex_categoria', $equipamento->categoria ?? '') }}">
                   </div>
               </div><!-- col-4 -->


               <div class="col-lg-2">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Cor:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_cor"
                           value="{{ old('tex_cor', $equipamento->cor ?? '') }}">
                   </div>
               </div><!-- col-4 -->

               <div class="col-lg-1">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Placa:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_placa"
                           value="{{ old('tex_placa', $equipamento->placa ?? '') }}">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-1">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Ano:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_ano"
                           value="{{ old('tex_ano', $equipamento->ano ?? '') }}">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-3">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Renavam:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_renavam"
                           value="{{ old('tex_renavam', $equipamento->renavam ?? '') }}">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-3">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Chassi:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_chassi"
                           value="{{ old('tex_chassi', $equipamento->chassi ?? '') }}">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-1">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Potência:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_potencia"
                           value="{{ old('tex_potencia', $equipamento->potencia ?? '') }}">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-2">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Motor:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_motor"
                           value="{{ old('tex_motor', $equipamento->motor ?? '') }}">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-2">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Propietário:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_prop"
                           value="{{ old('tex_prop', $equipamento->prop ?? '') }}">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-2">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Valor: <span class="tx-danger">*</span></label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text"
                           name="tex_valor" value="{{ old('tex_valor', $equipamento->valor ?? '') }}" required>
                   </div>
               </div><!-- col-4 -->

               <div class="col-lg-1">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Alienação:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text"
                           name="tex_alienacao" value="{{ old('tex_alienacao', $equipamento->alienacao ?? '') }}">
                   </div>
               </div><!-- col-4 -->

               <div class="col-lg-2">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Apólice:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text"
                           name="tex_apolice" value="{{ old('tex_apolice', $equipamento->apolice ?? '') }}">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-2">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Vencimento:</label>
                       <input class="form-control btn-sm" style="border-radius: 10px" type="text" name="tex_venc"
                           value="{{ old('tex_venc', $equipamento->venc ?? '') }}">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-4">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Imagem:</label>
                       <input type="file" name="image" class="form-control  btn-sm"
                           style="border-radius: 10px">
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-12">
                   <div class="form-group">
                       <label class="form-control-label btn-sm">Observação: <span class="tx-danger">*</span></label>
                       <textarea class="form-control btn-sm" style="border-radius: 10px" name="tex_obs" rows="3" required>{{ old('tex_obs', $equipamento->observacao ?? '') }}</textarea>
                   </div>
               </div><!-- col-4 -->
               <div class="col-lg-1">
                   <div class="form-group">
                       @if (!empty($equipamento->image))
                           <img src="{{ asset('../storage/app/public/' . $equipamento->image) }}" class="mt-2 shadow"
                               width="150">
                       @endif
                   </div>
               </div><!-- col-4 -->
           </div><!-- row  25 -->
       </div><!-- row  25 -->
