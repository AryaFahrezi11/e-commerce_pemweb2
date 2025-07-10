<x-layout>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #4a0000, #8B0000);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        h3, label, .form-check-label {
            color: #ffc107 !important;
        }

        .card {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 18px rgba(0,0,0,0.4);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 193, 7, 0.4);
            color: #fff;
            border-radius: 8px;
            transition: 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #ffc107;
            box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .btn-warning {
            background-color: #ffc107;
            color: #000;
            font-weight: 600;
            border: none;
            transition: 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            color: #000;
        }

        .alert {
            border-radius: 8px;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.2);
            color: #f8d7da;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .alert-success {
            background-color: rgba(25, 135, 84, 0.2);
            color: #d1e7dd;
            border: 1px solid rgba(25, 135, 84, 0.3);
        }

        a {
            color: #ffc107;
        }

        a:hover {
            color: #ffcd39;
            text-decoration: none;
        }
    </style>

    <div class="d-flex justify-content-center align-items-center" style="min-height: 90vh;">
        <div class="card p-4 shadow-sm" style="min-width: 320px; max-width: 400px; width: 90%;">
            <h3 class="mb-4 text-center"><i class="bi bi-person-circle"></i> Login</h3>

            @if(session('errorMessage'))
                <div class="alert alert-danger">
                    {{ session('errorMessage') }}
                </div>
            @endif

            @if(session('successMessage'))
                <div class="alert alert-success">
                    {{ session('successMessage') }}
                </div>
            @endif

            <form method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input 
                        type="email" 
                        class="form-control @error('email') is-invalid @enderror" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="you@example.com"
                        required 
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        id="password" 
                        name="password"
                        placeholder="Your password"
                        required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <button type="submit" class="btn btn-warning w-100">Login</button>
                <div class="mt-3 text-center text-light">
                    <small>
                        Belum punya akun?
                        <a href="{{ route('customer.register') }}">Daftar disini</a>
                    </small>
                </div>
            </form>
        </div>
    </div>
</x-layout>
