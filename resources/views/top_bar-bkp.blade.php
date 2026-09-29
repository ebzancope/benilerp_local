
<link rel="icon" href="assets/img/Logo_benil_-e1687008824775-150x150.png" sizes="32x32" />
<link rel="icon" href="assets/img/Logo_benil_-1024x1024.png" sizes="192x192" />
<link rel="apple-touch-icon" href="assets/img/Logo_benil_-1024x1024.png" />
<meta name="msapplication-TileImage" content="assets/img/Logo_benil_-1024x1024.png" />
<title>ERP Benil</title>

<!-- css 1 -->
<link href="{{ asset('assets/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('assets/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
<!-- vendor css 2 -->
<link href="{{ asset('assets/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
<link href="{{ asset('assets/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/lib/chartist/css/chartist.css') }}" rel="stylesheet">
<link href="{{ asset('assets/lib/rickshaw/css/rickshaw.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('assets/lib/select2/css/select2.min.css') }}" rel="stylesheet">
<!--C SS 3-->
<link href="{{ asset('assets/css/slim.css') }}" rel="stylesheet">
<script language="javascript" src="{{ asset('assets/js/funcoes_adm.js') }}"></script>
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

<link href="{{ asset('bootstrap.bundle.min.js') }}"></script>

<script src="{{ asset('assets/lib/jquery/js/jquery.js') }}"></script>
<script src="{{ asset('assets/lib/popper.js/js/popper.js') }}"></script>
<script src="{{ asset('assets/lib/bootstrap/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/lib/jquery.cookie/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/lib/chartist/js/chartist.js') }}"></script>
<script src="{{ asset('assets/lib/d3/js/d3.js') }}"></script>
<script src="{{ asset('assets/lib/rickshaw/js/rickshaw.min.js') }}"></script>
<script src="{{ asset('assets/lib/jquery.sparkline.bower/js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/js/horimetro.js') }}"></script>
<script src="{{ asset('assets/js/ResizeSensor.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="{{ asset('assets/js/slim.js') }}"></script>


<div class="slim-header">
    <div class="container">
        <div class="slim-header-left">
            <h2 class="slim-logo"><a href="{{ route('home') }}">
                    <img src="{{ asset('assets/img/Logo_benil_-1024x1024.png') }}" alt="Gestão Benil"
                        width="150"></a></h2>
            <div class="search-box">
                <input type="text" class="form-control" placeholder="Busca - Atualizando ...">
                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
            </div><!-- search-box -->
        </div><!-- slim-header-left -->
        <div class="slim-header-right">

            <!-- dropdown alerta  -->
            <div class="dropdown dropdown-a">
                <a href="" class="header-notification" data-toggle="dropdown">
                    <i class="icon ion-ios-bell-outline "></i>
                    <span class="indicator"></span>
                </a>
                <div class="shadow dropdown-menu">
                    <div class="dropdown-menu-header">
                        <h6 class="dropdown-menu-title">Alertas de Boletos</h6>
                        <div>
                            <a href="#" class="text-decoration-none">Fechar X &nbsp; &nbsp; </a>
                        </div>
                    </div><!-- dropdown-menu-header -->
                    <div class="dropdown-activity-list">

                        <div class="activity-label">Vencidos
                        </div>
                        <div class="activity-item">
                            <div class="row no-gutters">
                                <div class="col-2 tx-right">
                                    &nbsp;
                                </div>
                                <div class="col-2 tx-center"><span class="square-10 bg-danger"></span></div>
                                <div class="col-8">
                                    <strong>
                                        56,85 Boletos
                                    </strong>
                                </div>
                            </div><!-- row -->
                        </div><!-- activity-item -->

                        <div class="activity-label">Hoje
                        </div>
                        <div class="activity-item">
                            <div class="row no-gutters">
                                <div class="col-2 tx-right">
                                    &nbsp;
                                </div>
                                <div class="col-2 tx-center"><span class="square-10 bg-warning"></span></div>
                                <div class="col-8">
                                    <strong>
                                        56,25Boletos
                                    </strong>
                                </div>
                            </div><!-- row -->
                        </div><!-- activity-item -->

                        <div class="activity-label">Vencer
                        </div>
                        <div class="activity-item">
                            <div class="row no-gutters">
                                <div class="col-2 tx-right">
                                    &nbsp;
                                </div>
                                <div class="col-2 tx-center"><span class="square-10 bg-success"></span></div>
                                <div class="col-8">
                                    <strong>
                                        25,36 Boletos
                                    </strong>
                                </div>
                            </div><!-- row -->
                        </div><!-- activity-item -->

                    </div><!-- dropdown-activity-list -->
                    <div class="dropdown-list-footer">
                        <a href="#" class="text-decoration-none"><i class="fa fa-angle-down"></i> Outros
                            vencimentos</a>
                    </div>
                </div><!-- dropdown-menu-right -->
            </div><!-- dropdown alerta -->
            <div class="dropdown dropdown-c">
                <a href="#" class="logged-user text-decoration-none" data-toggle="dropdown">
                    <img src="{{ asset('assets/img/No_user.png') }}" alt="No User" width="10"  loading="lazy" >
                    <span>
                        Usuário Logado
                    </span>
                    <i class="fa fa-angle-down"></i>
                </a>
                <div class="shadow dropdown-menu dropdown-menu-right">
                    <nav class="nav">
                        <a href="#" class="nav-link"><i class="icon ion-person"></i> Meu dados</a>
                        <a href="#" class="nav-link"><i class="icon ion-ios-bolt"></i> Acessos </a>
                        <a href="#" class="nav-link"><i class="icon ion-ios-gear"></i>
                            Configurações</a>
                        <a href="{{ route('Logout') }}" class="nav-link"><i class="icon ion-forward"></i> Sair</a>
                    </nav>
                </div><!-- dropdown-menu -->
            </div><!-- dropdown -->
        </div><!-- header-right -->
    </div><!-- container -->
</div><!-- slim-header -->
<div class="slim-navbar">
    <div class="container">
        <ul class="shadow nav">
            <li class="nav-item with-sub active"> <!-- Backgroud Menus Obs: Preciso passar via route os parâmtros para mudar a cor do background -->
                <a class="nav-link" href="#">
                    <i class="icon ion-person"></i>
                    <span>Cadastros</span>
                </a>
                <div class="shadow sub-item">
                    <ul>
                        <li><a href="#" class="text-decoration-none">Clientes e Fornecedores </a></li>
                        <li><a href="#" class="text-decoration-none">Colaboradores</a>
                        </li>
                        <li><a href="#" class="text-decoration-none">Tabela de Preço</a>
                        </li>
                        <li><a href="#" class="text-decoration-none">Usuários do sistema</a>
                        </li>
                    </ul>
                </div><!-- dropdown-menu -->
            </li>
            <li class="nav-item with-sub ">
                <a class="nav-link" href="#">
                    <i class=" icon ionicons ion-ios-paper-outline"></i>
                    <span>Serviços</span>
                </a>
                <div class="shadow sub-item">
                    <ul>
                        <li><a href="#" class="text-decoration-none"> Ordem de Serviço</a>
                        </li>
                        <li><a href="#" class="text-decoration-none">Agendar visitas</a>
                        </li>

                    </ul>
                </div><!-- dropdown-menu -->
            </li>
            <li class="nav-item with-sub ">
                <a class="nav-link" href="#">
                    <i class="icon ion-ios-box-outline"></i>
                    <span>Almoxarifado</span>
                </a>
                <div class="shadow sub-item">
                    <ul>
                        <li><a href="#" class="text-decoration-none">Controle de estoque</a></li>
                        <li><a href="#" class="text-decoration-none">Pedidos de compra</a></li>
                        <li><a href="#" class="text-decoration-none">Gerar pedidos de material</a></li>
                        <li><a href="#" class="text-decoration-none">Conferência de estoque</a></li>
                        <li><a href="#" class="text-decoration-none">Relatórios</a></li>
                    </ul>
                </div><!-- dropdown-menu -->
            </li>
            <li class="nav-item with-sub ">
                <a class="nav-link" href="#">
                    <i class="icon ion-arrow-graph-up-right"></i>
                    <span>Finanças</span>
                </a>
                <div class="shadow sub-item">
                    <ul>
                        <li><a href="#" class="text-decoration-none">Boletos</a>
                        </li>
                        <li><a href="#" class="text-decoration-none">Despesas </a>
                        </li>
                        <li><a href="#" class="text-decoration-none">Fechamento de OS</a>
                        </li>
                        <li><a href="#" class="text-decoration-none">Relatório Do Trimestre </a>
                        </li>
                        <li><a href="#" class="text-decoration-none">DRE</a></li>
                    </ul>
                </div><!-- dropdown-menu -->
            </li>
            <li class="nav-item with-sub ">
                <a class="nav-link" href="#" data-toggle="dropdown ">
                    <i class="icon ion-model-s"></i>
                    <span>Frota</span>
                </a>
                <div class="shadow sub-item">
                    <ul>
                        <li><a href="#" class="text-decoration-none" data-toggle="tooltip"
                                data-placement="top" title="Cadastra Edita e Exclui">Abastecimentos</a>
                        </li>
                        <li><a href="#" class="text-decoration-none">Veículos e Equipamentos</a>
                        </li>
                        <li><a href="#" class="text-decoration-none">Relatório de Faturamento</a>
                        </li>
                        <li><a href="#" class="text-decoration-none">Relatório de Despesas</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div><!-- container -->
</div><!-- slim-navbar -->

