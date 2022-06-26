@extends('dashboard.layouts.master')

@section('title','Union')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
            [
            'one' => route('settings.union.view'),
            'list' => route('settings.union.view__list'),
            'upazilaSearch' => route('search.upazila.view'),
            ]
        ) !!}
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
            <li class="breadcrumb-item">Setting</li>
            <li class="breadcrumb-item active">Union</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="union-app">
                    <Union></Union>
                </div>
            </div>
        </div>
    </main>

@endsection
@push("footer")
    <script src="{{ asset("assets/js/dashboard/base/settings/union.js") }}"></script>
@endpush
