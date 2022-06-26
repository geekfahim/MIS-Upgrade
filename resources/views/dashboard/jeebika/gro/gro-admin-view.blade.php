@extends('dashboard.layouts.master')

@section('title', 'GRO | Jeebika')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                one: "{!! route('jeebika.gro.view') !!}",
                list: "{!! route('jeebika.gro.view__list') !!}",
                projectSearch: "{!! route('search.project.view',['project_type'=>$programName]) !!}",
                mustahiqSearch: "{!! route('search.mustahiq.view',['project_type'=>$programName]) !!}",
                bankSearch: "{!! route('search.bank.view') !!}",
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
            <li class="breadcrumb-item">Jeebika</li>
            <li class="breadcrumb-item active">GRO's</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="gro-admin-view-app">
                    <gro-admin-view-app></gro-admin-view-app>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/jeebika/gro/gro-admin-view.js") }}"></script>
@endpush