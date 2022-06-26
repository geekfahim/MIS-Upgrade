@extends('dashboard.layouts.master')
@section('title', 'Health Session View || '.$data->session_heading.' | Jeebika')

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
                            href="{{ route('jeebika.health_session.view') }}">Heath Session</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a
                            href="{{ URL::route('jeebika.health_session.view__details',$data->id) }}">{{ $data->session_heading }}</a>
                    </li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.health-session.summary')
            </div>
        </div>

    </main>
@endsection


