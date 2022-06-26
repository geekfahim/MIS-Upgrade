@extends('dashboard.layouts.master')
@section('title', $bp->business_name.' | Business Plan Approve')
@push('header')
    <link href="{{ asset('assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                one: "{{ route('jeebika.business_plan_approve.view', ['gid' => $bp->j_gro->id]) }}"
            }
        };
    </script>

@endpush
@section("content")
    <main class="main">
        @include('dashboard.jeebika.gro.business-plan.menu')
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.gro.business-plan.summary')
            </div>
        </div>
        <div class="container-fluid">
            <div class="card card-accent-info" id="bp-approve-view-app">
                <bp-approve-view :bp="{{ $bp }}"></bp-approve-view>
            </div>
        </div>
    </main>
@endsection


@push('footer')
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script
        src="{{ asset('assets/js/dashboard/jeebika/gro/business-plan/bp-approve-view.js') }}"></script>
@endpush
