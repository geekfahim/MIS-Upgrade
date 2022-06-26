<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Participant-wise Report</title>
</head>
<body>
<div style="display:block; clear:both; page-break-after:always;">
    <h2 class="center text-capitalize underline">Participant Training Report</h2>
    @foreach($data as $item)
        <div class="page-break">
            <h3 class="center underline">{{$item->mustahiq->name}}'s Training Information</h3>
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
                    <h3 class="center underline">ট্রেনিংয়ের তথ্য</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <td>ট্রেনিংয়ের নাম</td>
                    <td>ট্রেনিংয়ের ধরন</td>
                    <td>ট্রেড</td>
                    <td>ট্রেনিংয়ের পদ্ধতি</td>
                    <td>ট্রেনিংয়ের তারিখ</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($item->mustahiq->j_training as $training)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$training->training_heading}}</td>
                        <td>{{$training->training_type}}</td>
                        <td>
                            @if($training->training_type==='Vocational')
                                {{$training->vocational->name}}
                            @else
                                {{$training->skill->name}}
                            @endif
                        </td>
                        <td>{{$training->training_method}}</td>
                        <td>{{$training->start_date->isoFormat('LLL')}}</td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach

</div>
</body>
</html>
