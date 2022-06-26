@extends('dashboard.layouts.master')

@section('title', 'Families | Jeebika')
@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('jeebika.family.view'),
                'list' => route('jeebika.family.view__list')
                ]
            ) !!}
        };
    </script>
@endpush

@section("content")
    <main class="main">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Jeebika</li>
            <li class="breadcrumb-item active">Families</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="family-admin-view-app">
                    <family-admin-view-app></family-admin-view-app>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/js/dashboard/jeebika/family/family-admin-view.js") }}"></script>
@endpush
