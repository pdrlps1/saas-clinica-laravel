@extends('layouts.app')

@section('title', 'Clínicas')

@section('content')
    <div class="container">
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1>
                        <i class="bi bi-building"></i> Minhas Clínicas
                    </h1>
                    <a href="{{ route('organizations.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nova Clínica
                    </a>
                </div>
            </div>
        </div>

        {{-- Lista de Clínicas --}}
        <div class="row">
            <div class="col-12">
                @if ($organizations->count() > 0)
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nome</th>
                                            <th>Papel</th>
                                            <th>Criada em</th>
                                            <th class="text-end">Ações</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($organizations as $organization)
                                            <tr>
                                                <td>
                                                    <i class="bi bi-bulding text-primary"></i>
                                                    <strong>{{ $organization->name }}</strong>
                                                </td>

                                                <td>
                                                    <span
                                                        class="badge bg-{{ $organization->pivot->role === 'owner' ? 'primary' : 'secondary' }}">
                                                        {{ $organization->pivot->role === 'owner' ? 'Proprietário' : 'Equipe' }}
                                                    </span>
                                                </td>

                                                <td>
                                                    <small class="text-muted">
                                                        {{ $organization->created_at->format('d/m/Y') }}
                                                    </small>
                                                </td>

                                                <td class="text-end">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="{{ route('organizations.show', $organization) }}"
                                                            class="btn btn-outline-primary" title="Ver Detalhes">
                                                            <i class="bi bi-eye"></i>
                                                        </a>

                                                        @if ($organization->pivot->role === 'owner')
                                                            <a href="{{ route('organizations.edit', $organization) }}"
                                                                class="btn btn-outline-primary" title="Editar">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                        @endif
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
                        {{ $organizations->links() }}
                    </div>
                @else
                    {{-- Empty State --}}
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-building" style="font-size: 4rem; color: #ccc;"></i>
                            <h4 class="mt-3">Nenhuma clínica encontrada</h4>
                            <p class="text-muted">Você ainda não participa de nenhuma clínica</p>
                            <a href="{{ route('organizations.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i> Criar Primeira Clínica
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
