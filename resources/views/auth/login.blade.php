<!DOCTYPE html>
<html>

<head>
    <title>Login CRM</title>
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">
    <style>
        body.login-page {
            background: linear-gradient(135deg, #0056b3, #00aaff);
            background-size: cover;
        }
    </style>
</head>
{{-- <body class="hold-transition login-page" > --}}

<body class="hold-transition login-page" style="background: linear-gradient(to right, #007bff, #00c6ff);">
    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <!-- Logo di tengah -->
                <img src="{{ asset('AdminLTE/logo.png') }}" alt="CRM Logo" class="mb-3"
                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.2); display: block; margin-left: auto; margin-right: auto;">

                <p class="login-box-msg">Silakan login</p>

                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="{{ url('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
