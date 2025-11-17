@extends('layouts.app')

@section('title', $patient->name)

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
                        <li class="breadcrumb-item active">{{ $patient->name }}</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h1>
                        <i class="bi bi-person-circle"></i> {{ $patient->name }}
                    </h1>
                    <div class="btn-group">
                        @can('update', $patient)
                            <a href="{{ route('patients.edit', $patient) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        @endcan

                        @can('delete', $patient)
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
            {{-- Informações do Paciente --}}
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle"></i> Informações Pessoais
                        </h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Nome:</dt>
                            <dd class="col-sm-7">{{ $patient->name }}</dd>

                            <dt class="col-sm-5">Email:</dt>
                            <dd class="col-sm-7">{{ $patient->email ?? '—' }}</dd>

                            <dt class="col-sm-5">Telefone:</dt>
                            <dd class="col-sm-7">{{ $patient->phone ?? '—' }}</dd>

                            <dt class="col-sm-5">Data Nasc.:</dt>
                            <dd class="col-sm-7">
                                @if ($patient->birthdate)
                                    {{ \Carbon\Carbon::parse($patient->birthdate)->format('d/m/Y') }}
                                    <br>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($patient->birthdate)->age }} anos
                                    </small>
                                @else
                                    —
                                @endif
                            </dd>

                            <dt class="col-sm-5">Cadastrado:</dt>
                            <dd class="col-sm-7 mb-0">{{ $patient->created_at->format('d/m/Y') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Histórico de Consultas --}}
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-check"></i> Histórico de Consultas
                        </h5>
                        <a href="{{ route('appointments.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle"></i> Nova Consulta
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($patient->appointments && $patient->appointments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Data/Hora</th>
                                            <th>Responsável</th>
                                            <th>Status</th>
                                            <th class="text-end">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patient->appointments as $appointment)
                                            <tr>
                                                <td>
                                                    <i class="bi bi-calendar3 text-primary"></i>
                                                    {{ \Carbon\Carbon::parse($appointment->starts_at)->format('d/m/Y H:i') }}
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $appointment->responsible->name }}
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
                                                    <a href="{{ route('appointments.show', $appointment) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-calendar-x" style="font-size: 3rem; color: #ccc;"></i>
                                <p class="text-muted mt-2 mb-0">Nenhuma consulta agendada ainda.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Confirmação de Exclusão --}}
    @can('delete', $patient)
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
                        <p>Tem certeza que deseja deletar o paciente <strong>{{ $patient->name }}</strong>?</p>
                        @if ($patient->appointments && $patient->appointments->count() > 0)
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>Atenção:</strong> Este paciente possui consultas agendadas.
                                Não será possível deletar enquanto houver consultas vinculadas.
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle"></i>
                                <strong>Atenção:</strong> Esta ação é irreversível.
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        @if (!$patient->appointments || $patient->appointments->count() === 0)
                            <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="bi bi-trash"></i> Sim, Deletar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection
