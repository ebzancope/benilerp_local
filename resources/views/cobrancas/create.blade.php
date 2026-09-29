@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="card mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <h2 class="mb-0" style="color:#30a300;"><i class="fas fa-receipt"></i> Nova Cobrança</h2>
            <a href="{{ route('cobrancas.index') }}" class="btn btn-outline-secondary rounded-pill">Voltar</a>
        </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif

    <form action="{{ route('cobrancas.store') }}" method="POST">
        @csrf
        @include('cobrancas._form', ['cobranca' => $cobranca ?? null, 'clientes' => $clientes])
        <div class="d-flex gap-2 mb-5">
            <button class="btn btn-success rounded-pill" type="submit">Salvar</button>
            <a href="{{ route('cobrancas.index') }}" class="btn btn-secondary rounded-pill">Cancelar</a>
        </div>
    </form>
</div>
@endsection
