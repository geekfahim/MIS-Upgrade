@extends('dashboard.jeebika.download.layouts.report-master')
<!-- Head -->
@push('header')
    <title>Family Summary Report</title>
@endpush
@push('header')
@endpush

<!-- Body -->
@section("content")
    @foreach ($data['families'] as $family)
        <div style="display:block; clear:both; page-break-after:always;">
            <h2 class="center text-capitalize">{{$family->name}} Summary Report</h2>
            @include('dashboard.jeebika.download.layouts.family-base-info')
            <table width="100%">
                <thead>
                <tr>
                    <th>Total Asset Value</th>
                    <th>Total Loan Outstanding Amount</th>
                    <th>Total Income Amount</th>
                    <th>Total Expense Amount</th>
                    <th>Total Savings Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $family['assets_count'] ?? 0 }}</td>
                    <td>{{ $family['loans_count'] ?? 0 }}</td>
                    <td>{{ $family['incomes_count'] ?? 0 }}</td>
                    <td>{{ $family['expenses_count'] ?? 0 }}</td>
                    <td>{{ $family['savings_count'] ?? 0 }}</td>
                </tr>
                </tbody>
            </table>
            <table width="100%">
                <thead>
                <tr>
                    <th>Family Member Abuse</th>
                    <th>Help from Neighbour</th>
                    <th>Help from Rich</th>
                    <th>Conflict Resolver</th>
                    <th>Effect in Disaster</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $family['safeties_count'] }}</td>
                    <td>{{ $family['neighbour_helps_count'] }}</td>
                    <td>{{ $family['rich_helps_count'] }}</td>
                    <td>{{ $family['conflict_resolves_count'] }}</td>
                    <td>{{ $family['disasters_count'] }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    @endforeach
@endsection










{{--
<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Summary Report </title>
    <!-- Styles -->
    <style>
        html, body, div, p, table, tr, tbody, thead, th {
            margin: 0;
            padding: 0;
        }

        table, th, td, tbody {
            border: 1px solid black;
            border-spacing: 0;
        }

        table {
            margin-bottom: 50px;
        }

        body {
            font-size: 12px;
            line-height: 14px;
            padding: 20px;
        }

        th {
            font-size: 14px;
            padding: 2px 3px;
        }

        td {
            padding: 2px 3px;
            text-align: center;
        }

        thead {
            display: table-header-group
        }

        tfoot {
            display: table-row-group
        }

        tr {
            page-break-inside: avoid
        }

        .tk::before {
            content: "৳";
            margin-right: 2px;
            font-weight: bolder;
        }

        .custom_title {
            text-align: center;
            text-decoration: underline;
        }
    </style>
</head>

<body>
</body>

</html>--}}
