@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@push('header')
    <title>Family Bank Charge Report</title>
@endpush

<!-- Body -->
@section("content")
    @foreach ( $data['families'] as $family )
        <div class="center pb-5">
            <h2>{{ $family->name }} GRO Bank Charge Report</h2>
            <p>Report Date: {{ \Carbon\Carbon::parse($data['from_date'])->format('d-M-Y') }}
                to {{ \Carbon\Carbon::parse($data['to_date'])->format('d-M-Y') }}</p>
        </div>
        @include('dashboard.jeebika.download.layouts.family-base-info')
        <table class="page-break" style="width: 100%">
            <caption>
                <h3>Transactions</h3>
            </caption>
            <thead>
            <tr>
                <th>Date</th>
                <th>Remarks</th>
                <th>Confirmed Amount</th>
                <th>Approved Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach ( $family['j_bank_charge'] as $item)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>
                    <td>{{ $item->remarks }}</td>
                    <td>{{ $item->confirmed_amount }}</td>
                    <td>{{ $item->approved_amount }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2">Total</td>
                <td>
                    {{$family['j_bank_charge']->sum('confirmed_amount')}}
                </td>
                <td>
                    {{$family['j_bank_charge']->sum('approved_amount')}}
                </td>
            </tr>
            </tbody>
        </table>
    @endforeach
@endsection
