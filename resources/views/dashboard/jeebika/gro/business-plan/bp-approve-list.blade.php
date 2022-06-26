@extends('dashboard.layouts.master')

@section('title', 'Business Plan Approve | ' . $gro->name)
@push('header')
    <link href="{{ asset('assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        window.appHelper = { 
            routes: {
                one: "{{ route('jeebika.business_plan_approve.view', ['gid' => $gro->id]) }}",
                list: "{{ route('jeebika.business_plan_approve.view__list',['gid' => $gro->id]) }}",
            }
        };
    </script>
@endpush

@section('content')
    <main class="main">
        <div class="row no-gutters">
            <div class="col-md-10">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Jeebika</li>
                    <li class="breadcrumb-item"><a href="{{ route('jeebika.gro.view') }}">GROs</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('jeebika.gro.view__details',['id'=>$gro->id]) }}">{{ $gro->name }}</a>
                    </li>
                    <li class="breadcrumb-item active">Business Plan Approve</li>
                </ol>
            </div>
            <div class="col-md-2">
                <ol class="breadcrumb">
                    <!-- Breadcrumb Back Button-->
                    <li class="breadcrumb-menu">
                        <div class="btn-group" role="group" aria-label="Button group">
                            <ul class="nav navbar-nav ml-auto">
                                <a class="btn btn-dark czm-a-button px-3" role="button"
                                   href="{{ route('jeebika.gro.view__details',['id'=>$gro->id]) }}">
                                    Back</a>
                            </ul>
                        </div>
                    </li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.gro.summary')
            </div>
            <div class="card card-accent-info" id="bp-approve-list-app">
                <bp-approve-list></bp-approve-list>
            </div>
        </div>
    </main>
@endsection


@push('footer')
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/jeebika/gro/business-plan/bp-approve-list.js') }}"></script>
@endpush
