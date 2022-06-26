@php
    $family = $data;
@endphp
    <!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">

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

        table caption {
            margin: 5px;
        }

        .table-borderless th, .table-borderless td {
            border: 0;
            padding: .5rem;
            text-align: left;
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

        .page-break {
            page-break-after: always;
            clear: both;
        }

        .tk::before {
            content: "৳";
            margin-right: 2px;
            font-weight: bolder;
        }

        .underline {
            text-decoration: underline;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: bold
        }

        .p-20 {
            padding: 20px;
        }

        .w-1 {
            width: 1rem;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

    </style>
</head>

<body>
<div style="display:block; clear:both; page-break-after:always;">
    <table>
        <th colspan="20" class="custom_title"
            style="font-weight: bold;font-size: 14px;">{{$family->name}} Summary Report
        </th>
    </table>
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
            <td class="center">{{ $family['assets_count'] ?? 0 }}</td>
            <td class="center">{{ $family['loans_count'] ?? 0 }}</td>
            <td class="center">{{ $family['incomes_count'] ?? 0 }}</td>
            <td class="center">{{ $family['expenses_count'] ?? 0 }}</td>
            <td class="center">{{ $family['savings_count'] ?? 0 }}</td>
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

</body>
</html>
