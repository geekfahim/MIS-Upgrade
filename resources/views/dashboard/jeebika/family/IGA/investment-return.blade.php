@extends('dashboard.layouts.master')

@section('title', 'Investment Return | ' . $family->name)
@push('header')
    <link href="{{ asset('assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                one: "{{ route('jeebika.investment_return.view', ['fid' => $family->id]) }}",
                list: "{{ route('jeebika.investment_return.view__list', ['fid' => $family->id]) }}",
            }
        };
    </script>

@endpush

@section('content')
    <main class="main">
        <div class="row no-gutters">
            <div class="col-md-10">
                <!-- Breadcrumb-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Jeebika</li>
                    <li class="breadcrumb-item"><a href="{{ route('jeebika.family.view') }}">Families</a></li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('jeebika.family.view__details', ['id' => $family->id]) }}">{{ $family->name }}</a>
                    </li>
                    <li class="breadcrumb-item active">Investment Return</li>
                </ol>
            </div>
            <div class="col-md-2">
                <ol class="breadcrumb">
                    <!-- Breadcrumb Back Button-->
                    <li class="breadcrumb-menu">
                        <div class="btn-group" role="group" aria-label="Button group">
                            <ul class="nav navbar-nav ml-auto">
                                <a class="btn btn-dark czm-a-button" role="button"
                                   href="{{ route('jeebika.family.view__details', ['id' => $family->id]) }}">
                                    Back</a>
                            </ul>
                        </div>
                    </li>
                </ol>

            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.family.summary')
            </div>
            <div class="card card-accent-info" id="investment-return">
                <investment-return :gro="{{ $family }}"></investment-return>
            </div>
        </div>
    </main>
@endsection


@push('footer')
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard/jeebika/family/IGA/investment-return.js') }}"></script>
@endpush
