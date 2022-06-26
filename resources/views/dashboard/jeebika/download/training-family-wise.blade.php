@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@section('title', 'Family Training  Report')
@push('header')
@endpush

<!-- Body -->
@section("content")
    <div style="display:block; clear:both; page-break-after:always;">
        <h2 class="center text-capitalize underline">Family-wise Training Report</h2>
        @foreach($data as $item)
            <div class="page-break">
                <h3 class="center text-capitalize">{{$item->name}} Training Report</h3>
                <table class="table-borderless" width="100%">
                    <caption>
                        <h3 class="underline">ট্রেনিংয়ের অংশগ্রহনকারী </h3>
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
                        <th>ট্রেনিং আছে</th>
                        <th>ট্রেনিং প্রয়োজন</th>
                        <th>সিযেডএম ট্রেনিং</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($item['members_info'] as $member)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$member->name}}</td>
                            <td>{{$member->age}}</td>
                            <td>
                                @if(isset($member->vocational_haves))
                                    @foreach($member->vocational_haves as $trainingNeed)
                                        {{$trainingNeed->vocational->name?:''}}
                                        @if($member->skill_haves )
                                            ,
                                        @elseif(!$member->skill_haves && !$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                    <br>
                                @endif

                                @if(isset($member->skill_haves))
                                    @foreach($member->skill_haves as $trainingNeed)
                                        {{$trainingNeed->skill->name?:''}}
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @if(isset($member->vocational_needs))
                                    @foreach($member->vocational_needs as $trainingNeed)
                                        {{$trainingNeed->vocational->name?:''}}
                                        @if($member->skill_needs )
                                            ,
                                        @elseif(!$member->skill_needs && !$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                    <br>
                                @endif
                                @if(isset($member->skill_needs))
                                    @foreach($member->skill_needs as $trainingNeed)
                                        {{$trainingNeed->skill->name?:''}}
                                        @if( !$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @foreach($member->j_training as $czmTraining)
                                    {{$czmTraining->training_heading}}
                                    @if( !$loop->last)
                                        ,
                                        <br>
                                    @endif
                                @endforeach
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
