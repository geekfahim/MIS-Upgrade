@extends('dashboard.layouts.master')

@section('title', 'Training  Feedback | Jeebika')

@push('scripts')
    <script>
        window.appHelper = {
            routes: {!! json_encode(
                [
                'one' => route('jeebika.training_feedback.view',['tid'=>$data->id]),
                'list'=>route('jeebika.training_feedback.view__list',['tid'=>$data->id]),
                'allParticipant'=>route('jeebika.training_feedback.view__all_participant_list',['tid'=>$data->id]),

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
                    href="{{ route('jeebika.training.view') }}">Training</a>
            </li>
            <li class="breadcrumb-item">
                <a
                    href="{{ URL::route('jeebika.training_participant_details',$data->id) }}">{{ $data->training_heading }}
                </a>
            </li>
            <li class="breadcrumb-item active">Feedback</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.training.summary')
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="card card-accent-info" id="training-feedback">
                    <training-feedback></training-feedback>
                </div>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/js/dashboard/jeebika/training-feedback.js") }}"></script>
@endpush
