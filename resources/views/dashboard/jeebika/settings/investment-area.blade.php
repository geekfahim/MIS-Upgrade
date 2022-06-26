@extends('dashboard.layouts.master')

@section('title', 'Investment Area | Jeebika')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode([
                'one' => route('settings.investment_area.view'),
                'list' => route('settings.investment_area.list'),
            ]) !!}
        };
    </script>
@endpush

@section('content')
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Jeebika</li>
            <li class="breadcrumb-item">Settings</li>
            <li class="breadcrumb-item active">Investment Area</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="investment-area">
                    <investment-area></investment-area>
                </div>
            </div>
        </div>
    </main>
@endsection


@push('footer')
    <script src="{{ asset('assets/js/dashboard/jeebika/settings/investment-area.js') }}"></script>
@endpush
