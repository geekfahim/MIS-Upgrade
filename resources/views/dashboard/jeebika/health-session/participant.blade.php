@extends('dashboard.layouts.master')
@section('title', 'Health Session Participant || '.$data->session_heading.' | Jeebika')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one'=>route('jeebika.health_session_participant.view',['hsid'=>$data->id]),
                'list'=>route('jeebika.health_session_participant.view__participant_list',['hsid'=>$data->id]),
                'allParticipant'=>route('jeebika.health_session_participant.view__all_participant_list',['hsid'=>$data->id]),
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
                            href="{{ route('jeebika.health_session.view') }}">Health Session</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a
                            href="{{ URL::route('jeebika.health_session.view__details',$data->id) }}">{{ $data->session_heading }}</a>
                    </li>
                    <li class="breadcrumb-item active">Participant</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.health-session.summary')
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="health-session-participant">
                    <health-session-participant :healthsession="{{ $data }}"></health-session-participant>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/jeebika/health-session-participant.js") }}"></script>
@endpush
