@extends('dashboard.jeebika.download.layouts.report-master')
@php
    $healthSessions = $data;
@endphp
    <!-- Head -->
@section('title', 'Health Session Summary Report')
@push('header')
    <style>
        body {
            font-size: 14px;
        }

        .double-table {
            display: flex;
        }

    </style>
@endpush

<!-- Body -->
@section('content')
    <div style="display:block; clear:both; page-break-after:always;">
        <h2 class="center">Health Session Summary Report</h2>
        @if(!isset($healthSessions))
            <h3 class="center">No Data Found !</h3>
        @endif

        @foreach($healthSessions as $healthSession)
            <div class="page-break">
                <h4 class="center underline">হেলথ সেশনের তথ্য</h4>
                <h4 class="center underline">প্রজেক্টের নামঃ {{$healthSession->j_project->name}} </h4>
                <table class="table-borderless p-20 " width="100%">
                    <tbody>
                    <tr>
                        <td>হেলথ সেশনের নাম</td>
                        <td class="w-1">:</td>
                        <td>{{$healthSession->session_heading}}</td>
                        <td>হেলথ সেশনের পদ্ধতি</td>
                        <td class="w-1">:</td>
                        <td>{{$healthSession->session_method}}</td>
                        <td>হেলথ সেশনের স্থান</td>
                        <td class="w-1">:</td>
                        <td>{{$healthSession->session_location}}</td>
                        <td>হেলথ সেশনের তারিখ</td>
                        <td class="w-1">:</td>
                        <td>{{$healthSession->start_date->toFormattedDateString()}}
                            - {{$healthSession->end_date->toFormattedDateString()}}</td>
                    </tr>
                    <tr>
                        <td>হেলথ সেশন রিসোর্স পার্সন</td>
                        <td class="w-1">:</td>
                        <td>{{$healthSession->resource_person_name}}</td>
                        <td>সাস্থ্য কর্মীর ফোন</td>
                        <td class="w-1">:</td>
                        <td>{{$healthSession-> resource_person_phone }}</td>
                        <td>সাস্থ্য কর্মীর পদ</td>
                        <td class="w-1">:</td>
                        <td>{{$healthSession->resource_person_designation}}</td>
                    </tr>
                    <tr>
                        <td>মন্তব্য</td>
                        <td class="w-1">:</td>
                        <td>{{$healthSession->remarks}}</td>
                    </tr>
                    </tbody>
                </table>
                <table width="100%">
                    <caption>
                        <h3 class="underline">হেলথ সেশনে অংশগ্রহনকারী </h3>
                    </caption>
                    <thead>
                    <tr>
                        <th width="50px">Sl No.</th>
                        <th>নাম</th>
                        <th>ফোন</th>
                        <th>জিআরও নাম</th>
                        <th>পরিবারের নাম</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($healthSession->health_session_present_mustahiqs as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->name?:''}}</td>
                            <td>{{$item->mobile?:''}}</td>
                            <td>{{$item->member->jeebika->j_gro->name?:''}}</td>
                            <td>{{$item->member->family->name?:''}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

@endsection
