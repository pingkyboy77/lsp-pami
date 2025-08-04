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
                                <img src="{{ asset('image/logo-biru.png') }}" alt="Logo" height="70">
                                <h3 class="text-black mt-3">LOGIN</h3>
                            </div>

                            @if (session('LoginError'))
                                <div class="alert alert-danger">{{ session('LoginError') }}</div>
                            @endif

                            <form action="{{ route('proses.login') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="Enter email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Enter password" id="password-input">
                                        <span class="input-group-text" id="toggle-password" style="cursor: pointer;">
                                            <i class="fa-solid fa-eye" id="eye-icon"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>



                                {{-- reCAPTCHA (jika diaktifkan) --}}
                                {{-- {!! NoCaptcha::display() !!} --}}

                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                    <div></div>
                                    <a href="{{ route('password.request') }}" class="text-muted">Lupa password?</a>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-primary w-100">Login</button>
                                </div>
                                <div class="text-center mt-3">
                                    <p> &copy; 2025 Krisna Yuda Nugraha</p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const passwordInput = document.getElementById('password-input');
            const toggleBtn = document.getElementById('toggle-password');
            const eyeIcon = document.getElementById('eye-icon');

            toggleBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                eyeIcon.classList.toggle('fa-eye');
                eyeIcon.classList.toggle('fa-eye-slash');
            });
        });
    </script>
@endpush
