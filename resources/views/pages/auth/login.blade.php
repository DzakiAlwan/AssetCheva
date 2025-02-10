<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chevalier | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="templates/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="templates/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="templates/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('templates/dist/img/logo-cheva.jpg') }}" alt="Cheva Logo"
                class="brand-image img-circle elevation-3 img-fluid"
                style="max-width: 120px; height: auto; opacity: .8;">
            <a href="/login"><b>Inventaris</b>Chevalier</a>
        </div>
        <!-- /.login-logo -->
        @if (session('error-unauthorized'))
            <div class="alert alert-danger">{{ session('error-unauthorized') }}</div>
        @endif
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Masuk untuk memulai aplikasi</p>

                <form action="/login" method="post">
                    @csrf
                    @method('POST')
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password"
                            id="password">
                        <div class="input-group-append show-password">
                            <div class="input-group-text">
                                <span class="fas fa-lock" id="password-lock"></span>
                            </div>
                        </div>
                    </div>
                     @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </form>
                <p class="mb-0 mt-3">
                    <a href="/register" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="templates/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="templates/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="templates/dist/js/adminlte.min.js"></script>
    <script>
        $('.show-password').on('click', function() {
            if ($("#password").attr('type') == 'password') {
                $("#password").attr('type', 'text');
                $("#password-lock").attr('class', 'fas fa-unlock');
            } else {
                $("#password").attr('type', 'password');
                $("#password-lock").attr('class', 'fas fa-lock');
            }
        });
    </script>
</body>

</html>
