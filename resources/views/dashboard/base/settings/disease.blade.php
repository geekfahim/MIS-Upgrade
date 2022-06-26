@extends('dashboard.layouts.master')

@section('title', 'Disease')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('settings.disease.view'),
                'list' => route('settings.disease.view__list')
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
            <li class="breadcrumb-item active">Disease</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="disease-app">
                    <disease></disease>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
<script src="{{ asset("assets/js/dashboard/base/settings/disease.js") }}"></script>
@endpush
