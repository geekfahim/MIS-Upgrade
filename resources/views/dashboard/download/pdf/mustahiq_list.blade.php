@php
    $items = $data['mustahiq']
@endphp
    <!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>All Mustahiq</title>

    <!-- Styles -->
    <style>
        html,
        body,
        div,
        p,
        table,
        tr,
        tbody,
        thead,
        th {
            margin: 0;
            padding: 0;
        }

        table,
        th,
        td,
        tbody {
            border: 1px solid black;
            border-spacing: 0;
        }

        body {
            font-size: 12px;
            line-height: 14px;
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

        .border-0 {
            border: none;
        }

    </style>
</head>

<body>
<div>
    <h2 style="text-align: center">All Mustahiq</h2>
    <table width="100%" style="margin-bottom: 50px">
        <thead>
        <tr>
            <th>Program</th>
            <th>Sponsor</th>
            <th>Age Range</th>
            <th>Date Range</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ isset($data['program']) ? $data['program'] : null }}</td>
            <td>{{ isset($data['sponsor']) ? $data['sponsor'] : null }}</td>
            <td>{{ isset($data['age_range']) ? $data['age_range'] : null }}</td>
            <td>{{ isset($data['date_range']) ? $data['date_range'] : null }}</td>
            <td>{{ isset($data['status']) ? $data['status'] : null }}</td>
        </tr>
        </tbody>
    </table>
    <table width="100%">
        <thead>
        <tr>
            <th width="50px">Sl No.</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Mobile</th>
            <th>Religion</th>
            <th>Education</th>
            <th>Disability</th>
            <th>Earn Ability</th>
            <th>Occupation</th>
            <th>District</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->gender->value }}</td>
                <td>{{ $item->age }}</td>
                <td>{{ $item->mobile }}</td>
                <td>{{ $item->religion->value }}</td>
                <td>{{ $item->highest_education_level }}</td>
                <td>
                    @if ($item->is_disability == 1)
                        <p>{{ucfirst($item->disability?$item->disability->name:'')}}</p>
                    @else
                        <p>No</p>
                    @endif
                </td>
                <td>
                    @if ($item->is_earn_ability == 1)
                        <p>Yes</p>
                    @else
                        <p>No</p>
                    @endif
                </td>
                <td>{{ $item->details->occupation?$item->details->occupation->name:'' }}</td>
                <td>{{ $item->permanent_district?$item->permanent_district->name:'' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br/>
</div>
</body>

</html>
