<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - Lokalista</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/@tabler/icons/iconfont/tabler-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #fff8f0;
            font-family: 'Nunito', sans-serif;
        }

        .forgot-wrapper {
            max-width: 500px;
            margin: 60px auto;
            background-color: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            padding: 40px 30px;
        }

        .forgot-title {
            font-size: 26px;
            font-weight: 700;
            color: #ff7700;
            margin-bottom: 25px;
        }

        label {
            font-weight: 600;
            color: #333;
        }

        .form-control:focus {
            border-color: #ff7700;
            box-shadow: 0 0 0 0.2rem rgba(255, 119, 0, 0.25);
        }

        .btn-orange {
            background-color: #ff7700;
            color: #fff;
            font-weight: 600;
            transition: 0.3s ease-in-out;
            border: none;
        }

        .btn-orange:hover {
            background-color: #e56200;
        }

        .alert-success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            font-weight: 500;
        }

        .text-center i {
            color: #ff7700;
            font-size: 45px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="forgot-wrapper">
        <div class="text-center">
            <i class="ti ti-key"></i>
        </div>
        <h4 class="forgot-title text-center">Lupa Password</h4>

        @if (session('status'))
            <div class="alert alert-success text-center">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3">
                <label for="email">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-orange btn-block">Kirim Link Reset</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
