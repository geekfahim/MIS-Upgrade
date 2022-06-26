@extends('dashboard.layouts.master')

@section('title', 'View '.$family->name.' | Jeebika')
@section("content")
    <main class="main">
        <div class="row no-gutters">
            <div class="col-md-6">
                <!-- Breadcrumb-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Jeebika</li>
                    <li class="breadcrumb-item"><a href="{{ route('jeebika.family.view') }}">Families</a></li>
                    <li class="breadcrumb-item active">{{ $family->name }}</li>
                </ol>
            </div>
            <div class="col-md-6">
                @include('dashboard.jeebika.family.right-menu')
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.family.summary')
            </div>
        </div>
    </main>
@endsection
