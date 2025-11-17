@extends('layouts.app')

@section('title', 'Editar Consulta')

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
                        <li class="breadcrumb-item">
                            <a href="{{ route('appointments.show', $appointment) }}">
                                {{ \Carbon\Carbon::parse($appointment->starts_at)->format('d/m/Y H:i') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </nav>
                <h1>
                    <i class="bi bi-pencil"></i> Editar Consulta
                </h1>
            </div>
        </div>

        {{-- Formulário --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Paciente --}}
                            <div class="mb-3">
                                <label for="patient_id" class="form-label">
                                    Paciente <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('patient_id') is-invalid @enderror" id="patient_id"
                                    name="patient_id" required>
                                    <option value="">Selecione um paciente</option>
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ old('patient_id', $appointment->patient_id) == $patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                            {{ old('responsible_user_id', $appointment->responsible_user_id) == $responsible->id ? 'selected' : '' }}>
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
                                        name="starts_at"
                                        value="{{ old('starts_at', \Carbon\Carbon::parse($appointment->starts_at)->format('Y-m-d\TH:i')) }}"
                                        required>
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
                                        id="duration_min" name="duration_min"
                                        value="{{ old('duration_min', $appointment->duration_min) }}" min="15"
                                        step="15" required>
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
                                        {{ old('status', $appointment->status->value) == 'scheduled' ? 'selected' : '' }}>
                                        Agendada
                                    </option>
                                    <option value="done"
                                        {{ old('status', $appointment->status->value) == 'done' ? 'selected' : '' }}>
                                        Concluída
                                    </option>
                                    <option value="canceled"
                                        {{ old('status', $appointment->status->value) == 'canceled' ? 'selected' : '' }}>
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
                                    placeholder="Observações administrativas sobre a consulta...">{{ old('notes', $appointment->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Botões --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-secondary">
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
                            {{ $appointment->created_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="card-text small mb-0">
                            <strong>Última atualização:</strong><br>
                            {{ $appointment->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>

                <div class="card bg-light mt-3">
                    <div class="card-body">
                        <h6 class="card-title">Status Atual</h6>
                        @php
                            $statusColors = [
                                'scheduled' => 'primary',
                                'done' => 'success',
                                'canceled' => 'danger',
                            ];
                            $statusLabels = [
                                'scheduled' => 'Agendada',
                                'done' => 'Concluída',
                                'canceled' => 'Cancelada',
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$appointment->status->value] ?? 'secondary' }}">
                            {{ $statusLabels[$appointment->status->value] ?? $appointment->status->value }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
