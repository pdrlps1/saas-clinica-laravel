@extends('layouts.app')

@section('title', 'Editar ' . $patient->name)

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
                        <li class="breadcrumb-item">
                            <a href="{{ route('patients.show', $patient) }}">{{ $patient->name }}</a>
                        </li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </nav>
                <h1>
                    <i class="bi bi-pencil"></i> Editar Paciente
                </h1>
            </div>
        </div>

        {{-- Formulário --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('patients.update', $patient) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Nome --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Nome Completo <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $patient->name) }}" required
                                    autofocus>
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
                                        id="email" name="email" value="{{ old('email', $patient->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Telefone --}}
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">
                                        Telefone
                                    </label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $patient->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Data de Nascimento --}}
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">
                                    Data de Nascimento
                                </label>
                                <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                                    id="birthdate" name="birthdate" value="{{ old('birthdate', $patient->birthdate) }}">
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Botões --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('patients.show', $patient) }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Salvar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Sidebar (Informações) --}}
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-info-circle"></i> Informações
                        </h5>
                        <p class="card-text small">
                            <strong>Cadastrado em:</strong><br>
                            {{ $patient->created_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="card-text small mb-0">
                            <strong>Última atualização:</strong><br>
                            {{ $patient->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>

                @if ($patient->appointments && $patient->appointments->count() > 0)
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle"></i>
                        Este paciente possui <strong>{{ $patient->appointments->count() }}</strong>
                        {{ $patient->appointments->count() === 1 ? 'consulta' : 'consultas' }} agendada(s).
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
