@extends('backEnd.admin.auth.master')

@section('title')
    Admin Sign In
@endsection

@section('content')
    <div class="container container-tight py-4">
        <div class="text-center">
            <a href="#" class="navbar-brand navbar-brand-autodark">
                <h1 class="text-primary fw-bold">Admin Panel</h1>
            </a>
        </div>

        <form action="{{ route('admin.login') }}" method="POST" class="card card-md shadow-lg border-0 rounded-4">
            @csrf
            <div class="card-body p-4">

                <h2 class="card-title text-center mb-3 fw-bold">Welcome Back!</h2>
                <p class="text-center text-muted mb-4">Sign in to access your dashboard</p>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group input-group-flat">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-mail">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10" />
                                <path d="M3 7l9 6l9 -6" />
                            </svg>
                        </span>
                        <input type="email" name="email" class="form-control rounded-end"
                            placeholder="admin@example.com" required>
                    </div>
                    @if (session()->has('error'))
                        <small class="text-danger">
                            {{ session()->get('error') }}
                        </small>
                    @endif
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group input-group-flat">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-lock">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6" />
                                <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                            </svg>
                        </span>
                        <input type="password" name="password" class="form-control" id="password"
                            placeholder="Enter password" required>

                        <span class="input-group-text cursor-pointer" onclick="togglePassword()">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path
                                    d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                            </svg>
                        </span>
                    </div>
                </div>

                {{-- Remember + Forgot --}}
                {{-- <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember">
                        <span class="form-check-label">Remember me</span>
                    </label>

                    <a href="#" class="text-decoration-none small">
                        Forgot password?
                    </a>
                </div> --}}

                {{-- Submit --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg rounded-3 shadow-sm">
                        Sign In
                    </button>
                </div>

            </div>
        </form>

        <div class="text-center text-muted mt-3">
            © {{ date('Y') }} Admin Dashboard
        </div>
    </div>

    {{-- Password Toggle Script --}}
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (password.type === "password") {
                password.type = "text";
                icon.classList.remove("ti-eye");
                icon.classList.add("ti-eye-off");
            } else {
                password.type = "password";
                icon.classList.remove("ti-eye-off");
                icon.classList.add("ti-eye");
            }
        }
    </script>
@endsection
