@extends('dashboard.layouts.master')

@section('title', 'Health Session  Feedback | Jeebika')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('jeebika.health_session_feedback.view',['hsid'=>$data->id]),
                'list'=>route('jeebika.health_session_feedback.view__list',['hsid'=>$data->id]),
                'allParticipant'=>route('jeebika.health_session_feedback.view__all_participant_list',['hsid'=>$data->id]),
                ]
            ) !!}
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
            <li class="breadcrumb-item"><a
                    href="{{ route('jeebika.health_session.view') }}">Health Session</a>
            </li>
            <li class="breadcrumb-item">
                <a
                    href="{{ URL::route('jeebika.health_session.view__details',$data->id) }}">{{ $data->session_heading }}
                </a>
            </li>
            <li class="breadcrumb-item active">Feedback</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.health-session.summary')
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="health-session-feedback">
                    <health-session-feedback></health-session-feedback>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/js/dashboard/jeebika/health-session-feedback.js") }}"></script>
@endpush
