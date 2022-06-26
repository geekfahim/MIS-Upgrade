@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@push('header')
    <title>Family Full Report</title>
@endpush
@push('header')
    <style>
        .double-table {
            display: flex;
        }
    </style>
@endpush

<!-- Body -->
@section("content")
    @foreach ($data['families'] as $family)
        <div style="display:block; clear:both; page-break-after:always;">
            <h2 class="center text-capitalize">{{ $family->name}} Full Report</h2>
            @include('dashboard.jeebika.download.layouts.family-base-info')
            {{-- Assets --}}
            <table style="width: 100%">
                <caption>
                    <h3>পারিবারিক সম্পদের বিবরণ</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>সম্পদের ধরণ</th>
                    <th>পরিমান(সংখ্যা)</th>
                    <th>মোট মূল্য</th>
                </tr>
                </thead>
                <tbody>
                @php($total = 0)
                @foreach ($family['assets'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->asset?$item->asset->name:'' }}</td>
                        <td>{{ $item->asset_quantity }}</td>
                        <td>{{ $item->asset_value }}</td>
                    </tr>
                    @php($total+=$item->asset_value)
                @endforeach
                <tr>
                    <th colspan="3">মোট সম্পদের পরিমান টাকায়</th>
                    <td style="font-weight: bold">{{ $total }}</td>
                </tr>
                </tbody>
            </table>
            {{-- Loans --}}
            <table style="width: 100%">
                <caption>
                    <h3>পারিবারিক ঋণের বিবরণ</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>ঋণ গ্রহণের তারিখ</th>
                    <th>ঋণের উৎস</th>
                    <th>ঋণের পরিমান</th>
                    <th>সুদের হার/অতিরিক্ত টাকা</th>
                    <th>পরিশোধের সময়সীমা</th>
                    <th>ঋণ ব্যাবহারের খাত</th>
                    <th>বর্তমান ঋণের স্থিতি</th>
                </tr>
                </thead>
                <tbody>
                @php($totalOutstanding = $totalLoan = 0)
                @foreach ($family['loans'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->loan_taking_date }}</td>
                        <td>{{ $item->loan_source_name }}</td>
                        <td>{{ $item->loan_amount }}</td>
                        <td>{{ $item->loan_rate_or_extra_amount }}</td>
                        <td>{{ $item->loan_duration }}</td>
                        <td>{{ Str::replace('_', ' ', $item->loan_purpose) }}</td>
                        <td>{{ $item->loan_outstanding_amount }}</td>
                    </tr>
                    @php($totalLoan+=$item->loan_amount)
                    @php($totalOutstanding+=$item->loan_outstanding_amount)
                @endforeach
                <tr>
                    <th colspan="3">মোট ঋণের পরিমান টাকায়</th>
                    <td style="font-weight: bold">{{ $totalLoan }}</td>
                    <th colspan="3">মোট বর্তমান ঋণের স্থিতি</th>
                    <td style="font-weight: bold">{{ $totalOutstanding }}</td>
                </tr>
                </tbody>
            </table>
            {{-- Incomes --}}
            <table style="width: 100%">
                <caption>
                    <h3>পরিবারের বার্ষিক আয়</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>আয়ের উৎস</th>
                    <th>আয়ের পরিমান টাকায়</th>
                </tr>
                </thead>
                <tbody>
                @php($total = 0)
                @foreach ($family['incomes'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->income?$item->income->name:'' }}</td>
                        <td>{{ $item->income_amount }}</td>
                    </tr>
                    @php($total+=$item->income_amount)
                @endforeach
                <tr>
                    <th colspan="2">মোট আয়ের পরিমান টাকায়</th>
                    <td style="font-weight: bold">{{ $total }}</td>
                </tr>
                </tbody>
            </table>
            {{-- Expense --}}
            <table style="width: 100%">
                <caption>
                    <h3>পরিবারের বার্ষিক ব্যায়</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>ব্যায়ের খাত</th>
                    <th>ব্যায়ের পরিমান টাকায়</th>
                </tr>
                </thead>
                <tbody>
                @php($total = 0)
                @foreach ($family['expenses'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::replace('_', ' ', $item->expense_type) }}</td>
                        <td>{{ $item->expense_amount }}</td>
                    </tr>
                    @php($total+=$item->expense_amount)
                @endforeach
                <tr>
                    <th colspan="2">মোট ব্যায়ের পরিমান টাকায়</th>
                    <td style="font-weight: bold">{{ $total }}</td>
                </tr>
                </tbody>
            </table>
            {{-- Savings --}}
            <table style="width: 100%">
                <caption>
                    <h3>পরিবারের বার্ষিক সঞ্চয়ের বিবরণ</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>সঞ্চয়ের ধরণ</th>
                    <th>সঞ্চয়ের পরিমান</th>
                </tr>
                </thead>
                <tbody>
                @php($total = 0)
                @foreach ($family['savings'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::replace('_', ' ', $item->savings_type) }}</td>
                        <td>{{ $item->savings_amount }}</td>
                    </tr>
                    @php($total+=$item->savings_amount)
                @endforeach
                <tr>
                    <th colspan="2">মোট সঞ্চয়ের পরিমান টাকায়</th>
                    <td style="font-weight: bold">{{ $total }}</td>
                </tr>
                </tbody>
            </table>
            {{-- NGO --}}
            <table style="width: 100%">
                <caption>
                    <h3>আর্থ-সামাজিক অবস্থা</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>এনজিও/সংস্থার নাম</th>
                    <th>সহায়তার ধরণ</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($family['otherNgos'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->ngo_name }}</td>
                        <td>{{ Str::replace('_', ' ', $item->ngo_help_type) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- Safety --}}
            <table style="width: 100%">
                <caption>
                    <h3>পরিবারের নিরাপত্তা </h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>নির্যাতিতের নাম</th>
                    <th>নির্যাতনকারীর সাথে সম্পৰ্ক</th>
                    <th>নির্যাতনের ধরণ</th>
                    <th>নির্যাতনের স্থান</th>
                    <th>নির্যাতনকারীর নাম</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($family['safeties'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->safety_victim_name }}</td>
                        <td>{{ Str::replace('_', ' ', $item->safety_relation_with_abuser) }}</td>
                        <td>{{ Str::replace('_', ' ', $item->safety_type_of_abuse) }}</td>
                        <td>{{ $item->safety_place_of_abuse }}</td>
                        <td>{{ $item->safety_abuser_name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- Help --}}
            <div class="double-table">
                <table width="100%" style="margin-right: 1rem">
                    <caption>
                        <h3>সহায়তা</h3>
                    </caption>
                    <thead>
                    <tr>
                        <th width="50px">Sl No.</th>
                        <th>প্রতিবেশীর সহায়তার ধরণ</th>
                        <th>মন্তব্য</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($family['neighbourHelps'] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::replace('_', ' ', $item->neighbour_help_type) }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <table style="width: 100%">
                    <caption>
                        <h3>সহায়তা</h3>
                    </caption>
                    <thead>
                    <tr>
                        <th width="50px">Sl No.</th>
                        <th>ধনীদের সহায়তার ধরণ</th>
                        <th>মন্তব্য</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($family['richHelps'] as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ Str::replace('_', ' ', $item->rich_help_type) }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            {{-- Conflict Resolves --}}
            <table style="width: 100%">
                <caption>
                    <h3>দ্বন্দ্ব মীমাংসা</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>মীমাংসাকারক</th>
                    <th>মন্তব্য</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($family['conflictResolves'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::replace('_', ' ', $item->conflict_resolve_type) }}</td>
                        <td></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- Disasters --}}
            <table style="width: 100%">
                <caption>
                    <h3>দূর্যোগ ও প্রতিকার</h3>
                </caption>
                <thead>
                <tr>
                    <th width="50px">Sl No.</th>
                    <th>দূর্যোগের ধরণ প্রতিকার</th>
                    <th>দূর্যোগের মাত্রা</th>
                    <th>দূর্যোগের প্রতিকার</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($family['disasters'] as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->disaster?$item->disaster->name:'' }}</td>
                        <td>{{ Str::replace('_', ' ', $item->disaster_level) }}</td>
                        <td>{{ $item->recover?$item->recover->name:'' }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endforeach
@endsection
