@extends('dashboard.layouts.master')

@section('title', 'Income')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('settings.income.view'),
                'list' => route('settings.income.view__list')
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
            <li class="breadcrumb-item active">Income</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="income-app">
                    <income></income>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
<script src="{{ asset("assets/js/dashboard/base/settings/income.js") }}"></script>
@endpush
