@extends('layouts.app')

@section('title', 'Criar conta')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus text-primary" style="font-size: 3em;"></i>
                        <h3 class="mt-3">Criar Conta</h3>
                        <p class="text-muted">Cadastre-se para começar</p>
                    </div>

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        {{-- Nome --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="Seu nome completo" required
                                autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- E-mail --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="seu@email.com" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Senha --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="*********" required>
                            <small class="form-text text-muted">
                                Mínimo 8 caracteres (letras e números)
                            </small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Confirmar Senha --}}
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="*********" required>
                        </div>

                        {{-- Botão Cadastrar --}}
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-person-plus"></i> Criar Conta
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    {{-- Link para Login --}}
                    <div class="text-center">
                        <p class="mb-0">
                            Já tem uma conta?
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                <i class="bi bi-box-arrow-in-right"></i> Fazer login
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
