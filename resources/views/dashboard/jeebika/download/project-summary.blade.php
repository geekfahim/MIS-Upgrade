@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@push('header')
    {{--    <title>Project Summary Report</title>--}}
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
        <h2 class="center"> Summary Report</h2>
        @foreach ($data as $item)
            <h4 class="center underline">প্রজেক্ট তথ্য</h4>
            <h4 class="center underline">{{ $item->name }}</h4>
            <table class="table-borderless p-10 " width="100%">
                <tbody>
                <tr>
                    <td>জীবিকা উন্নয়ন কেন্দ্রের নাম</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->name }}</td>
                    <td>প্রজেক্ট ম্যানেজার</td>
                    <td class="w-1">:</td>
                    <td>
                        {{ $item->manager->name ?? '' }}
                    </td>
                    <td>বিভাগ</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->district->name ?? ''}}</td>
                    <td>জোন</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->j_zone->name ?? ''}}</td>
                    <td>এরিয়া</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->j_area->name ?? ''}}</td>

                </tr>
                <tr>
                    <td>জিআরও (সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->gros_count}}</td>
                    <td>স্পন্সর (সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->sponsors_count }}</td>
                    <td>ফিল্ড অফিসার (সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->field_officers_count }}</td>
                    <td>মোট পরিবার (সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->families_count }}</td>
                    <td>মোট ইম্লিমেন্টেশন (সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>
                        {{$item->j_implementations_count}}
                    </td>
                </tr>
                <tr>
                    <td>প্রজেক্ট মন্তব্য</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->remarks }}</td>
                    <td>প্রজেক্ট শুরু তারিখ</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->start_date->format('Y-m-d') }}</td>
                    <td>প্রজেক্ট সম্ভাব্য শেষ তারিখ</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->end_date->format('Y-m-d') }}</td>
                </tr>
                </tbody>
            </table>
            <table width="100%">
                <caption>
                    <h3 class="underline">জিআরও তথ্য</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>জিআরও নাম</th>
                    <th>জিআরও পরিচিতি নাম্বার</th>
                    <th>জিআরও নেতা</th>
                    <th>জিআরও কোষাধ্যক্ষ</th>
                    <th>পরিবার সংখ্যা</th>
                    <th>চলমান ব্যাবসা</th>
                    <th>জিআরও তহবিলে জমা(টাকা)</th>
                </tr>
                </thead>
                <tbody>
                @forelse($item->gros as $item)
                    <tr>
                        <td>{{ $loop->iteration ?? 'N/A' }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->reference_id }}</td>
                        <td>{{ $item->leader->name ?? '' }}</td>
                        <td>{{ $item->cashier->name ?? '' }}</td>
                        <td>{{ $item->families_count }}</td>
                        <td>{{ $item->business_plans_count?? 0 }}</td>
                        <td>{{ $item->j_equities_sum_approved_amount ?? 0 }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="bold">No Data Found!</td>
                    </tr>
            @endforelse
        @endforeach

    </div>
@endsection
