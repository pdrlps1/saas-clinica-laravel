@extends('layouts.app')

@section('title', 'Pacientes')

@section('content')
    <div class="container">
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>
                        <i class="bi bi-people"></i> Pacientes
                    </h1>
                    <a href="{{ route('patients.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Novo Paciente
                    </a>
                </div>
            </div>
        </div>

        {{-- Lista de Pacientes --}}
        <div class="row">
            <div class="col-12">
                @if ($patients->count() > 0)
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nome</th>
                                            <th>Contato</th>
                                            <th>Data de Nascimento</th>
                                            <th>Cadastrado em</th>
                                            <th class="text-end">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patients as $patient)
                                            <tr>
                                                <td>
                                                    <i class="bi bi-person-circle text-primary"></i>
                                                    <strong>{{ $patient->name }}</strong>
                                                </td>
                                                <td>
                                                    @if ($patient->email)
                                                        <div>
                                                            <i class="bi bi-envelope text-muted"></i>
                                                            <small>{{ $patient->email }}</small>
                                                        </div>
                                                    @endif
                                                    @if ($patient->phone)
                                                        <div>
                                                            <i class="bi bi-telephone text-muted"></i>
                                                            <small>{{ $patient->phone }}</small>
                                                        </div>
                                                    @endif
                                                    @if (!$patient->email && !$patient->phone)
                                                        <small class="text-muted">—</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($patient->birthdate)
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($patient->birthdate)->format('d/m/Y') }}
                                                            <span class="text-muted">
                                                                ({{ \Carbon\Carbon::parse($patient->birthdate)->age }} anos)
                                                            </span>
                                                        </small>
                                                    @else
                                                        <small class="text-muted">—</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $patient->created_at->format('d/m/Y') }}
                                                    </small>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('patients.show', $patient) }}"
                                                            class="btn btn-outline-primary" title="Ver Detalhes">
                                                            <i class="bi bi-eye"></i>
                                                        </a>

                                                        @can('update', $patient)
                                                            <a href="{{ route('patients.edit', $patient) }}"
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
                        {{ $patients->links() }}
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-people" style="font-size: 4rem; color: #ccc;"></i>
                            <h4 class="mt-3">Nenhum paciente cadastrado</h4>
                            <p class="text-muted">Comece cadastrando o primeiro paciente da sua clínica.</p>
                            <a href="{{ route('patients.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Cadastrar Primeiro Paciente
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
