@extends('dashboard.layouts.master')

@section('title', 'Occupation')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('settings.occupation.view'),
                'list' => route('settings.occupation.view__list')
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
            <li class="breadcrumb-item active">Occupation</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="occupation-app">
                    <occupation></occupation>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
<script src="{{ asset("assets/js/dashboard/base/settings/occupation.js") }}"></script>
@endpush
