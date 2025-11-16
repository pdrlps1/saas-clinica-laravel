@extends('layouts.app')

@section('title', 'Editar ' . $organization->name)

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
                        <li class="breadcrumb-item">
                            <a href="{{ route('organizations.show', $organization) }}">{{ $organization->name }}</a>
                        </li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </nav>
                <h1>
                    <i class="bi bi-pencil"></i> Editar Clínica
                </h1>
            </div>
        </div>

        {{-- Formulário --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('organizations.update', $organization) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Nome da Clínica --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Nome da Clínica <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $organization->name) }}" required
                                    autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Botões --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('organizations.show', $organization) }}" class="btn btn-secondary">
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
                            <strong>Criada em:</strong><br>
                            {{ $organization->created_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="card-text small mb-0">
                            <strong>Última atualização:</strong><br>
                            {{ $organization->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
