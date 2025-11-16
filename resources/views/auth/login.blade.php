@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-hospital text-primary" style="font-size: 3em;"></i>
                        <h3 class="mt-3">SaaS Clínica</h3>
                        <p class="text-muted">Faça login para continuar</p>
                    </div>

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email"
                                class="form-control @error('email')
                                    is-invalid
                                @enderror"
                                id="email" name="email" value="{{ old('email') }}" placeholder="seu@email.com"
                                required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password"
                                class="form-control @error('password')
                                    is-invalid
                                @enderror"
                                id="password" name="password" value="{{ old('password') }}" placeholder="*********"
                                required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Entrar
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    {{-- Link para Criar Conta --}}
                    <div class="text-center mb-3">
                        <p class="mb-0">
                            Não tem uma conta?
                            <a href="{{ route('register') }}" class="text-decoration-none">
                                <i class="bi bi-person-plus"></i> Criar conta
                            </a>
                        </p>
                    </div>

                    <hr class="my-4">

                    <div class="text-center text-muted small">
                        <p class="mb-1"><strong>Credenciais de teste:</strong></p>
                        <p class="mb-0">joao@example.com / password</p>
                        <p class="mb-0">maria@example.com / password</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
