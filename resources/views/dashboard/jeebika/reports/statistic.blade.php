@extends('dashboard.layouts.master')
@section('title', 'Statistic Report')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                one: "{!!route('reports.statistic.view')!!}",
                list: "{!! route('reports.statistic.list') !!}",
            }
        }

    </script>
@endpush
@section("content")
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Jeebika</li>
            <li class="breadcrumb-item">Reports</li>
            <li class="breadcrumb-item active">Statistic</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="statistic-report">
                    <statistic-report></statistic-report>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/jeebika/reports/statistic-report.js") }}"></script>
@endpush
