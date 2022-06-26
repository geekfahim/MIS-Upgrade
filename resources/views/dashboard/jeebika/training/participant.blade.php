@extends('dashboard.layouts.master')
@section('title', 'Training Participant || '.$data->training_heading.' | Jeebika')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one'=>route('jeebika.training_participant.view',['tid'=>$data->id]),
                'list'=>route('jeebika.training_participant.view__participant_list',['tid'=>$data->id]),
                'allParticipant'=>route('jeebika.training_participant.view__all_participant_list',['tid'=>$data->id]),
                'projectSearch' => route('search.project.view'),
                ]
            ) !!}
        };
    </script>
@endpush

@section("content")
    <main class="main">
        <div class="row no-gutters">
            <div class="col-md-12">
                <!-- Breadcrumb-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Jeebika</li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('jeebika.training.view') }}">Training</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a
                            href="{{ URL::route('jeebika.training_participant_details',$data->id) }}">{{ $data->training_heading }}</a>
                    </li>
                    <li class="breadcrumb-item active">Participant</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.training.summary')
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="training-participant">
                    <training-participant :training="{{ $data }}"></training-participant>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/jeebika/training-participant.js") }}"></script>
@endpush
