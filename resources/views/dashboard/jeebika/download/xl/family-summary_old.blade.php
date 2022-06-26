@php
    $families = $data['families']
@endphp
    <!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Family Summary Report </title>
</head>

<body>
@foreach ($families as $family)
    <div style="display:block; clear:both; page-break-after:always;">
        <th colspan="20">{{$family->name}} Summary Report</th>
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
    {{-- @if ($loop->iteration % 5 == 0)
        <div style="display:block; clear:both; page-break-after:always; position: relative"></div>
    @endif --}}
@endforeach
</body>
</html>
