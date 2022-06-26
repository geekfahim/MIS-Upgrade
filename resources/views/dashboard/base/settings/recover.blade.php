@extends('dashboard.layouts.master')

@section('title', 'Recover')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('settings.recover.view'),
                'list' => route('settings.recover.view__list')
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
            <li class="breadcrumb-item active">Recover</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="recover-app">
                    <recover></recover>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
<script src="{{ asset("assets/js/dashboard/base/settings/recover.js") }}"></script>
@endpush
