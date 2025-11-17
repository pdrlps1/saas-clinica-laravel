@extends('layouts.app')

@section('title', 'Novo Paciente')

@section('content')
    <div class="container">
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patients.index') }}">Pacientes</a>
                        </li>
                        <li class="breadcrumb-item active">Novo Paciente</li>
                    </ol>
                </nav>
                <h1>
                    <i class="bi bi-plus-circle"></i> Novo Paciente
                </h1>
            </div>
        </div>

        {{-- Formulário --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('patients.store') }}" method="POST">
                            @csrf

                            {{-- Nome --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Nome Completo <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Ex: João Silva Santos" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                {{-- Email --}}
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        Email
                                    </label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="paciente@email.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Opcional</small>
                                </div>

                                {{-- Telefone --}}
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">
                                        Telefone
                                    </label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="(11) 98765-4321">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Opcional</small>
                                </div>
                            </div>

                            {{-- Data de Nascimento --}}
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">
                                    Data de Nascimento
                                </label>
                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                    id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Opcional</small>
                            </div>

                            {{-- Botões --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Cadastrar Paciente
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Informações --}}
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i>
                    <strong>Privacidade:</strong>
                    Este é um sistema de demonstração. Não cadastre dados reais ou sensíveis de pacientes.
                    Use apenas dados fictícios para fins educacionais.
                </div>
            </div>

            {{-- Sidebar (Ajuda) --}}
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-question-circle"></i> Campos
                        </h5>
                        <p class="card-text small">
                            <strong>Nome:</strong> Campo obrigatório<br>
                            Cadastre o nome completo do paciente.
                        </p>
                        <p class="card-text small">
                            <strong>Email e Telefone:</strong> Opcionais<br>
                            Úteis para contato e lembretes de consultas.
                        </p>
                        <p class="card-text small mb-0">
                            <strong>Data de Nascimento:</strong> Opcional<br>
                            Útil para calcular idade e histórico médico.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
