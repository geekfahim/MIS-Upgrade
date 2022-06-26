@extends('dashboard.layouts.master')

@section('title', 'ACL User Role Assign | Base')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('acl.role_assign.view'),
                'list' => route('acl.role_assign.view__list')
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
            <li class="breadcrumb-item active">User Role Assign</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="user-role-assign-app">
                    <user-role-assign></user-role-assign>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/js/dashboard/base/acl/user-role-assign.js") }}"></script>
@endpush
