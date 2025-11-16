@extends('layouts.app')

@section('title', $organization->name)

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
                        <li class="breadcrumb-item active">{{ $organization->name }}</li>
                    </ol>
                </nav>
                <div class="d-flex justify-content-between align-items-center">
                    <h1>
                        <i class="bi bi-building"></i> {{ $organization->name }}
                    </h1>
                    <div class="btn-group">
                        @can('update', $organization)
                            <a href="{{ route('organizations.edit', $organization) }}" class="btn btn-outline-primary">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        @endcan

                        @can('delete', $organization)
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
            {{-- Informações da Clínica --}}
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-info-circle"></i> Informações
                        </h5>
                    </div>
                    <div class="card-body">
                        <dl class="row mb-0">
                            <dt class="col-sm-5">Criada em:</dt>
                            <dd class="col-sm-7">{{ $organization->created_at->format('d/m/Y') }}</dd>

                            <dt class="col-sm-5">Proprietário:</dt>
                            <dd class="col-sm-7">{{ $organization->owner->name }}</dd>

                            <dt class="col-sm-5">Total de membros:</dt>
                            <dd class="col-sm-7 mb-0">{{ $organization->users->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Membros da Equipe --}}
            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-people"></i> Membros da Equipe
                        </h5>
                        @can('manageMembers', $organization)
                            <button class="btn btn-sm btn-primary" disabled>
                                <i class="bi bi-person-plus"></i> Adicionar Membro
                            </button>
                        @endcan
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Email</th>
                                        <th>Papel</th>
                                        <th class="text-end">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($organization->users as $user)
                                        <tr>
                                            <td>
                                                <i class="bi bi-person-circle text-primary"></i>
                                                <strong>{{ $user->name }}</strong>
                                                @if ($user->id === auth()->id())
                                                    <span class="badge bg-success">Você</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">{{ $user->email }}</small>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $user->pivot->role === 'owner' ? 'primary' : 'secondary' }}">
                                                    {{ $user->pivot->role === 'owner' ? 'Proprietário' : 'Equipe' }}
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                @if ($user->pivot->role !== 'owner' && auth()->user()->can('manageMembers', $organization))
                                                    <button class="btn btn-sm btn-outline-danger" disabled>
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i>
                    <strong>Nota:</strong> A funcionalidade de adicionar/remover membros será implementada em versões
                    futuras.
                </div>
            </div>
        </div>
    </div>

    {{-- Modal de Confirmação de Exclusão --}}
    @can('delete', $organization)
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
                        <p>Tem certeza que deseja deletar a clínica <strong>{{ $organization->name }}</strong>?</p>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Atenção:</strong> Esta ação é irreversível e irá deletar:
                            <ul class="mb-0 mt-2">
                                <li>Todos os pacientes</li>
                                <li>Todas as consultas</li>
                                <li>Todos os membros da equipe</li>
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form action="{{ route('organizations.destroy', $organization) }}" method="POST" class="d-inline">
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
