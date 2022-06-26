@extends('dashboard.layouts.master')

@section('title', 'Indicator | Jeebika')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('settings.indicator.view'),
                'list' => route('settings.indicator.view__list')
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
            <li class="breadcrumb-item">Indicator</li>
            <li class="breadcrumb-item active">Indicator</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="indicator-app">
                    <indicator-app></indicator-app>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/js/dashboard/jeebika/settings/indicator.js") }}"></script>
@endpush
