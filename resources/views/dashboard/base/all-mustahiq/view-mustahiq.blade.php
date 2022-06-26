@extends('dashboard.layouts.master')

@section('title', 'View All Mustahiqs')

@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'list' => route('allmustahiq.information.view__list'),
                'download' => route('allmustahiq.information.download'),
                ]
            ) !!}
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
            <li class="breadcrumb-item active">All Mustahiq View</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="view-mustahiq-app">
                    <view-mustahiq-app></view-mustahiq-app>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/base/all-mustahiq/view-mustahiq.js") }}"></script>
@endpush
