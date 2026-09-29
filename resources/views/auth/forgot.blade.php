{{-- resources/views/auth/forgot.blade.php --}}
@extends('layouts.layout')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-8 mb-4">
      <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <div class="card shadow-sm border-0" style="border-radius:12px; background:#f6faf4;">
          <div class="card-body p-4">
            <h4 class="text-center mb-4">Recuperar senha</h4>
            <div class="form-group mb-3">
              <input type="email" name="email" class="form-control" style="border-radius:15px"
                     value="{{ old('email') }}" placeholder="Seu e-mail" required>
            </div>
            <button type="submit" class="btn btn-block"
              style="color:#fff; background:#30a300; border-radius:15px">
              Enviar link de redefinição
            </button>

            @if (session('status'))
              <div class="alert alert-success mt-3" style="border-radius:12px">
                {{ session('status') }}
              </div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger mt-3" style="border-radius:12px">
                <ul class="m-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <div class="mt-3 text-center">
              <p class="mb-0"><a href="{{ route('login') }}">Voltar ao login</a></p>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection