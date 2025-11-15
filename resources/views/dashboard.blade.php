@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">
                    <i class="bi bi-house-door"></i> Dashboard
                </h1>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-building"></i> Minhas Clínicas
                        </h5>
                        <h2 class="mb-0">{{ $stats['total_organizations'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="bi bi-star"></i> Clínicas que Possuo
                        </h5>
                        <h2 class="mb-0">{{ $stats['owned_organizations'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Clínicas -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-building"></i> Suas Clínicas
                        </h5>
                        <a href="{{ route('organizations.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Nova Clínica
                        </a>
                    </div>
                    <div class="card-body">
                        @if ($organizations->count() > 0)
                            <div class="list-group">
                                @foreach ($organizations as $organization)
                                    <a href="{{ route('organizations.show', $organization) }}"
                                        class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">
                                                <i class="bi bi-building"></i> {{ $organization->name }}
                                            </h5>
                                            <span
                                                class="badge bg-{{ $organization->pivot->role === 'owner' ? 'primary' : 'secondary' }}">
                                                {{ $organization->pivot->role === 'owner' ? 'Proprietário' : 'Equipe' }}
                                            </span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                Você ainda não participa de nenhuma clínica.
                                <a href="{{ route('organizations.create') }}">Crie uma agora!</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
