@extends('dashboard.layouts.master')

@section('title', 'Business Feedback Final | Approve')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                one: "{!! route('jeebika.final_approve.view', ['pid' => $project->id]) !!}",
                list: "{!! route('jeebika.final_approve.view__list', ['pid' => $project->id]) !!}"
            }
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
            <li class="breadcrumb-item">Jeebika</li>
            <li class="breadcrumb-item"><a href="{{ route('jeebika.project.view') }}">Projects</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ route('jeebika.project.view__details',['id'=>$project->id]) }}">{{ $project->name }}</a>
            </li>
            <li class="breadcrumb-item active">Final Approve</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="final-approve-app">
                    <final-approve-app></final-approve-app>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/jeebika/approve/final-approve.js") }}"></script>
@endpush
