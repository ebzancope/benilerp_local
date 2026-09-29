{{-- resources/views/importacao/abastecimento.blade.php --}}
@extends('layouts.layout')

@section('title', 'Importar Abastecimentos')

@section('content')
    <div class="card">

        <div class="card-body">

            <form action="{{ route('importacao.processar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="arquivo" class="form-label">Selecione o arquivo</label>
                    <input type="file" class="form-control @error('arquivo') is-invalid @enderror" id="arquivo"
                        name="arquivo" accept=".xlsx,.xls,.csv,.txt" required>
                    @error('arquivo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload"></i>
                    </button>
                    <a href="{{ route('abastecimentos.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </a>
                </div>
            </form>

            @if (session('success'))
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mt-3">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if (session('erros') && count(session('erros')) > 0)
                <div class="alert alert-warning mt-3">
                    <h6><i class="fas fa-exclamation-triangle"></i> Erros encontrados durante a importação:</h6>
                    <ul class="mb-0 small">
                        @foreach (session('erros') as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>


@endsection
