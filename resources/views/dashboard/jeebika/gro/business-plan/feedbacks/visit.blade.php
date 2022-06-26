@extends('dashboard.layouts.master')
@section('title', 'Visit | Feedbacks')
@push('header')
    <link href="{{ asset('assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                one: "{{ route('jeebika.feedback_visit.view',['gid' => $bp->j_gro_id,'bpid'=>$bp->id]) }}",
                list: "{{ route('jeebika.feedback_visit.view__list',['gid' => $bp->j_gro_id,'bpid'=>$bp->id]) }}"
            }
        };
    </script>
@endpush
@section("content")
    <main class="main">
        <div class="row no-gutters">
            <div class="col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item">Jeebika</li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('jeebika.gro.view') }}">GROs</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('jeebika.gro.view__details',['id'=>$bp->j_gro->id]) }}">{{ $bp->j_gro->name }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route("jeebika.business_plan_approve.view",['gid'=>$bp->j_gro->id]) }}">Business
                            Plan Approve</a></li>
                    <li class="breadcrumb-item">
                        <a href="{{ route("jeebika.business_plan_approve.view__details",['gid'=>$bp->j_gro->id,'id'=>$bp->id]) }}">{{ $bp->business_name }}</a>
                    </li>
                    <li class="breadcrumb-item active">Visit</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.gro.business-plan.feedbacks.summary')
            </div>
        </div>
        <div class="container-fluid">
            <div class="card card-accent-info" id="visit-feedback">
                <visit-feedback></visit-feedback>
            </div>
        </div>
    </main>
@endsection


@push('footer')
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script
        src="{{ asset('assets/js/dashboard/jeebika/gro/business-plan/feedbacks/visit.js') }}"></script>
@endpush
