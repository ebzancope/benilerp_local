@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row g-3 mb-3 section-title fst-italic" style="color: #30a300; ">
                <h2><i class="fas fa-money-bill-alt"></i> Gerenciamento de Orçamentos</h2>
            </div>
            <form action="{{ route('orcamentos.update', $orcamento->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('orcamentos._form')
                <div class="d-flex gap-2">
                    <button class="btn btn-primary rounded-pill" type="submit">Salvar</button>
                    <a href="{{ route('orcamentos.index') }}" class="btn btn-secondary rounded-pill">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection