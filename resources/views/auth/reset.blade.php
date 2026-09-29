{{-- resources/views/auth/reset.blade.php --}}
@extends('layouts.layout')
@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-8 mb-4">
      <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="card shadow-sm border-0" style="border-radius:12px; background:#f6faf4;">
          <div class="card-body p-4">
            <h4 class="text-center mb-4">Definir nova senha</h4>

            <div class="form-group mb-3">
              <input type="email" name="email" class="form-control" style="border-radius:15px"
                     value="{{ old('email', $email ?? '') }}" placeholder="Seu e-mail" required>
            </div>

            <div class="form-group mb-3">
              <input type="password" name="password" class="form-control" style="border-radius:15px"
                     placeholder="Nova senha" required>
            </div>

            <div class="form-group mb-3">
              <input type="password" name="password_confirmation" class="form-control" style="border-radius:15px"
                     placeholder="Confirmar senha" required>
            </div>

            <button type="submit" class="btn btn-block"
              style="color:#fff; background:#30a300; border-radius:15px">
              Atualizar senha
            </button>

            @if ($errors->any())
              <div class="alert alert-danger mt-3" style="border-radius:12px">
                <ul class="m-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection