@php
    $items = $data['mustahiq']
@endphp
    <!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Mustahiq</title>
</head>
<body>
<div>
    <h3>All Mustahiq</h3>
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
    <table>
        <thead>
        <tr>
            <th>Sl No.</th>
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
        @foreach($items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->gender}}</td>
                <td>{{ $item->age}}</td>
                <td>{{ $item->mobile }}</td>
                <td>{{ $item->religion }}</td>
                <td>{{ $item->highest_education_level }}</td>
                <td>
                    @if ($item->is_disability == 1)
                        <p>{{ucfirst($item->disability_name)}}</p>
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
                <td>{{ $item->details->occupation_name }}</td>
                <td>{{ $item->permanent_district_name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
