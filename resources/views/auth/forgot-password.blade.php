@extends('layouts.auth')

@section('content')
    <div class="auth-wrapper d-flex align-items-center justify-content-center">
        <div class="container-fluid">
            <div class="row min-vh-100">
                <!-- Left Side: Background -->
                <div class="col-lg-7 d-none d-lg-block p-0">
                    <div class="h-100 w-100 bg-login"></div>
                </div>

                <!-- Right Side: Login Form -->
                <div class="col-lg-5 d-flex align-items-center justify-content-center bg-white">
                    <div class=" w-100 mx-4 my-5 ">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <img src="{{ asset('image/logo-biru.png') }}" alt="Logo" height="60">
                                <h4 class="mt-3 fw-bold">Lupa Password</h4>
                                <p class="text-muted">Masukkan email Anda untuk reset password</p>
                            </div>

                            @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Alamat Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" required autofocus placeholder="Enter email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Kirim Link Reset</button>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('login') }}" class="text-muted">← Kembali ke Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
@endsection
