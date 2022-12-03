 <!DOCTYPE html>
 <html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <title>{{ pageTitle() }}</title>--}}

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" /> --}}

<!-- CSS Files -->
    <link href="{{ asset('assets/css/defaults.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/material-dashboard-pro.css?v=2.1.1.1') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('assets/demo/demo.css" rel="stylesheet') }}" />
    <link href="{{ asset('assets/css/custom.css') }}?v=22.05.19" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('plugins/tel-input/css/intlTelInput.css') }}">
    @include('layouts.partials.style')
    @stack('css')
    @includeWhen(config('app.g-tag'), 'layouts.partials.g-tag')
</head>

 <body class="" ng-app="myApp" ng-controller="myCtrl" style="background-color: #f9f9f9;" ng-init="authId='{{ auth()->id() }}'">
   @include('layouts.partials.loader')
   <div class="wrapper ">
     <div class="sidebar" data-color="purple" data-background-color="{{ config('md.data-background-color') }}" data-imagex="{{ asset('assets/img/sidebar-1.jpg') }}">
       <div class="logo">
          <a href="{{ url('') }}" class="simple-text logo-mini">@</a>
          <a href="{{ url('') }}" class="simple-text logo-normal">
            {{ config('app.name') }}
          </a>
       </div>
       @include('layouts.partials.sidebar')
         <div class="sidebar-background" style="background-image: url('{{ asset('assets/img/sidebar-1.jpg') }}') "></div>
     </div>
     <div class="main-panel">
        @include('layouts.partials.navbar')
       <div class="content pt-0">
         <div class="container-fluid">
{{--             @include('ang_components.files_modal')--}}
             @yield('content')
         </div>
       </div>
       {{-- @include('layouts.partials.footer') --}}
     </div>
   </div>
   {{-- @include('layouts.partials.fixed-plugin') --}}
   @include('layouts.partials.scriptfiles')
   @include('layouts.partials.scripts')
   @include('layouts.partials.angular-scripts')
{{--   @include('layouts.partials.angular-directive')--}}
   <!-- apiRequestHeaders -->
   @yield('apiRequestHeaders')
   @stack('apiRequestHeaders')
   <!-- JS Stack -->
   @stack('js')
   @stack('modals')
 </body>

 </html>
