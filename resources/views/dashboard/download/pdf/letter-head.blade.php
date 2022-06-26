<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>All Mustahiq</title>

    <!-- Styles -->
    <style>
        html, body, div, p, table, tr, tbody, thead, th {
            margin: 0;
            padding: 0;
        }
        .logo{
            text-align: end;
        }
        .logo>img{
            width: 20%;
        }
        .czm-name{
            color: #24408f;
            font-weight: bold;
        }
        .letter-head{
            width: 100%;
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }
        .bismillah{
            margin-top: -40px;
            text-align: center;
            justify-items: self-start
        }
        .address,.logo{
            line-height: 1.5em;
        }
        .mt-50{
            margin-top: 50px;
        }
        .text-center{
            text-align: center;
        }
        table, th, td, tbody {
            border: 1px solid black;
            border-spacing: 0;
        }

        body {
            font-size: 12px;
            line-height: 14px;
        }
        table, th, td {
            border: 1px solid black;
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
        footer{
            position: absolute;
            width: 100%;
            bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
<div>
<div class="letter-head">
    <div class="address">
        <span class="czm-name">Center for Zakat Management(CZM)</span>
        <p>{{env('APP_ADDRESS', `<span>House-26,Road-7,Block-C,Niketon</span>
            <span>Gulshan-1,Dhaka-1212,Bangladesh</span>`)}}</p>
        <p>{{env('APP_PHONE',false) }}</p>
        <p>{{env('APP_EMAIL',false) }}</p>
        <p>{{env('APP_WEBSITE',false) }}</p>
    </div>
    <div class="bismillah">
        <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('assets/images/czm/bismillah.png')))}}" width="180"/>
    </div>
    <div class="logo">
        <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('assets/images/czm/czm-login-logo.png')))}}" width="180"/>
    </div>
</div>
    <h3 class="text-center mt-50">All Mustahiq</h3>
    <table width="100%">
        <thead>
        <tr>
            <th>Program</th>
            <th>Sponsor</th>
            <th>Status</th>
            <th>Date Range </th>

        </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Lorem, ipsum dolor.
                </td>
                <td>
                    Lorem, ipsum dolor.
                </td>
                <td>
                    Lorem, ipsum dolor.
                </td>
                <td>
                    Lorem, ipsum dolor.
                </td>
            </tr>
        {{-- @foreach($items ?? '' as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->gender }}</td>
                <td>{{ $item->religion }}</td>
                <td>{{ $item->origin_program }}</td>
                <td>{{ $item->status }}</td>
            </tr>
        @endforeach --}}
        </tbody>
    </table>
    <h3 class="text-center mt-50">All Mustahiq</h3>
    <table width="100%">
        <thead>
        <tr>
            <th width="50px">Sl No.</th>
            <th>Full Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Religion</th>
            <th>Education</th>
            <th>Disability</th>
            <th>Occupation</th>
            <th>Earnability</th>
            <th>District</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Lorem, ipsum dolor.
                </td>
                <td>
                    Lorem, ipsum dolor.
                </td>
                <td>
                    Lorem, ipsum dolor.
                </td>
                <td>
                    Lorem, ipsum dolor.
                </td>
                <td>
                    Lorem, ipsum dolor.
                </td>
                <td>
                    Lorem, ipsum dolor.
                </td>
                <td>Lorem ipsum dolor sit.</td>
                <td>Lorem ipsum dolor sit.</td>
                <td>Lorem ipsum dolor sit.</td>
                <td>Lorem ipsum dolor sit.</td>
            </tr>
        {{-- @foreach($items ?? '' as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->gender }}</td>
                <td>{{ $item->religion }}</td>
                <td>{{ $item->origin_program }}</td>
                <td>{{ $item->status }}</td>
            </tr>
        @endforeach --}}
        </tbody>
    </table>
</div>

</body>
<footer>
    <p>&copy; Center for Zakat Management</p>
</footer>
</html>
