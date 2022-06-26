@extends('dashboard.layouts.master')

@section('title', 'ACL User | Base')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('acl.user.view'),
                'list' => route('acl.user.view__list')
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
            <li class="breadcrumb-item">Access Control List</li>
            <li class="breadcrumb-item active">User</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="user-app">
                    <user-app></user-app>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/js/dashboard/base/acl/user.js") }}"></script>
@endpush
