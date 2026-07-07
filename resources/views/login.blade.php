<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #53523b;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="card login-card">
        <h4 class="fw-bold mb-1 text-center"> TECH INVENTORY SYSTEM</h4>
        <p class="text-muted text-center mb-4 small">Login to continue</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.auth') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-semibold">Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="contoh@email.com"
                    value="{{ old('email') }}"
                    required
                >
            </div>
            <div class="mb-4">
                <label class="form-label small fw-semibold">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="••••••••"
                    required
                >
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <div class="mt-4 p-3 bg-light rounded small text-muted">
            <strong>Demo login:</strong><br>
            Admin: admin@inventaris.com / admin123<br>
            User: user@inventaris.com / user123
        </div>
    </div>
</body>
</html>