@extends('dashboard.layouts.master')

@section('title', 'Create Mustahiq Family | Jeebika')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                one: "{!! route('jeebika.mustahiq_family_create.view') !!}",
                init: "{!! route('request.jeebika.init') !!}",
                viewAll: "{!! route('jeebika.mustahiq_view.view__list') !!}",
                upazilaSearch: "{!! route('search.upazila.view') !!}",
                unionSearch: "{!! route('search.union.view') !!}",

            }
        };
    </script>
@endpush

@section("content")
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Jeebika</li>
            <li class="breadcrumb-item active">Create Mustahiq Family</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn" id="mustahiq-family-create-app">
                <mustahiq-family-create></mustahiq-family-create>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/jeebika/mustahiq/family-create/mustahiq-family-create.js") }}"></script>
@endpush
