<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Forbidden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #2c2b3d; display: flex; align-items: center; justify-content: center; min-height: 100vh; }
    </style>
</head>
<body>
    <div class="text-center p-5 bg-white rounded-4 shadow" style="max-width: 480px;">
        <h1 class="display-1 fw-bold text-danger">403</h1>
        <h4 class="fw-bold">Access Denied</h4>
        <p class="text-muted">Only administrators can access this section.</p>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary rounded-pill px-4">Back to Dashboard</a>
            @else
                <a href="{{ route('items.user') }}" class="btn btn-primary rounded-pill px-4">Back to Dashboard</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-4">Back to Login</a>
        @endauth
    </div>
</body>
</html>
