<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mustahiq Demographic Report</title>

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
    <h2 style="text-align: center">Mustahiq Demographic Report</h2>
    <table width="100%">
        <thead>
        <tr>
            <th width="50px">Sl No.</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Project Name</th>
            <th>GRO Name</th>
            <th>Family Name</th>
            <th>Blood Group</th>
            <th>NID</th>
            <th>Mobile</th>
            <th>Religion</th>
            <th>Education</th>
            <th>Disability</th>
            <th>Disease</th>
            <th>Regular Medicine</th>
            <th>Earn Ability</th>
            <th>Occupation</th>
            <th>Marital Status</th>
            <th>Orphan</th>
            <th>Reference Number</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->mustahiq_name }}</td>
                <td>{{ $item->gender->value }}</td>
                <td>{{ $item->age }}</td>
                <td>{{ $item->project_name }}</td>
                <td>{{ $item->gro_name }}</td>
                <td>{{ $item->family_name }}</td>
                <td>{{ $item->blood_group ? $item->blood_group->value : '' }}</td>
                <td>{{ $item->nid }}</td>
                <td>0{{ $item->mobile }}</td>
                <td>{{ $item->religion->value }}</td>
                <td>{{ $item->highest_education_level }}</td>
                <td>{{ $item->disability_name }}</td>
                <td>{{ $item->disease_name }}</td>
                <td>
                    @if ($item->is_disease_regular_medicine == 1)
                        <p>Yes</p>
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
                <td>{{ $item->occupation_name }}</td>
                <td>{{ $item->marital_status }}</td>
                <td>{{ $item->orphan_type }}</td>
                <td>{{ $item->reference_number }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <br/>
</div>
</body>

</html>
