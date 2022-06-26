@extends('dashboard.layouts.master')

@section('title', 'Report All Mustahiqs')

@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                download: "{!! route('allmustahiq.report.view__download') !!}",
                init: "{!! route('allmustahiq.report.init') !!}",
            }
        };
    </script>
@endpush

@section("content")
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">All Mustahiq Reports</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="report-mustahiq-app">
                    <report-mustahiq-app></report-mustahiq-app>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/base/all-mustahiq/report-mustahiq.js") }}"></script>
@endpush
