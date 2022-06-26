@extends('dashboard.layouts.master')

@section('title', 'Disability')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('settings.disability.view'),
                'list' => route('settings.disability.view__list')
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
            <li class="breadcrumb-item active">Disability</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="disability-app">
                    <disability></disability>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
<script src="{{ asset("assets/js/dashboard/base/settings/disability.js") }}"></script>
@endpush
