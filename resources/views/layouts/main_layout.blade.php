<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('assets/img/Logo_benil_-e1687008824775-150x150.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('assets/img/Logo_benil_-1024x1024.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('assets/img/Logo_benil_-1024x1024.png') }}" />
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/Logo_benil_-1024x1024.png') }}" />
    <meta http-equiv="Content-Language" content="pt-br">
    <meta charset="utf-8">
    <meta name="description" content="ERP Rocha & Zancope LTDA.">
    <meta name="author" content="Ebzancope">
    <link rel="icon" href="{{ asset('assets/img/Logo_benil_-e1687008824775-150x150.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('assets/img/Logo_benil_-1024x1024.png" sizes="192x192') }}" />
    <link rel="apple-touch-icon" href="{{ asset('assets/img/Logo_benil_-1024x1024.png') }}" />
    <meta name="msapplication-TileImage" content="{{ asset('assets/img/Logo_benil_-1024x-1024.png') }}" />
    <title>ERP Benil</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <!-- css 1 -->
    <link rel="preload" href="{{ asset('assets/lib/bootstrap/bootstrap.min.css') }}" as="style">
    <link href="{{ asset('assets/lib/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="preload" href="{{ asset('assets/lib/font-awesome/css/font-awesome.css') }}" as="style">
    <link href="{{ asset('assets/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="preload" href="{{ asset('assets/lib/Ionicons/css/ionicons.css') }}" as="style">
    <link href="{{ asset('assets/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <!-- vendor css 2 -->
    <link rel="preload" href="{{ asset('assets/lib/font-awesome/css/font-awesome.css') }}" as="style">
    <link href="{{ asset('assets/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="preload" href="{{ asset('assets/lib/Ionicons/css/ionicons.css') }}" as="style">
    <link href="{{ asset('assets/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">
    <link rel="preload" href="{{ asset('assets/lib/chartist/css/chartist.css') }}" as="style">
    <link href="{{ asset('assets/lib/chartist/css/chartist.css') }}" rel="stylesheet">
    <link rel="preload" href="{{ asset('assets/lib/rickshaw/css/rickshaw.min.css') }}" as="style">
    <link href="{{ asset('assets/lib/rickshaw/css/rickshaw.min.css') }}" rel="stylesheet">
    <link rel="preload" href="{{ asset('assets/lib/datatables/css/jquery.dataTables.css') }}" as="style">
    <link href="{{ asset('assets/lib/datatables/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link rel="preload" href="{{ asset('assets/lib/select2/css/select2.min.css') }}" as="style">
    <link href="{{ asset('assets/lib/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--C SS 3-->
    <link rel="preload" href="{{ asset('assets/css/slim.css') }}" as="style">
    <link href="{{ asset('assets/css/slim.css') }}" rel="stylesheet">
    <link rel="preload" href="{{ asset('assets/css/bootstrap.min.cs') }}" as="style">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="preload" href="{{ asset('assets/fontawesome/css/all.min.css') }}" as="style">
    <link href="{{ asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet">
    <link language="javascript" href="{{ asset('bootstrap.bundle.min.js') }}">
    <script language="javascript" src="{{ asset('assets/js/funcoes_adm.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/lib/jquery/js/jquery.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/lib/popper.js/js/popper.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/lib/bootstrap/js/bootstrap.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/lib/jquery.cookie/js/jquery.cookie.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/lib/chartist/js/chartist.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/lib/d3/js/d3.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/lib/rickshaw/js/rickshaw.min.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/lib/jquery.sparkline.bower/js/jquery.sparkline.min.js') }}">
    </script>
    <script language="javascript" src="{{ asset('assets/js/horimetro.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/js/ResizeSensor.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script language="javascript" src="{{ asset('assets/js/slim.js') }}"></script>
    <script language="javascript" type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script language="javascript" type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script language="javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script slanguage="javascript" rc="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body>
    @if (Route::has('login'))
        @section('content')
            <form action="{{ route('loginSubmit') }}" method="POST">
                @csrf
                <div class="signin-wrapper">
                    <div class="signin-box" style="border-radius: 5%;padding: 15px; background-color: #f6faf4;">
                        <h2 class="signin-title-primary" style="text-align: center "><img
                                src="{{ asset('assets/img/7094814.jpg') }}" width="350" alt="Gestão Benil"><br>&nbsp;
                            Sistema de Gestão ERP
                        </h2>
                        <div class="form-group">
                            <input type="text" style="border-radius: 15px" class="form-control" name="adm_login"
                                value="{{ old('adm_login') }}" placeholder="Usuário">
                        </div><!-- form-group -->
                        <div class="form-group mg-b-10">
                            <input type="password" style="border-radius: 15px" class="form-control" name="adm_senha"
                                value="{{ old('adm_senha') }}" placeholder="Senha">
                            {{-- Show Error
                            @error('adm_senha')
                            <div class="text-danger">{{$message}}</div>
                            @enderror --}}
                        </div><!-- form-group -->
                        <button class="btn   btn-block  "
                            style=" float: right; color: #ffffff; background-color: #30a300; border-radius: 15px"
                            type="submit">
                            &nbsp; &nbsp; &nbsp;<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                fill="currentColor" class="bi bi-save" viewBox="0 0 640 640">
                                <path
                                    d="M409 337C418.4 327.6 418.4 312.4 409 303.1L265 159C258.1 152.1 247.8 150.1 238.8 153.8C229.8 157.5 224 166.3 224 176L224 256L112 256C85.5 256 64 277.5 64 304L64 336C64 362.5 85.5 384 112 384L224 384L224 464C224 473.7 229.8 482.5 238.8 486.2C247.8 489.9 258.1 487.9 265 481L409 337zM416 480C398.3 480 384 494.3 384 512C384 529.7 398.3 544 416 544L480 544C533 544 576 501 576 448L576 192C576 139 533 96 480 96L416 96C398.3 96 384 110.3 384 128C384 145.7 398.3 160 416 160L480 160C497.7 160 512 174.3 512 192L512 448C512 465.7 497.7 480 480 480L416 480z" />
                            </svg>&nbsp; &nbsp;Entrar &nbsp; &nbsp; &nbsp; &nbsp;
                            <?php //   ($id == -1) ? "Editar" : "Salvar"
                            ?>
                        </button> <br>
                        {{-- Invalid Login --}}
                        @if (session('LoginError'))
                            <div class="alert alert-danger mt-3" style="border-radius: 15px">
                                {{ session('LoginError') }}
                            </div>
                        @endif
                        {{-- Errors --}}
                        @if ($errors->any())
                            <div class="alert alert-danger mt-3" style="border-radius: 15px">
                                <ul class="m-0">
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="alert alert-danger mt-3" style="border-radius: 15px">
                                <div>
                                    <p class="mg-b-0">Esqueceu a senha? <a href="#">clique aqui.</a></p>
                                </div>
                            </div>
                        @endif
                        <h2 class="signin-title-primary tx-center">
                            <a href="https://play.google.com/"><img src="{{ asset('assets/img/playstore.png') }}"
                                    class="media-object  img-responsive img-thumbnail" width="100"></a><br>
                            <img src="{{ asset('assets/img/App_ERP_Benil.png') }}" alt="PlayStore" width="80">
                        </h2>
                    </div><!-- signin-box -->
                </div><!-- signin-wrapper -->
            </form>
        @endsection
    @else
        <div class="slim-header">
            <div class="container">
                <div class="slim-header-left">
                    <h2 class="slim-logo"><a href="{{ route('home') }}">
                            <img src="{{ asset('assets/img/Logo_benil_-1024x1024.png') }}" alt="Gestão Benil"
                                width="150"></a>
                    </h2>
                </div><!-- slim-header-left -->
                <div class="search-box ">
                    <input type="text" class="form-control " placeholder="Busca - Atualizando ...">
                    <button class="btn btn-success"
                        style="border-radius: 50%;padding: 5px; background-color: #2d710b"><i
                            class="fa fa-search"></i></button>
                </div><!-- search-box -->
                <div class="slim-header-right">
                    <div class="container text-center">
                        <div class="row align-items-start">
                            <div class="col">
                                Olá {{ session('user.name') }} <br>
                                <a href="{{ route('logout') }}"
                                    class="btn btn-outline-secondary btn-sm px-3 rounded-pill">
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
                    <li class="nav-item with-sub @if (request()->query('place') == 1) {{ 'active' }} @endif ">
                        <a class="nav-link " style="border-radius: 25px" href="#">
                            <i class="icon ion-person"></i>
                            <span>Cadastros</span>
                        </a>
                        <div class="shadow sub-item " style="border-radius: 25px">
                            <ul>
                                <li><a style="border-radius: 25px"href="{{ route('cadclieforne') }}?place=1 "
                                        class="text-decoration-none" data-toggle="tooltip" data-placement="top"
                                        title="Cadastra Edita e Exclui"> <i
                                            class="fa-solid fa-circle-chevron-right"></i>
                                        Clientes e Fornecedores</a>
                                </li>
                                <li><a style="border-radius: 25px"href="{{ route('cadcolab') }}"
                                        class="text-decoration-none">
                                        <i class="fa-solid fa-circle-chevron-right"></i> Colaboradores</a>
                                </li>

                    </li>
                    <li><a style="border-radius: 25px" href="#" class="text-decoration-none"> <i
                                class="fa-solid fa-circle-chevron-right"></i> Usuários do
                            sistema</a></li>
                </ul>
            </div>
            </li>
            <li class="nav-item with-sub @if (request()->query('place') == 2) {{ 'active' }} @endif ">
                <a class="nav-link" style="border-radius: 25px"href="#">
                    <i class=" icon ionicons ion-ios-paper-outline"></i>
                    <span> Serviços</span>
                </a>
                <div class="shadow sub-item " style="border-radius: 25px">
                    <ul>
                        <li><a style="border-radius: 25px" href="{{ route('cados') }}?place=2"
                                class="text-decoration-none"> <i class="fa-solid fa-circle-chevron-right"></i>
                                Ordem de Serviço</a>
                        </li>
                        <li><a style="border-radius: 25px" href="{{ route('cadagenda') }}?place=2"
                                class="text-decoration-none">
                                <i class="fa-solid fa-circle-chevron-right"></i> Agendar
                                visitas</a>
                        </li>

                    </ul>
                </div><!-- dropdown-menu -->
            </li>
            <li class="nav-item with-sub  @if (request()->query('place') == 3) {{ 'active' }} @endif ">
                <a class="nav-link"style="border-radius: 25px" href="#">
                    <i class="icon ion-ios-box-outline"></i>
                    <span>Almoxarifado</span>
                </a>
                <div class="shadow sub-item " style="border-radius: 25px">
                    <ul>
                        <li><a style="border-radius: 25px" href="{{ route('Almoxarifado') }}?place=3"
                                class="text-decoration-none"> <i class="fa-solid fa-circle-chevron-right"></i>
                                Controle
                                de
                                estoque</a></li>
                        <li><a style="border-radius: 25px" href="#" class="text-decoration-none"> <i
                                    class="fa-solid fa-circle-chevron-right"></i> Pedidos de
                                compra</a></li>

                        <li><a style="border-radius: 25px" href="#" class="text-decoration-none"> <i
                                    class="fa-solid fa-circle-chevron-right"></i> Conferência de
                                estoque</a></li>
                        <li><a style="border-radius: 25px" href="#" class="text-decoration-none"> <i
                                    class="fa-solid fa-circle-chevron-right"></i> Relatórios</a>
                        </li>
                    </ul>
                </div><!-- dropdown-menu -->
            </li>
            <li class="nav-item with-sub  @if (request()->query('place') == 4) {{ 'active' }} @endif ">
                <a class="nav-link"style="border-radius: 25px" href="#">
                    <i class="icon ion-arrow-graph-up-right"></i>
                    <span>Finanças</span>
                </a>
                <div class="shadow sub-item " style="border-radius: 25px">
                    <ul>

                        <li><a style="border-radius: 25px" href="{{ route('Boletos') }}?place=4"
                                class="text-decoration-none">
                                <i class="fa-solid fa-circle-chevron-right"></i>
                                Boletos</a>
                        </li>
                        <li><a style="border-radius: 25px" href="{{ route('Despesas') }}?place=4"
                                class="text-decoration-none">
                                <i class="fa-solid fa-circle-chevron-right"></i> Despesas
                            </a>
                        </li>
                        <li><a style="border-radius: 25px" href="{{ route('Faturamentos') }}?place=4"
                                class="text-decoration-none"> <i class="fa-solid fa-circle-chevron-right"></i>
                                Faturamento (OS)</a>
                        </li>
                        <li><a style="border-radius: 25px" href="#" class="text-decoration-none"> <i
                                    class="fa-solid fa-circle-chevron-right"></i> Tabela de
                                Preço</a>
                        <li><a style="border-radius: 25px" href="{{ route('Relatorios') }}?place=4"
                                class="text-decoration-none"> <i class="fa-solid fa-circle-chevron-right"></i>
                                Relatório Do
                                Trimestre </a>
                        </li>
                        <li><a style="border-radius: 25px" href="{{ route('Relatorios') }}?place=4"
                                class="text-decoration-none"> <i class="fa-solid fa-circle-chevron-right"></i> DRE</a>
                        </li>
                    </ul>
                </div><!-- dropdown-menu -->
            </li>
            <li class="nav-item with-sub  @if (request()->query('place') == 5) {{ 'active' }} @endif ">
                <a class="nav-link" style="border-radius: 25px"href="#" data-toggle="dropdown ">
                    <i class="icon ion-model-s"></i>
                    <span>Frota</span>
                </a>
                <div class="shadow sub-item" style="border-radius: 25px">
                    <ul>
                        <li><a style="border-radius: 25px" href="{{ route('Abastecimentos') }}?place=5"
                                class="text-decoration-none" data-toggle="tooltip" data-placement="top"
                                title="Cadastra Edita e Exclui"><i class="fa-solid fa-circle-chevron-right"></i>
                                Abastecimentos</a>
                        </li>
                        <li><a style="border-radius: 25px" href="{{ route('Equipamentos') }}?place=5"
                                class="text-decoration-none"><i class="fa-solid fa-circle-chevron-right"></i> Veículos
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            </ul>
        </div><!-- container -->
        </div><!-- slim-navbar -->
        @yield('content')
    @endif
</body>

</html>
