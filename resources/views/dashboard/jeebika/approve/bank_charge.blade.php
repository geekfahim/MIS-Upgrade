@extends('dashboard.layouts.master')

@section('title', 'Bank Charge | Approve')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                one: "{!! route('jeebika.bank_charge_approve.view', ['pid' => $project->id]) !!}",
                list: "{!! route('jeebika.bank_charge_approve.view__list', ['pid' => $project->id]) !!}"
            }
        };
    </script>
@endpush

@section("content")
    <main class="main">
        <div class="row no-gutters">
            <div class="col-md-10">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Jeebika</li>
                    <li class="breadcrumb-item"><a href="{{ route('jeebika.project.view') }}">Projects</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('jeebika.project.view__details',['id'=>$project->id]) }}">{{ $project->name }}</a>
                    </li>
                    <li class="breadcrumb-item active">Bank Charge Approve</li>
                </ol>
            </div>
            <div class="col-md-2">
                <ol class="breadcrumb">
                    <!-- Breadcrumb Back Button-->
                    <li class="breadcrumb-menu">
                        <div class="btn-group" role="group" aria-label="Button group">
                            <ul class="nav navbar-nav ml-auto">
                                <a class="btn btn-dark czm-a-button px-3" role="button"
                                   href="{{ route('jeebika.project.view__details',['id'=>$project->id]) }}">
                                    Back</a>
                            </ul>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.project.summary')
            </div>
            <div class="card card-accent-info" id="bank-charge-approve-app">
                <bank-charge-approve-app></bank-charge-approve-app>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/jeebika/approve/bank-charge-approve.js") }}"></script>
@endpush
