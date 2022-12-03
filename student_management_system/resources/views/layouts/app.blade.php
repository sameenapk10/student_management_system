<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name') }}</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no"
        name="viewport">
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/material-dashboard-pro.css?v=2.1.1') }}" rel="stylesheet" />
    @stack('css')
</head>

<body class="off-canvas-sidebar" data-gr-c-s-loaded="true" cz-shortcut-listen="true">
    <!-- Extra details for Live View on GitHub Pages -->
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top text-white">
        <div class="container">
            <div class="navbar-wrapper">
                <a class="navbar-brand" href="{{ url('') }}">{{ config('app.name') }}</a>
            </div>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                  {{-- <li class="nav-item">
                    <a href="../dashboard.html" class="nav-link">
                      <i class="material-icons">dashboard</i> Dashboard
                    </a>
                  </li> --}}
                  @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link">
                        <i class="material-icons">fingerprint</i>{{ __('Login') }}
                        <div class="ripple-container"></div></a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item ">
                            <a href="{{ route('register') }}" class="nav-link">
                                <i class="material-icons">person_add</i>{{ __('Register') }}
                            </a>
                        </li>
                    @endif
                  @else
                  @endguest
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Navbar -->
    <div class="wrapper wrapper-full-page">
        <div class="page-header login-page header-filter" filter-color="black"
            style="background-image: url('../../assets/img/login.jpg'); background-size: cover; background-position: top center;">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->

            @yield('content')
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap-material-design.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/material-dashboard-pro.min.js?v=2.1.1') }}" type="text/javascript"></script>
    @stack('script')
</body>
</html>
