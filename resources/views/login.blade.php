@extends('layouts.layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <!-- , do formulário -->
        <div class="col-lg-5 col-md-8 mb-4">
            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="card shadow-sm border-0" style="border-radius: 12px; background-color: #f6faf4;">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">
                            <img src="{{ asset('assets/img/Logo_benil_11-2025.png') }}" width="250" alt="Gestão Benil">
                            <br><span class="text-muted" style="font-size: 0.95rem;">
                                <i class="fas fa-chart-bar"></i> Sistema de Gestão Benil Terraplanagem
                            </span>
                        </h2>
                        <div class="form-group mb-3">
                            <input type="text" class="form-control" style="border-radius: 15px" name="adm_login"
                                value="{{ old('adm_login') }}" placeholder="Usuário" required>
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" class="form-control" style="border-radius: 15px" name="adm_senha"
                                placeholder="Senha" required>
                        </div>
                        <button type="submit" class="btn btn-block"
                            style="color: #ffffff; background-color: #30a300; border-radius: 15px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                class="bi bi-save" viewBox="0 0 640 640" style="vertical-align: text-bottom;">
                                <path
                                    d="M409 337C418.4 327.6 418.4 312.4 409 303.1L265 159C258.1 152.1 247.8 150.1 238.8 153.8C229.8 157.5 224 166.3 224 176L224 256L112 256C85.5 256 64 277.5 64 304L64 336C64 362.5 85.5 384 112 384L224 384L224 464C224 473.7 229.8 482.5 238.8 486.2C247.8 489.9 258.1 487.9 265 481L409 337zM416 480C398.3 480 384 494.3 384 512C384 529.7 398.3 544 416 544L480 544C533 544 576 501 576 448L576 192C576 139 533 96 480 96L416 96C398.3 96 384 110.3 384 128C384 145.7 398.3 160 416 160L480 160C497.7 160 512 174.3 512 192L512 448C512 465.7 497.7 480 480 480L416 480z" />
                            </svg>
                            &nbsp; Entrar
                        </button>




                        {{-- Mensagens de erro / sessão --}}
                        @if (session('LoginError'))
                        <div class="alert alert-danger mt-3" style="border-radius: 12px">
                            {{ session('LoginError') }}
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="alert alert-danger mt-3" style="border-radius: 12px">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="mt-3 text-center">
                            <p class="mb-0">Esqueceu a senha? <a href="{{ route('password.request') }}">Clique aqui.</a>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Coluna de espaço para publicidade ou imagem
        <div class="col-lg-5 col-md-8">
            <div class="h-100 d-flex align-items-center justify-content-center p-4"
                style="background: #f8f9fa; border-radius: 12px; min-height: 320px; border: 1px dashed #dcdcdc;">
                <div class="text-muted text-center">
                    <img src="{{ asset('assets/recados/01-03-InterGestor.png') }}" alt="Gestão Benil" width="70%">
                </div>
            </div>
        </div>-->
    </div>
</div>
@endsection
