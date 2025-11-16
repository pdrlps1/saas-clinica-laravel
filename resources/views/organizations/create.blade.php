@extends('layouts.app')

@section('title', 'Nova Clínica')

@section('content')
    <div class="container">
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('organizations.index') }}">Clínicas</a>
                        </li>
                        <li class="breadcrumb-item active">Nova Clínica</li>
                    </ol>
                </nav>
                <h1>
                    <i class="bi bi-plus-circle"></i> Nova Clínica
                </h1>
            </div>
        </div>

        {{-- Formulário --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('organizations.store') }}" method="POST">
                            @csrf

                            {{-- Nome da Clínica --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Nome da Clínica <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Ex: Clínica Santa Maria" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Este nome será exibido para todos os membros da clínica.
                                </small>
                            </div>

                            {{-- Botões --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('organizations.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Criar Clínica
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Informações --}}
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i>
                    <strong>Informação:</strong>
                    Ao criar uma clínica, você automaticamente se torna o <strong>proprietário</strong> e poderá
                    adicionar membros à equipe posteriormente.
                </div>
            </div>

            {{-- Sidebar (Ajuda) --}}
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-question-circle"></i> Ajuda
                        </h5>
                        <p class="card-text small">
                            <strong>O que é uma clínica?</strong><br>
                            Uma clínica é um espaço onde você pode gerenciar pacientes e consultas.
                        </p>
                        <p class="card-text small">
                            <strong>Posso criar várias clínicas?</strong><br>
                            Sim! Você pode criar quantas clínicas precisar e participar de várias ao mesmo tempo.
                        </p>
                        <p class="card-text small mb-0">
                            <strong>Como adicionar equipe?</strong><br>
                            Após criar a clínica, acesse os detalhes e adicione membros à equipe.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
