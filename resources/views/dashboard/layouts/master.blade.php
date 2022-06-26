<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v2.1.15
* @link https://coreui.io
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->

<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="MIS - Center for Zakat Management (CZM)">
    <meta name="author" content="center for zakat management (czm)">
    <meta name="keyword" content="mis,czm,center for zakat management,zakat,dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', env('APP_NAME') ?? 'MIS' )</title>
    <!-- Icons-->
    <link rel="icon" type="image/svg" href="{{ asset('assets/images/czm/czm-favicon.svg') }}" sizes="any"/>
    <link href="{{ asset('assets/vendors/@coreui/icons/css/coreui-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/pace-progress/css/pace.min.css') }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/toastr/toastr.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/sweetalert2/sweetalert2.min.css") }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <!-- Global site tag (gtag.js) - Google Analytics-->
    {{--    <script async="" src="https://www.googletagmanager.com/gtag/js?id=UA-118965717-3"></script>--}}
    {{--    @include("dashboard.layouts.top-scripts")--}}
    @stack("header")
    @stack("scripts")
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
@include('dashboard.layouts.navbar')
<div class="app-body">
    @include('dashboard.layouts.sidebar')
    @yield('content')
    @include('dashboard.layouts.asidebar')
</div>
<footer class="app-footer">
    <div>
        <a style="color:#2051d9">{{ env('APP_NAME') ?? 'MIS' }} v1.0.0</a>
        <span>&copy; {{ now()->year }} </span>
        <a href="https://czm-bd.org/" target="_blank" style="color: #40AE49">Center For Zakat Management.</a>
    </div>
    <div class="ml-auto">
        <span>Powered by</span>
        <a style="color:#2051d9">ICT Department</a>
    </div>
</footer>
<!-- CoreUI and necessary plugins-->
<script src="{{ asset('assets/vendors/jquery/js/jquery.min.js') }}"></script>
{{--<script src="{{ asset('assets/vendors/popper.js/js/popper.min.js') }}"></script>--}}
{{--<script src="{{ asset('assets/vendors/bootstrap/js/bootstrap.min.js') }}"></script>--}}
<script src="{{ asset('assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendors/pace-progress/js/pace.min.js') }}"></script>
<script src="{{ asset("assets/vendors/moment/moment.min.js") }}"></script>
<script src="{{ asset('assets/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/vendors/@coreui/coreui/js/coreui.min.js') }}"></script>
<script src="{{ asset("assets/vendors/toastr/toastr.min.js") }}"></script>
<script src="{{ asset("assets/vendors/sweetalert2/sweetalert2.min.js") }}"></script>
{{--<script src="{{ asset("assets/vendors/vuejs/vue.min.js") }}"></script>--}}
<script src="{{ asset("assets/vendors/axios/axios.min.js") }}"></script>

{{--@include("dashboard.layouts.bottom-script")--}}
@stack("footer")

{{-- Plugins and scripts required by this view
<script src="{{ asset("assets/vendors/chart.js/dist/Chart.min.js") }}"></script>
<script src="{{ asset("assets/vendors/@coreui/coreui-plugin-chartjs-custom-tooltips/dist/js/custom-tooltips.min.js") }}"></script>
<script src="{{ asset("assets/js/main.js") }}"></script> --}}

</body>
</html>
