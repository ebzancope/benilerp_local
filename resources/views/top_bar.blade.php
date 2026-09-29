<div class="slim-header" style=" color: #30a300; background: linear-gradient(to right, #dcecd3, #FFFCFCFF);
 padding:
        15px; border-radius: 8px;">
    <div class="container ">
        <div class="slim-header-left">
            <h2 class="slim-logo"><a href="{{ route('oservico') }}">
                    <img src="{{ asset('assets/img/Logo_benil_11-2025.png') }}" alt="Gestão Benil" width="145"></a>
            </h2>
        </div><!-- slim-header-left -->
        <div class="col-md-6 section-title fst-italic" style="color: #A3004F; text-align: center; margin-top: 10px;">
            <h2>  <i class="fa-brands fa-apple"></i> <i class="fa-solid fa-gear"></i> Sistema de gestão <i class="fa-brands fa-android"></i> <i class="fa-solid fa-wand-magic-sparkles"></i> **</h2>
        </div>
        <div class="slim-header-right">
            <div class="container text-center">
                <div class="row align-items-start">
                    <div class="col">
                        Olá {{ session('user.name') }} -
                        @if(!session('user.photo'))
                        <i class="fas fa-user"></i>
                        @else
                        <img src="{{ session('user.photo') ? asset('../storage/app/public/' . session('user.photo')) : '' }}"
                            class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;"><br>
                        @endif
                        <a href="{{ route('logout') }}" class="btn btn-outline-secondary btn-sm px-3 rounded-pill">
                            Sair&nbsp; &nbsp; <i class="fa-solid fa-arrow-right-from-bracket"> </i>
                        </a>
                    </div>
                </div>
            </div>
        </div><!-- header-right -->
    </div><!-- container -->
</div><!-- slim-header -->
<div class="slim-navbar shadow " style="border-radius: 20%;padding: 15px; ">
    <div class="container ">
        <ul class="nav ">
            <li class="nav-item with-sub @if (session('place') == '1') active @endif ">
                <a class="nav-link " style="border-radius: 25px" href="#">
                    <i class="icon ion-person"></i>
                    <span>Cadastros</span>
                </a>
                <div class="shadow sub-item " style="border-radius: 25px">
                    <ul>
                        <li><a style="border-radius: 25px" href="{{ route('cliefornes.index') }} "
                                class="text-decoration-none" data-toggle="tooltip" data-placement="top"
                                title="Cadastra Edita e Exclui"> <i class="fa-solid fa-circle-chevron-right"></i>
                                Clientes / Fornecedores</a>
                        </li>
                        <li><a style="border-radius: 25px" href="{{ route('colaboradores.index') }}"
                                class="text-decoration-none">
                                <i class="fa-solid fa-circle-chevron-right"></i> Colaboradores</a>
                        </li>
            </li>
            <li><a style="border-radius: 25px" href="{{ route('users.index') }}" class="text-decoration-none"> <i
                        class="fa-solid fa-circle-chevron-right"></i> Usuários do sistema</a></li>
        </ul>
    </div>
    </li>
    <li class="nav-item with-sub @if (session('place') == '2') active @endif ">
        <a class="nav-link" style="border-radius: 25px" href="#">
            <i class=" icon ionicons ion-ios-paper-outline"></i>
            <span> Serviços</span>
        </a>
        <div class="shadow sub-item " style="border-radius: 25px">
            <ul>

                <li><a style="border-radius: 25px" href="{{ route('orcamentos.index') }}" class="text-decoration-none">
                        <i class="fa-solid fa-circle-chevron-right"></i> Orçamento</a>
                </li>

                <li><a style="border-radius: 25px" href="{{ route('cronograma.index') }}" class="text-decoration-none">
                        <i class="fa-solid fa-circle-chevron-right"></i> Cronograma</a>
                </li>
                <li><a style="border-radius: 25px" href="{{ route('oservico') }}" class="text-decoration-none"> <i
                            class="fa-solid fa-circle-chevron-right"></i> Ordem de Serviço</a>
                </li>
            </ul>
        </div><!-- dropdown-menu -->
    </li>
    <li class="nav-item with-sub @if (session('place') == '3') active @endif ">
        <a class="nav-link" style="border-radius: 25px" href="#">
            <i class="fa-solid fa-warehouse"></i>
            <span>Almoxarifado</span>
        </a>
        <div class="shadow sub-item" style="border-radius: 25px">
            <ul>
                <li>
                    <a style="border-radius: 25px" href="{{ route('almoxarifado.index') }}"
                        class="text-decoration-none">
                        <i class="fa-solid fa-boxes"></i> Gestão de Itens
                    </a>
                </li>
                <li>
                    <a style="border-radius: 25px" href="{{ route('almoxarifado.relatorio') }}"
                        class="text-decoration-none">
                        <i class="fas fa-chart-bar"></i> Relatório
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item with-sub  @if (session('place') == '4') active @endif ">
        <a class="nav-link" style="border-radius: 25px" href="#">
            <i class="icon ion-arrow-graph-up-right"></i>
            <span>Finanças</span>
        </a>
        <div class="shadow sub-item " style="border-radius: 25px">
            <ul>
                <li><a style="border-radius: 25px" href="{{ route('boletos.index') }}" class="text-decoration-none">
                        <i class="fa-solid fa-circle-chevron-right"></i>
                        Boletos</a>
                </li>

                <li><a style="border-radius: 25px" href="{{ route('despesas.index') }}" class="text-decoration-none">
                        <i class="fa-solid fa-circle-chevron-right"></i> Despesas
                    </a>
                </li>
                <li><a style="border-radius: 25px" href="{{ route('selectFatMaquina') }}" class="text-decoration-none">
                        <i class="fa-solid fa-circle-chevron-right"></i>
                        Faturamento (OS)</a>
                </li>





            </ul>
        </div><!-- dropdown-menu -->
    </li>
    <li class="nav-item with-sub  @if (session('place') == '5') active @endif">
        <a class="nav-link" style="border-radius: 25px" href="#" data-toggle="dropdown ">
            <i class="icon ion-model-s"></i>
            <span>Frota</span>
        </a>
        <div class="shadow sub-item" style="border-radius: 25px">
            <ul>


                <li><a style="border-radius: 25px" href="{{ route('preco-equipamentos.index') }}"
                        class="text-decoration-none"><i class="fa-solid fa-circle-chevron-right"></i> Tabela de Preço
                    </a>
                </li>
                <li><a style="border-radius: 25px" href="{{ route('equipamentos.index') }}"
                        class="text-decoration-none"><i class="fa-solid fa-circle-chevron-right"></i> Veículos /
                        Equipamentos
                    </a>
                </li>


                <li><a style="border-radius: 25px" href="{{ route('abastecimentos.index') }}"
                        class="text-decoration-none" data-toggle="tooltip" data-placement="top"
                        title="Cadastra Edita e Exclui"><i class="fa-solid fa-circle-chevron-right"></i>
                        Abastecimentos</a>

                </li>









            </ul>



        </div>
    </li>


    </ul>




</div><!-- container -->
</div><!-- slim-navbar -->
