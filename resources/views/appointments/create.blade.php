@extends('layouts.app')

@section('title', 'Nova Consulta')

@section('content')
    <div class="container">
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('appointments.index') }}">Consultas</a>
                        </li>
                        <li class="breadcrumb-item active">Nova Consulta</li>
                    </ol>
                </nav>
                <h1>
                    <i class="bi bi-plus-circle"></i> Nova Consulta
                </h1>
            </div>
        </div>

        {{-- Formulário --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('appointments.store') }}" method="POST">
                            @csrf

                            {{-- Paciente --}}
                            <div class="mb-3">
                                <label for="patient_id" class="form-label">
                                    Paciente <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id"
                                    name="patient_id" required autofocus>
                                    <option value="">Selecione um paciente</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Não encontrou o paciente?
                                    <a href="{{ route('patients.create') }}" target="_blank">Cadastrar novo paciente</a>
                                </small>
                            </div>

                            {{-- Responsável --}}
                            <div class="mb-3">
                                <label for="responsible_user_id" class="form-label">
                                    Responsável <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('responsible_user_id') is-invalid @enderror"
                                    id="responsible_user_id" name="responsible_user_id" required>
                                    <option value="">Selecione o responsável</option>
                                    @foreach ($responsibles as $responsible)
                                        <option value="{{ $responsible->id }}"
                                            {{ old('responsible_user_id') == $responsible->id ? 'selected' : '' }}>
                                            {{ $responsible->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('responsible_user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                {{-- Data e Hora --}}
                                <div class="col-md-8 mb-3">
                                    <label for="starts_at" class="form-label">
                                        Data e Hora <span class="text-danger">*</span>
                                    </label>
                                    <input type="datetime-local"
                                        class="form-control @error('starts_at') is-invalid @enderror" id="starts_at"
                                        name="starts_at" value="{{ old('starts_at') }}" required>
                                    @error('starts_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Duração --}}
                                <div class="col-md-4 mb-3">
                                    <label for="duration_min" class="form-label">
                                        Duração (min) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control @error('duration_min') is-invalid @enderror"
                                        id="duration_min" name="duration_min" value="{{ old('duration_min', 60) }}"
                                        min="15" step="15" required>
                                    @error('duration_min')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="scheduled"
                                        {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>
                                        Agendada
                                    </option>
                                    <option value="done" {{ old('status') == 'done' ? 'selected' : '' }}>
                                        Concluída
                                    </option>
                                    <option value="canceled" {{ old('status') == 'canceled' ? 'selected' : '' }}>
                                        Cancelada
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Observações --}}
                            <div class="mb-3">
                                <label for="notes" class="form-label">
                                    Observações
                                </label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="4"
                                    placeholder="Observações administrativas sobre a consulta...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Campo opcional. Apenas para uso administrativo interno.
                                </small>
                            </div>

                            {{-- Botões --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Agendar Consulta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Informações --}}
                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i>
                    <strong>Dica:</strong>
                    A duração padrão é de 60 minutos, mas você pode ajustar conforme necessário.
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
                            <strong>Paciente:</strong> Obrigatório<br>
                            Selecione o paciente que será atendido.
                        </p>
                        <p class="card-text small">
                            <strong>Responsável:</strong> Obrigatório<br>
                            Membro da equipe responsável pela consulta.
                        </p>
                        <p class="card-text small">
                            <strong>Data/Hora:</strong> Obrigatório<br>
                            Quando a consulta será realizada.
                        </p>
                        <p class="card-text small">
                            <strong>Duração:</strong> Em minutos<br>
                            Tempo estimado da consulta (padrão: 60min).
                        </p>
                        <p class="card-text small mb-0">
                            <strong>Status:</strong><br>
                            • Agendada: consulta futura<br>
                            • Concluída: já realizada<br>
                            • Cancelada: não realizada
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
