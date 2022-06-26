@extends('dashboard.layouts.master')

@section('title', 'Mustahiq Reports | Jeebika')
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                init: "{!! route('reports.mustahiq.init') !!}",
                searchGROByProjectId: "{!! route('reports.gro.list') !!}",
                getFamiliesByProjectAndOrGRO: "{!! route('reports.families.search') !!}",
                download: "{!! route('reports.mustahiq.create') !!}"
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
            <li class="breadcrumb-item active">Mustahiq</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="mustahiq-report">
                    <mustahiq-report></mustahiq-report>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/js/dashboard/jeebika/reports/mustahiq-report.js") }}"></script>
@endpush
