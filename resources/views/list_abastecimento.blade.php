 @if (session('mensagem'))
     <div class="alert alert-warning mt-3 fw-bold" style="border-radius: 15px;text-align: center; ">
         {{ session('mensagem') }}
     </div>
 @endif
 <div style="border-radius: 10px; background-color: #eaf4e5; color: rgb(90, 86, 86);">
     <table class="table table-hover  ">
         <thead>
             <tr>
                 <th scope="col order-5" style="border-radius: 20px 0 0 20px;background-color: #dcecd3;color: #30a300;">
                     Fornecedor
                 </th>
                 <th scope="col" style="background-color: #dcecd3; color: #30a300;">Modelo</th>
                 <th scope="col" style="background-color: #dcecd3; color: #30a300;">Marca</th>
                 <th scope="col" style="background-color: #dcecd3; color: #30a300;">Código</th>
                 <th scope="col" style="border-radius: 0 20px 20px 0;background-color: #dcecd3; color: #30a300;">
                     &nbsp;
                 </th>
             </tr>
         </thead>
         <tbody>
             @forelse ($Abastecimento as $abastecimento)
                 <tr>
                     <th scope="row">
                         {{ $abastecimento->cliefornes_nome }}
                     </th>
                     <td>
                         {{ $abastecimento->equipamentos_marca }}
                     </td>
                     <td> {{ $abastecimento->equipamentos_modelo }}</td>
                     <td> {{ $abastecimento->equipamentos_codigo }}</td>
                     <td><a href="{{ route('editAbastecimento', ['id' => Crypt::encrypt($abastecimento['abastecimentos_id'])]) }}"
                             class="btn btn-outline-secondary btn-sm mx-1  rounded-pill"><i
                                 class="fa-regular fa-pen-to-square "></i></a>
                         <a href="{{ route('deleteAbastecimento', ['id' => Crypt::encrypt($abastecimento['abastecimentos_id'])]) }}"
                             class="btn btn-outline-danger btn-sm mx-1  rounded-pill"> <i
                                 class="fa-regular fa-trash-can"></i></a>
                     </td>
                 </tr>
             @empty
                 <tr>
                     <td colspan="5">Sem dados.</td>
                 </tr>
             @endforelse
         </tbody>
     </table>
 </div>
