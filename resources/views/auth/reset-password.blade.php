
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
                                <h4 class="mt-3 fw-bold">Reset Password</h4>
                                <p class="text-muted">Masukkan password baru Anda</p>
                            </div>

                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror" required
                                        placeholder="Masukkan password baru">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" required
                                        placeholder="Ulangi password">
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
@endsection
