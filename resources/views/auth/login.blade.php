<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventory System</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4e73df, #224abe);
            height: 100vh;
        }

        .login-card {
            border: none;
            border-radius: 15px;
        }

        .form-control {
            border-radius: 10px;
        }

        .btn-primary {
            border-radius: 10px;
            background: #4e73df;
            border: none;
        }

        .btn-primary:hover {
            background: #2e59d9;
        }

        .brand-title {
            font-weight: 600;
            color: #4e73df;
        }
    </style>
</head>
<body>

<div class="container d-flex align-items-center justify-content-center" style="height:100vh;">
    <div class="col-md-4">
        <div class="card login-card shadow-lg p-4">

            <div class="text-center mb-4">
                <h3 class="brand-title">Inventory System</h3>
                <p class="text-muted">Silakan login untuk melanjutkan</p>
            </div>

            {{-- Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required autofocus>
                </div>

                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="d-grid">
                    <button class="btn btn-primary">Login</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">© 2026 Inventory App</small>
            </div>

        </div>
    </div>
</div>

</body>
</html>
