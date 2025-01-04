<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Login | {{ config('app.name') }}">

    <title>Login &mdash; {{ config('app.name') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('admin/assets/img/logo/koslog2.png') }}" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/vendor/bootstrap-4.6.2/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendor/fontawesome-free-5.15.4-web/css/all.min.css') }}">

    <!-- CSS Libraries -->
    {{-- <link rel="stylesheet" href="../node_modules/bootstrap-social/bootstrap-social.css"> --}}

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/style.css" loading="lazy">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/components.css" loading="lazy">
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="d-flex flex-wrap align-items-stretch">
                <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
                    <div class="p-4 m-3">
                        <img src="{{ asset('admin/assets/img/logo/koslog.jpg') }}" alt="logo" width="80"
                            class="shadow-light rounded-circle mb-4 mt-2">
                        <h4 class="text-dark font-weight-normal">Welcome to <span class="font-weight-bold">Kos Rosanty</span>
                        </h4>
                        <p class="text-muted" style="line-height: 20px;">Nikmati fasilitas premium dengan biaya sewa yang ramah di kantong. Pilihan tepat untuk para mahasiswa dan pekerja muda.</p>

                        <form action="{{ route('proses.login') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control
                                @error('email') is-invalid @enderror"
                                name="email" tabindex="1" value="{{ old('email') }}">
                                <div class="invalid-feedback">
                                    @error('email') {{ $message }} @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="d-block">
                                    <label for="password" class="control-label">Password</label>
                                </div>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                                    tabindex="2">
                                <div class="invalid-feedback">
                                    @error('password') {{ $message }} @enderror
                                </div>
                            </div>

                            {{-- <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="remember" class="custom-control-input" tabindex="3"
                                        id="remember-me">
                                    <label class="custom-control-label" for="remember-me">Remember Me</label>
                                </div>
                            </div> --}}

                            <div class="form-group text-right">
                                {{-- <a href="auth-forgot-password.html" class="float-left mt-3">
                                    Lupa Password?
                                </a> --}}
                                <button type="submit" class="btn btn-primary btn-lg btn-icon icon-right"
                                    tabindex="4">
                                    Login
                                </button>
                            </div>

                            {{-- <div class="mt-5 text-center">
                                Don't have an account? <a href="auth-register.html">Create new one</a>
                            </div> --}}
                        </form>
                    </div>
                </div>
                <div class="col-lg-8 col-12 order-lg-2 order-1 min-vh-100 background-walk-y position-relative overlay-gradient-bottom"
                    data-background="{{ asset('admin') }}/assets/img/unsplash/bg-login.jpg">
                    <div class="absolute-bottom-left index-2">
                        <div class="text-light p-5 pb-2">
                            <div class="mb-3 pb-3">
                                <h1 class="mb-2 display-4 font-weight-bold">{{ $greeting }}</h1>
                                <h5 class="font-weight-normal text-muted-transparent">Kota Madiun, Jawa Timur, Indonesia</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap-4.6.2/dist/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-nicescroll/jquery.nicescroll.min.js') }}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script> --}}
    {{-- <script src="../assets/js/stisla.js"></script> --}}

    <!-- JS Libraies -->

    <!-- Template JS File -->
    {{-- <script src="../assets/js/scripts.js"></script>
    <script src="../assets/js/custom.js"></script> --}}

    <script src="{{ asset('admin') }}/assets/js/scripts2.js"></script>
</body>

</html>
