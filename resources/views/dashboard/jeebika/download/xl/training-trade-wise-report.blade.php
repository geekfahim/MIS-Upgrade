<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trade-wise Report</title>
</head>
<body>
<div style="display:block; clear:both; page-break-after:always;">
    <h2 class="center underline"> Trade-wise Report</h2>
    @foreach($data as $item)
        <div class="page-break">
            <h4 class="center">
                Trade:
                @if($item->training_type==='Vocational')
                    {{$item->vocational->name}} Training
                @else
                    {{$item->skill->name}} Training
                @endif
            </h4>
            <h5 class="center">Training Type : {{$item->training_type}}</h5>
            <table width="100%">
                <caption>
                    <h3> ট্রেনিংয়ের বিবরণ</h3>
                </caption>
                <thead>
                <tr>
                    <td>অংশগ্রহনকারী নাম</td>
                    <th>ট্রেনিং</th>
                    <th>ট্রেনিং পদ্ধতি</th>
                    <th>প্রজেক্টের নাম</th>
                    <th>ট্রেনিং শুরু</th>
                    <th>ট্রেনিং শেষ</th>
                    <th>ট্রেনিংয়ের স্থান</th>
                    <th>ট্রেনিং রিসোর্স ব্যাক্তি</th>
                    <th>রিসোর্স ফোন</th>
                    <th>রিসোর্স পদবী</th>
                    <th>মন্তব্য</th>


                </tr>
                </thead>
                <tbody>
                <tr>
                <tr>
                    <td>{{$item->training_heading}}</td>
                    <td>{{$item->training_method}}</td>
                    <td>{{$item->j_project->name}}</td>
                    <td>{{$item->start_date->isoFormat('LLL')}}</td>
                    <td>{{$item->end_date->isoFormat('LLL')}}</td>
                    <td>{{$item->training_location}}</td>
                    <td>{{$item->resource_person_name}}</td>
                    <td>{{$item->resource_person_phone}}</td>
                    <td>{{$item->resource_person_designation}}</td>
                    <td>{{$item->remarks}}</td>
                </tr>
                </tbody>
            </table>
            <table width="100%">
                <thead>
                <th width="50px">Sl No.</th>
                <td>অংশগ্রহনকারী নাম</td>
                <th>বয়স</th>
                <th>মোবাইল</th>
                {{--                <th>ট্রেনিং আছে</th>
                                <th>ট্রেনিং প্রয়োজন</th>--}}
                </thead>
                <tbody>
                @foreach ($item['mustahiqs'] as $member)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$member->name}}</td>
                        <td>{{$member->age}}</td>
                        <td>{{$member->mobile}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
</div>
</body>
</html>
