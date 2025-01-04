<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('title') | {{ config('app.name') }}">

    <title>@yield('title') &mdash; {{ config('app.name') }}</title>

    <link rel="icon" type="image/png" href="{{ asset('admin/assets/img/logo/koslog2.png') }}" />

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/vendor/bootstrap-4.6.2/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendor/fontawesome-free-5.15.4-web/css/all.min.css') }}">

    <!-- CSS Libraries -->
    @stack('css_vendor')

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('preloader/preloader.css') }}" loading="lazy">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/style-custom.css" loading="lazy">
    <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/style.css" loading="lazy">
    {{-- <link rel="stylesheet" href="{{ asset('admin') }}/assets/css/components.css" loading="lazy"> --}}

    @stack('css')
</head>

<body>
    @include('preloader.index')
    <div class="main-wrapper">
        @include('admin-panel.layouts.navbar')
        @include('admin-panel.layouts.sidebar')

        <div class="main-content">
            @yield('content')
        </div>

        @include('admin-panel.layouts.footer')
    </div>

    @yield('modal')
    {{-- Modal Logout --}}
    <div class="modal fade" id="modalLogout">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Anda yakin ingin keluar?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-1">Pilih "Logout" jika anda ingin keluar</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="{{ route('logout') }}" class="btn btn-danger"><i class="fas fa-power-off mr-2"></i>Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap-4.6.2/dist/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('admin/vendor/jquery-nicescroll/jquery.nicescroll.min.js') }}"></script>

    <!-- JS Libraies -->
    @stack('js_vendor')

    <!-- Template JS File -->
    {{-- <script src="{{ asset('preloader/preloader.js') }}"></script> --}}
    <script src="{{ asset('admin') }}/assets/js/scripts-custom.js"></script>

    <!-- Page Specific JS File -->
    @stack('js')

    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $('.preloader').fadeOut(500, function() {
                    $(this).hide();
                });
            }, 500);

            var $navbar = $('#navbar');
            var $navLink1 = $('#navLink1');
            var $navLink2 = $('#navLink2');

            $(window).on('scroll', function() {
                var scrollTop = $(this).scrollTop();

                if (scrollTop > 0) {
                    $navbar.addClass('glossy');
                    $navLink1.addClass('text-dark');
                    $navLink2.addClass('text-dark');
                } else {
                    $navbar.removeClass('glossy');
                    $navLink1.removeClass('text-dark');
                    $navLink2.removeClass('text-dark');
                }
            });
        });
    </script>
</body>
</html>
