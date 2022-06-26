@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@push('header')
    <title>Family Settlement Report</title>
@endpush

<!-- Body -->
@section("content")
    @foreach ( $data['families'] as $family )
        <div style="text-align: center; padding-bottom: 5px">
            <h2 class="center">{{ $family->name }} GRO Settlement Report</h2>
            <p>Report Date: {{ \Carbon\Carbon::parse($data['from_date'])->format('d-M-Y') }}
                to {{ \Carbon\Carbon::parse($data['to_date'])->format('d-M-Y') }}</p>
        </div>
        @include('dashboard.jeebika.download.layouts.family-base-info')
        <table style="width: 100%">
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
            @php( $total_debit = $total_credit = $balance = 0)
            @foreach ( $family['j_settlement'] as $item)
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
                    {{$family['j_settlement']->sum('confirmed_amount')}}
                </td>
                <td>
                    {{$family['j_settlement']->sum('approved_amount')}}
                </td>
            </tr>
            </tbody>
        </table>
    @endforeach
@endsection
