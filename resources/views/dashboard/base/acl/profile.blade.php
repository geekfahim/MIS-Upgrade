@extends('dashboard.layouts.master')

@section('title', $user['name'] . ' Profile | ACL')

@push('header')
    <script>
        window.appHelper = {
            routes: {!! json_encode(['one' => route('acl.profile.view')]) !!}
        };
    </script>
@endpush

@section('content')
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item">{{ $user->name }}</li>
            <li class="breadcrumb-item active">Profile</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card" id="">
                    <div class="card-header">
                        <i class="icon-user"></i> Profile Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <p>Name: {{ $user->name}}</p>
                                <p>Office Id: <span class="badge bg-primary">{{ $user->office_id}}</span></p>
                                <p>Email: {{ $user->email}}</p>
                                <p>Phone:{{ $user->mobile}}</p>
                            </div>
                            <div class="col-md-6 col-lg-6">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="profile-app">
                    <profile :user_profile="{{ $user }}"></profile>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('footer')
    <script src="{{ asset('assets/js/dashboard/base/acl/profile.js') }}"></script>
@endpush
