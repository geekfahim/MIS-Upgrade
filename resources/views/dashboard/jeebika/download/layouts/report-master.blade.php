<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        .text-capitalize {
            text-transform: capitalize;
        }

        .custom_title {
            text-align: center;
            text-decoration: underline;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
    @stack("header")
</head>
<body>
@yield('content')
@stack("footer")
</body>
</html>
