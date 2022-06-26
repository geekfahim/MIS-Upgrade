@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@push('header')
    {{--    <title>GRO Full Report</title>--}}
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
            <h4 class="center underline">জিআরও তথ্য</h4>
            <h4 class="center underline">{{ $item->name }}</h4>
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
                <tr>
                    <td>জিআরও ব্যাংক</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->bank->name ?? 'N/A' }}</td>
                    <td>জিআরও ব্যাংক ব্রাঞ্চ</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->bank_branch_name ?? 'N/A' }}</td>
                    <td>জিআরও ব্যাংক এক্যাউন্ট ধারনকারীর নাম</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->bank_account_name ?? 'N/A' }}</td>
                    <td>জিআরও ব্যাংক এক্যাউন্ট নাম্বার</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->bank_account_number ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>জিআরও কোষাধ্যক্ষ</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->cashier->name ?? 'N/A' }}</td>
                    <td>জিআরও মোট পরিবার(সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->families_count }}</td>
                    <td>জিআরও মোট সদস্য(সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>{{ getTotalMemberCount(groId: $item->id) }}</td>
                    <td>জিআরও মোট প্রতিবন্ধী সদস্য(সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>{{ getTotalMemberCount(groId: $item->id,disability: 1) }}</td>
                </tr>
                <tr>
                    <td>জিআরও মোট চলমান ব্যাবসা</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->business_plans_count }}</td>
                    <td>জিআরও তহবিলে মোট টাকার পরিমান(সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->familys_sum_approved_amount ?? 0 }}</td>
                    <td>জিআরও মোট বিনিয়োগ(সংখ্যা)</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->investments_sum_approved_amount ?? 0 }}</td>
                    <td>জিআরও তহবিলে মোট সঞ্চয়</td>
                    <td class="w-1">:</td>
                    <td>{{ $item->savings_sum_approved_amount ?? 0 }}</td>
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
                    <th>পরিবারের নাম</th>
                    <th>প্রতিনিধির বয়স</th>
                    <th>প্রতিনিধির পেশা</th>
                    <th>প্রতিনিধির ফোন</th>
                    <th>প্রতিনিধির জাতীয় পরিচয়পত্র</th>
                    <th>পরিবার সদস্য(সংখ্যা)</th>
                    <th>পরিবারের মোট বার্ষিক আয়</th>
                    <th>পরিবারের মোট বার্ষিক ব্যায়</th>
                    <th>পরিবারের তহবিলে জমা</th>
                    <th>পরিবারের উপার্জনক্ষম ব্যক্তি(সংখ্যা)</th>
                    <th>পরিবারের মোট প্রতিবন্ধী</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($item->families as $value)
                    <tr>
                        <td>{{ $loop->iteration ?? 'N/A' }}</td>
                        <td>{{ $value->family ? $value->family->name : '' }}</td>
                        <td>{{ $value->family ? $value->family->head->age : '' }}</td>
                        <td>{{ $value->family ? ($value->family->head ? getOccupationNameByMustahiqId($value->family->head->id) : '' ) : '' }}</td>
                        <td>{{ $value->family ? $value->family->head->mobile : '' }}</td>
                        <td>{{ $value->family ? $value->family->head->nid : '' }}</td>
                        <td>{{ $value->family ? $value->family->number_of_family_member : '' }}</td>
                        <td>{{ $value->family ? $value->family->incomes_sum_income_amount : '' }}</td>
                        <td>{{ $value->family ? $value->family->expenses_sum_expense_amount : '' }}</td>
                        <td>{{ $value->family ? $value->family->familyBalance->balance : '' }}</td>
                        <td>{{ getTotalMemberCount(familyId: $value->family_id,earnAbility: 1) }}</td>
                        <td>{{ getTotalMemberCount(familyId: $value->family_id,disability: 1) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="bold">No Data Found!</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        @endforeach

    </div>
@endsection
