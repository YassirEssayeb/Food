<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Luxe Dining</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            padding: 2.5rem;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .login-logo {
            color: #D4AF37;
            font-weight: 800;
            font-size: 1.8rem;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        .login-subtitle {
            color: #6c757d;
            text-align: center;
            margin-bottom: 2rem;
        }
        .btn-gold {
            background: #D4AF37;
            color: white;
            font-weight: 700;
        }
        .btn-gold:hover {
            background: #b8960f;
            color: white;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">LUXE ADMIN</div>
        <p class="login-subtitle">Sign in to manage your restaurant</p>

        @if($errors->any())
            <div class="alert alert-danger py-2">
                {{ $errors->first('email') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-gold w-100 py-2">Sign In</button>
        </form>
    </div>
</body>
</html>
