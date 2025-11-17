@extends('layouts.app')

@section('title', 'Consulta - ' . $appointment->patient->name)

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
                        <li class="breadcrumb-item active">
                            {{ \Carbon\Carbon::parse($appointment->starts_at)->format('d/m/Y H:i') }}
                        </li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h1>
                        <i class="bi bi-calendar-check"></i> Detalhes da Consulta
                    </h1>
                    <div class="btn-group">
                        @can('update', $appointment)
                            <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        @endcan

                        @can('delete', $appointment)
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="bi bi-trash"></i> Deletar
                            </button>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- Status da Consulta --}}
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
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
                                    $statusIcons = [
                                        'scheduled' => 'calendar-check',
                                        'done' => 'check-circle',
                                        'canceled' => 'x-circle',
                                    ];
                                @endphp
                                <h3 class="mb-0">
                                    <i
                                        class="bi bi-{{ $statusIcons[$appointment->status->value] ?? 'calendar' }} text-{{ $statusColors[$appointment->status->value] ?? 'secondary' }}"></i>
                                    <span class="badge bg-{{ $statusColors[$appointment->status->value] ?? 'secondary' }}">
                                        {{ $statusLabels[$appointment->status->value] ?? $appointment->status->value }}
                                    </span>
                                </h3>
                            </div>

                            @if ($appointment->status->value === 'scheduled')
                                <div class="btn-group">
                                    @can('complete', $appointment)
                                        <form action="{{ route('appointments.complete', $appointment) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-check-circle"></i> Marcar como Concluída
                                            </button>
                                        </form>
                                    @endcan

                                    @can('cancel', $appointment)
                                        <form action="{{ route('appointments.cancel', $appointment) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-x-circle"></i> Cancelar
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Informações da Consulta --}}
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle"></i> Informações
                        </h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Data:</dt>
                            <dd class="col-sm-7">
                                {{ \Carbon\Carbon::parse($appointment->starts_at)->format('d/m/Y') }}
                            </dd>

                            <dt class="col-sm-5">Horário:</dt>
                            <dd class="col-sm-7">
                                {{ \Carbon\Carbon::parse($appointment->starts_at)->format('H:i') }}
                            </dd>

                            <dt class="col-sm-5">Duração:</dt>
                            <dd class="col-sm-7">{{ $appointment->duration_min }} minutos</dd>

                            <dt class="col-sm-5">Término:</dt>
                            <dd class="col-sm-7">
                                {{ \Carbon\Carbon::parse($appointment->starts_at)->addMinutes($appointment->duration_min)->format('H:i') }}
                            </dd>

                            <dt class="col-sm-5">Agendado em:</dt>
                            <dd class="col-sm-7 mb-0">
                                {{ $appointment->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Pessoas Envolvidas --}}
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-people"></i> Pessoas Envolvidas
                        </h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Paciente:</dt>
                            <dd class="col-sm-7">
                                <a href="{{ route('patients.show', $appointment->patient) }}" class="text-decoration-none">
                                    <i class="bi bi-person-circle text-primary"></i>
                                    {{ $appointment->patient->name }}
                                </a>
                            </dd>

                            <dt class="col-sm-5">Responsável:</dt>
                            <dd class="col-sm-7">
                                <i class="bi bi-person-badge text-muted"></i>
                                {{ $appointment->responsible->name }}
                            </dd>

                            <dt class="col-sm-5">Clínica:</dt>
                            <dd class="col-sm-7 mb-0">
                                <a href="{{ route('organizations.show', $appointment->organization) }}"
                                    class="text-decoration-none">
                                    <i class="bi bi-building text-muted"></i>
                                    {{ $appointment->organization->name }}
                                </a>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Observações --}}
            @if ($appointment->notes)
                <div class="col-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">
                                <i class="bi bi-journal-text"></i> Observações
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $appointment->notes }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Modal de Confirmação de Exclusão --}}
    @can('delete', $appointment)
        <div class="modal fade" id="deleteModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle text-danger"></i>
                            Confirmar Exclusão
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja deletar esta consulta?</p>
                        <div class="alert alert-info">
                            <strong>Paciente:</strong> {{ $appointment->patient->name }}<br>
                            <strong>Data:</strong> {{ \Carbon\Carbon::parse($appointment->starts_at)->format('d/m/Y H:i') }}
                        </div>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Atenção:</strong> Esta ação é irreversível.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Sim, Deletar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
