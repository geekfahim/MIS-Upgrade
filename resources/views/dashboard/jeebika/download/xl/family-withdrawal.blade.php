@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Body -->
@section("content")
    @php
        $family = $data;
    @endphp
    <div style="text-align: center; padding-bottom: 5px">
        <h2 class="center">{{ $family->name }} GRO Withdrawal Report</h2>
        <p>Report Date: {{ \Carbon\Carbon::parse($data['from_date'])->format('d-M-Y') }}
            to {{ \Carbon\Carbon::parse($data['to_date'])->format('d-M-Y') }}</p>
    </div>
    @include('dashboard.jeebika.download.layouts.family-base-info')
    <h3>Transactions</h3>
    <table style="width: 100%">
        <thead>
        <tr>
            <th>Date</th>
            <th>Remarks</th>
            <th>Confirmed Amount</th>
            <th>Approved Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach ( $family['j_withdrawal'] as $item)
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
                {{$family['j_withdrawal']->sum('confirmed_amount')}}
            </td>
            <td>
                {{$family['j_withdrawal']->sum('approved_amount')}}
            </td>
        </tr>
        </tbody>
    </table>
@endsection
