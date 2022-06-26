<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Training Report</title>
</head>
<body>
<div style="display:block; clear:both; page-break-after:always;">
    <h2 class="center">Training Summary Report</h2>
    @foreach($data as $training)
        <div class="page-break">
            <h4 class="center underline">ট্রেনিংয়ের তথ্য</h4>
            <h4 class="center underline">প্রজেক্টের নামঃ {{$training->j_project->name}} </h4>
            <table class="table-borderless p-20 " width="100%">
                <tbody>
                <tr>
                    <td>ট্রেনিংয়ের নাম</td>
                    <td class="w-1">:</td>
                    <td>{{$training->training_heading}}</td>
                    <td>ট্রেনিংয়ের ধরন</td>
                    <td class="w-1">:</td>
                    <td>{{$training->training_type}}</td>
                    <td>ট্রেড</td>
                    <td class="w-1">:</td>
                    <td>{{($training->skill?$training->skill->name:'')?:($training->vocational?$training->vocational->name:'')}}</td>
                    <td>ট্রেনিংয়ের পদ্ধতি</td>
                    <td class="w-1">:</td>
                    <td>{{$training->training_method}}</td>
                </tr>
                <tr>
                    <td>ট্রেনিংয়ের স্থান</td>
                    <td class="w-1">:</td>
                    <td>{{$training->training_location}}</td>
                    <td>ট্রেনিংয়ের তারিখ</td>
                    <td class="w-1">:</td>
                    <td>{{$training->start_date->toFormattedDateString()}}
                        - {{$training->end_date->toFormattedDateString()}}</td>
                    <td>ট্রেইনারের নাম</td>
                    <td class="w-1">:</td>
                    <td>{{$training->resource_person_name}}</td>
                    <td>ট্রেইনারের ফোন</td>
                    <td class="w-1">:</td>
                    <td>{{$training-> resource_person_phone }}</td>
                </tr>
                <tr>
                    <td>ট্রেইনারের পদ</td>
                    <td class="w-1">:</td>
                    <td>{{$training->resource_person_designation}}</td>
                    <td>মন্তব্য</td>
                    <td class="w-1">:</td>
                    <td>{{$training->remarks}}</td>
                </tr>
                </tbody>
            </table>
            <table width="100%">
                <caption>
                    <h3 class="underline">ট্রেনিংয়ের অংশগ্রহনকারী </h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>নাম</th>
                    <th>ফোন</th>
                    <th>জিআরও নাম</th>
                    <th>পরিবারের নাম</th>
                    <th>ট্রেনিং আছে</th>
                    <th>ট্রেনিং প্রয়োজন</th>
                    <th>সিজেডএম ট্রেনিং</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($training->training_present_mustahiqs as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->name?:''}}</td>
                        <td>{{$item->mobile?:''}}</td>
                        <td>{{$item->member->jeebika->j_gro->name?:''}}</td>
                        <td>{{$item->member->family->name?:''}}</td>
                        <td>
                            @if(isset($item->vocational_haves) && $training->training_type==='Vocational')
                                @foreach($item->vocational_haves as $trainingNeed)
                                    {{$trainingNeed->vocational->name?:''}}
                                    @if( !$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif

                            @if(isset($item->skill_haves) && ($training->training_type==='Skill'))
                                @foreach($item->skill_haves as $trainingNeed)
                                    {{$trainingNeed->skill->name?:''}}
                                    @if( !$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif


                        </td>
                        <td>
                            @if(isset($item->vocational_needs))
                                @foreach($item->vocational_needs as $trainingNeed)
                                    {{$trainingNeed->vocational->name?:''}}
                                    @if( !$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                            @if(isset($item->skill_needs))
                                @foreach($item->skill_needs as $trainingNeed)
                                    {{$trainingNeed->skill->name?:''}}
                                    @if( !$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if($training->training_type==='Vocational')
                                @foreach($item->j_training as $czmTraining)
                                    {{$czmTraining->training_heading?:''}}
                                    @if( !$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                            @if($training->training_type==='Skill')
                                @foreach($item->j_training as $czmTraining)
                                    {{$czmTraining->training_heading?:''}}
                                    @if( !$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>

</body>
</html>
