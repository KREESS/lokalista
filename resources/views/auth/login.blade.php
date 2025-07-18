<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Lokalista</title>
    <link rel="shortcut icon" href="/lokalista/LOGOoren.png">

    <!-- App css -->
    <link href="/metrica/dist/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/metrica/dist/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/metrica/dist/assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>

<body id="body" class="auth-page card-bg">
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-12">
                <div class="card-body p-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-5 col-xl-3 col-lg-4">
                            <div class="card mb-0 border-0">
                                <div class="card-body p-0">
                                    <div class="text-center p-3">
                                        <a href="index.html" class="logo logo-admin">
                                            <img src="/lokalista/LOGOoren.png" height="80" alt="logo"
                                                class="auth-logo">
                                        </a>
                                        <h4 class="mt-3 mb-1 fw-semibold font-18">Selamat Datang Di LOKALISTA</h4>
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    @if (session('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf

                                        <div class="form-group mb-2">
                                            <label for="email" class="form-label">Email Akun</label>
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="admin@admin.com" placeholder="Tulis Email" required
                                                autocomplete="email" autofocus>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group mb-2">
                                            <label class="form-label" for="password">Password</label>
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" placeholder="Tulis Password" value="admin" required
                                                autocomplete="current-password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <div class="text-end mt-1">
                                                <a href="{{ route('password.request') }}" class="text-muted small">Lupa Password?</a>
                                            </div>
                                        </div>

                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid mt-3">
                                                    <button class="btn"
                                                        style="background-color: #ff7700; color: white; border: none;"
                                                        type="submit">
                                                        Log In <i class="fas fa-sign-in-alt ms-1"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="m-3 text-center text-muted">
                                        <p class="mb-0">Belum Memiliki Akun ?
                                            <a href="{{ route('register') }}" class="text-primary ms-2">Daftar Gratis</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7 col-xl-9 col-lg-8 p-0 vh-100 d-flex justify-content-center auth-bg">
                            <div class="accountbg d-flex align-items-center">
                                <div class="account-title text-center text-white">
                                    <h1 class="text-white">Pesona Produk UMKM</h1>
                                    <p class="font-18 mt-3">Ragam Karya Penuh Cinta,
                                        Dari Tangan Lokal untuk Segala Kebutuhanmu</p>
                                    <div class="border w-25 mx-auto border-warning"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script>
        window.setTimeout(function () {
            $(".alert").fadeTo(500, 0).slideUp(500, function () {
                $(this).remove();
            });
        }, 2500);
    </script>

    <script src="/metrica/dist/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/metrica/dist/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/metrica/dist/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/metrica/dist/assets/js/app.js"></script>
</body>

</html>
