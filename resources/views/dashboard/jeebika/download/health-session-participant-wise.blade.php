@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@section('title', ' Participant Training  Report')
@push('header')
@endpush

<!-- Body -->
@section("content")
    <div style="display:block; clear:both; page-break-after:always;">
        <h2 class="center text-capitalize underline">Participant Health Session Report</h2>
        @foreach($data as $item)
            <div class="page-break">
                <h3 class="center underline">{{$item->mustahiq->name}}'s Health Session Information</h3>
                <h4 class="center underline">প্রজেক্টের নামঃ {{$item->jeebika->j_project->name}} </h4>
                <table class="table-borderless p-20" width="100%">
                    <tbody>
                    <tr>
                        <td>জিআরও নাম</td>
                        <td class="w-1">:</td>
                        <td>{{$item->jeebika->j_gro->name ?:''}}</td>
                        <td>পরিবারের নাম</td>
                        <td class="w-1">:</td>
                        <td>{{$item->family->name}}</td>
                        <td>অংশগ্রহনকারীর নাম</td>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->name}}</td>
                    </tr>
                    <tr>
                        <td>অংশগ্রহনকারীর ফোন</td>
                        <td class="w-1">:</td>
                        <td>{{$item->mustahiq->mobile?:''}}</td>
                    </tr>
                    </tbody>
                </table>
                <table width="100%">
                    <caption>
                        <h3 class="center underline">হেলথ সেশনের তথ্য</h3>
                    </caption>
                    <thead>
                    <tr>
                        <th width="50px">Sl No.</th>
                        <td>হেলথ সেশনের নাম</td>
                        <td>হেলথ সেশনে পদ্ধতি</td>
                        <td>হেলথ সেশনের তারিখ</td>
                        <td>হেলথ সেশন রিসোর্স পার্সন</td>
                        <td>হেলথ সেশন রিসোর্স পার্সন ফোন</td>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($item->mustahiq->j_health_session as $healthSession)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$healthSession->session_heading}}</td>
                            <td>{{$healthSession->session_method}}</td>
                            <td>{{$healthSession->start_date->toFormattedDateString()}}</td>
                            <td>{{$healthSession->resource_person_name}}</td>
                            <td>{{$healthSession->resource_person_phone}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="bold">No Data Found!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach

    </div>
@endsection
