@extends('dashboard.layouts.master')
@section('title', 'Training View || '.$data->training_heading.' | Jeebika')

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
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.training.summary')
            </div>
        </div>

    </main>
@endsection


