@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@push('header')
    {{--    <title>GRO Active Business Plan Report</title>--}}
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
    @foreach ($data as $item)
        <div style="display:block; clear:both; page-break-after:always;">
            <h2 class="center"> Active Business Plan Report of {{ $item->name }}</h2>
            <h4 class="center underline">জিআরও তথ্য</h4>
            <table class="table-borderless p-20 " width="100%">
                <tbody>
                <tr>
                    <td>জীবিকা উন্নয়ন কেন্দ্রের নাম</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->j_project->name }}</td>
                    <td>জিআরও এর নাম</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->name }}</td>
                    <td>জিআরও পরিচিতি নাম্বার</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->reference_id ?? 'N/A' }}</td>
                    <td>জিআরও নেতা</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->leader->name ?? 'N/A' }}</td>
                </tr>
                </tbody>
            </table>
            <table width="100%">
                <caption>
                    <h3 class="underline">পরিবারের তথ্য</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>ব্যাবসার নাম</th>
                    <th>পরিবারের নাম</th>
                    <th>Investment Area</th>
                    <th>Business Duration</th>
                    <th>Investment Return Type</th>
                    <th>Disbursement Date</th>
                    <th>Disbursement Amount</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($item->businessPlans as $bp)
                    <tr>
                        <td>{{ $loop->iteration ?? 'N/A' }}</td>
                        <td>{{ $bp->business_name  }}</td>
                        <td>{{ $bp->family->name  }}</td>
                        <td>{{ $bp->j_investment_approved_area->name  }}</td>
                        <td>{{ $bp->business_duration }} Months</td>
                        <td>{{ $bp->approved_investment_return_type->value  }}</td>
                        <td>{{ \Carbon\Carbon::parse($bp->disbursement_date)->format('d M Y') }}</td>
                        <td>{{ $bp->disbursement_amount  }}</td>
                        <td>{{ $bp->status->value  }}</td>
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
@endsection
