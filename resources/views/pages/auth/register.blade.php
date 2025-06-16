<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chevalier | Registration </title>

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

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <img src="{{ asset('templates/dist/img/logo-cheva.jpg') }}" alt="Cheva Logo"
                class="brand-image img-circle elevation-3 img-fluid"
                style="max-width: 120px; height: auto; opacity: .8;">
            <a href="/"><b>Inventaris</b>Chevalier</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>

                <form action="/register" method="post">
                    @csrf

                    <!-- Field Name -->
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Field Email -->
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Field Role -->
                    @error('role')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-group mb-3">
                        <select name="role" class="form-control">
                             <option value="Mahasiswa" {{ old('role') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user-tag"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Field NIM/NIP -->
                    @error('nim_nip')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="text" name="nim_nip" class="form-control" placeholder="NIM/NIP" value="{{ old('nim_nip') }}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-id-card"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Field Password -->
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password">
                        <div class="input-group-append show-password">
                            <div class="input-group-text">
                                <span class="fas fa-lock" id="password-lock"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Field Confirm Password -->
                    @error('confirm_password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="password" name="confirm_password" class="form-control" placeholder="Password Confirmation" id="confirm-password">
                        <div class="input-group-append show-confirm-password">
                            <div class="input-group-text">
                                <span class="fas fa-lock" id="confirm-password-lock"></span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="templates/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="templates/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="templates/dist/js/adminlte.min.js"></script>
    <script>
        // Toggle password visibility
        $('.show-password').on('click', function() {
            const passwordField = $("#password");
            const icon = $("#password-lock");
            if (passwordField.attr('type') == 'password') {
                passwordField.attr('type', 'text');
                icon.removeClass('fa-lock').addClass('fa-unlock');
            } else {
                passwordField.attr('type', 'password');
                icon.removeClass('fa-unlock').addClass('fa-lock');
            }
        });

        // Toggle confirm password visibility
        $('.show-confirm-password').on('click', function() {
            const confirmField = $("#confirm-password");
            const icon = $("#confirm-password-lock");
            if (confirmField.attr('type') == 'password') {
                confirmField.attr('type', 'text');
                icon.removeClass('fa-lock').addClass('fa-unlock');
            } else {
                confirmField.attr('type', 'password');
                icon.removeClass('fa-unlock').addClass('fa-lock');
            }
        });

        // Dynamic NIM/NIP label based on role selection
        $('select[name="role"]').on('change', function() {
            const role = $(this).val();
            const nimNipField = $('input[name="nim_nip"]');

            if (role === 'Dosen') {
                nimNipField.attr('placeholder', 'NIP');
            } else if (role === 'Mahasiswa') {
                nimNipField.attr('placeholder', 'NIM');
            } else {
                nimNipField.attr('placeholder', 'NIM/NIP');
            }
        });
    </script>
</body>

</html>
