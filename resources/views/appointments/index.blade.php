@extends('layouts.app')

@section('title', 'Consultas')

@section('content')
    <div class="container">
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>
                        <i class="bi bi-calendar-check"></i> Consultas
                    </h1>
                    <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nova Consulta
                    </a>
                </div>
            </div>
        </div>

        {{-- Filtros (placeholder para futuro) --}}
        {{-- <div class="row mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <span class="badge bg-primary">Todas</span>
                                <span class="badge bg-outline-secondary">Agendadas</span>
                                <span class="badge bg-outline-success">Concluídas</span>
                                <span class="badge bg-outline-danger">Canceladas</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- Lista de Consultas --}}
        <div class="row">
            <div class="col-12">
                @if ($appointments->count() > 0)
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Data/Hora</th>
                                            <th>Paciente</th>
                                            <th>Responsável</th>
                                            <th>Duração</th>
                                            <th>Status</th>
                                            <th class="text-end">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td>
                                                    <i class="bi bi-calendar3 text-primary"></i>
                                                    <strong>{{ \Carbon\Carbon::parse($appointment->starts_at)->format('d/m/Y') }}</strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($appointment->starts_at)->format('H:i') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <i class="bi bi-person-circle text-muted"></i>
                                                    {{ $appointment->patient->name }}
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $appointment->responsible->name }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $appointment->duration_min }} min
                                                    </small>
                                                </td>
                                                <td>
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
                                                    <span
                                                        class="badge bg-{{ $statusColors[$appointment->status->value] ?? 'secondary' }}">
                                                        {{ $statusLabels[$appointment->status->value] ?? $appointment->status->value }}
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('appointments.show', $appointment) }}"
                                                            class="btn btn-outline-primary" title="Ver Detalhes">
                                                            <i class="bi bi-eye"></i>
                                                        </a>

                                                        @can('update', $appointment)
                                                            <a href="{{ route('appointments.edit', $appointment) }}"
                                                                class="btn btn-outline-secondary" title="Editar">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- Paginação --}}
                    <div class="mt-3">
                        {{ $appointments->links() }}
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-calendar-x" style="font-size: 4rem; color: #ccc;"></i>
                            <h4 class="mt-3">Nenhuma consulta agendada</h4>
                            <p class="text-muted">Comece agendando a primeira consulta da sua clínica.</p>
                            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Agendar Primeira Consulta
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
