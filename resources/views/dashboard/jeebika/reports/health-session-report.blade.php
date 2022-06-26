@extends('dashboard.layouts.master')

@section('title', 'Health Session Reports | Jeebika')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                init: "{!! route('reports.family.init') !!}",
                searchGROByProjectId: "{!! route('reports.gro.list') !!}",
                searchHealthSessionByProjectId: "{!! route('reports.health_session.list') !!}",
                searchFamilies: "{!! route('reports.families.search') !!}",
                download: "{!! route('reports.health_session.create') !!}"
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
            <li class="breadcrumb-item active">Health Session</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="health-session-report">
                    <health-session-report></health-session-report>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/jeebika/reports/health-session-report.js") }}"></script>
@endpush
