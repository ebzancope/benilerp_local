<link rel="icon" href="{{ asset('assets/img/Logo_benil_-1024x1024.png') }}" sizes="192x192" />
<link rel="apple-touch-icon" href="{{ asset('assets/img/Logo_benil_-1024x1024.png') }}" />
<meta name="msapplication-TileImage" content="{{ asset('assets/img/Logo_benil_-1024x1024.png') }}" />
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




<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
<link rel="preload" href="{{ asset('assets/fontawesome/css/all.min.css') }}" as="style">
<link href="{{ asset('assets/fontawesome/css/all.min.css') }}" rel="stylesheet">

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
<script language="javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container .select2-selection--single {
        height: 38px !important;
        border-radius: 10px !important;
        border: 1px solid #ced4da !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px !important;
        font-size: 14px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px !important;
    }

    .select2-container--default .select2-selection--single {
        background-color: #fff;
    }

    /* Estilo quando o campo está com valor selecionado */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #000 !important;
    }
</style>
        <!-- No head do layout -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script type="text/javascript">
    function id(el) {
        return document.getElementById(el);

    }

    function getMoney(el) {
        var money = id(el).value.replace(',', '.');
        return parseFloat(money) * 100;
    }


    // Fórmula Secreta

    function somaquina() {
        var totalhora = getMoney('horimfim') - getMoney('horimini');
        var totvarhora = (totalhora).toFixed(1);
        id('tothmaquina').value = totvarhora / 100;
        var quebretotvarhora = totvarhora / 100;
        var campo3 = getMoney('valhora');
        var total = quebretotvarhora * campo3 / 100;
        id('totmaquina').value = (total).toFixed(2);
    }


    function somacam() {
        var qtdas = getMoney('qtda') * getMoney('valora');
        var qtsdfsd = qtdas / 10000;
        id('totala').value = (qtsdfsd).toFixed(2);
    }


    // document.addEventListener('keydown', function(event) {
    // if (event.keyCode === 13) {
    // event.preventDefault(); // Impede o envio DIGITANDO ENTER
    // return false;
    //  }
    // });



</script>
