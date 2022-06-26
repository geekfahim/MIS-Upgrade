@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@section('title', 'Health Session Training  Report')
@push('header')
@endpush

<!-- Body -->
@section("content")
    <div style="display:block; clear:both; page-break-after:always;">
        <h2 class="center text-capitalize underline">Family-Wise Health Session Report</h2>
        @foreach($data as $item)
            <div class="page-break">
                <h3 class="center text-capitalize">{{$item->name}} Health Session Report</h3>
                <table class="table-borderless" width="100%">
                    <caption>
                        <h3 class="underline">হেলথ সেশনে অংশগ্রহনকারী </h3>
                    </caption>
                    <tbody>
                    <tr>
                        <td>জীবিকা উন্নয়ন কেন্দ্রের নাম</td>
                        <td class="w-1">:</td>
                        <td>{{$item->jeebika->j_project->name ?:''}}</td>
                        <td>জিআরও নাম</td>
                        <td class="w-1">:</td>
                        <td>{{$item->jeebika->j_gro->name ?:''}}</td>
                        <td>পরিবারের নাম</td>
                        <td class="w-1">:</td>
                        <td>{{$item->name ?:''}}</td>
                    </tr>
                    </tbody>
                </table>
                <table width="100%">
                    <caption>
                        <h3>পরিবার বর্গের বিবরণ</h3>
                    </caption>
                    <thead>
                    <tr>
                        <th width="50px">Sl No.</th>
                        <th>পরিবার সদস্যের নাম</th>
                        <th>বয়স</th>
                        <th>হেলথ সেশন নাম</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($item['members_info'] as $member)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$member->name}}</td>
                            <td>{{$member->age}}</td>
                            <td>
                                @forelse($member->j_health_session as $healthSession)
                                    {{$healthSession->session_heading ?:''}}
                                    @if($healthSession->session_heading && !$loop->last)
                                        ,
                                    @endif
                                @empty

                                @endforelse
                            </td>
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
