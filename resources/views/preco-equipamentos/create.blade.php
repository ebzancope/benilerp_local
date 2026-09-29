@extends('layouts.layout')

@section('content')
<div class="container">
    <h3>Novo Preço</h3>
    <form method="POST" action="{{ route('preco-equipamentos.store') }}">
        @csrf
        @include('preco-equipamentos.partials.form', ['preco' => $preco])
        <button type="submit" class="btn btn-success rounded-pill">Salvar</button>
        <a href="{{ route('preco-equipamentos.index') }}" class="btn btn-secondary rounded-pill">Cancelar</a>
    </form>
</div>
@endsection