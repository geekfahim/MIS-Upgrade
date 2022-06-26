@extends('dashboard.layouts.master')

@section('title', 'Project Reports | Jeebika')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                init: "{!! route('reports.family.init') !!}",
                download: "{!! route('reports.project.create') !!}"
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
            <li class="breadcrumb-item active">Project</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="project-report">
                    <project-report></project-report>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
<script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
<script src="{{ asset("assets/js/dashboard/jeebika/reports/project-report.js") }}"></script>
@endpush
