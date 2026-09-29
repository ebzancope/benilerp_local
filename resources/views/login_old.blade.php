@extends('layouts.layout')
@section('content')
    <form action="{{ route('login.submit') }}" method="POST">
        @csrf
        <div class="signin-wrapper">
            <div class="signin-box" style="border-radius: 5%;padding: 15px; background-color: #f6faf4;">
                <h2 class="signin-title-primary" style="text-align: center "><img src="{{ asset('assets/img/7094814.jpg') }}"
                        width="350" alt="Gestão Benil"><br>&nbsp;
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
                    style=" float: right; color: #ffffff; background-color: #30a300; border-radius: 15px" type="submit">
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
