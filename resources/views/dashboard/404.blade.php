<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Center for Zakat Management Information Management System">
    <meta name="author" content="CZM ICT Department">
    <meta name="keyword" content="cims,czm,center for zakat management,erp czm,juk,project czm">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>404 | Not Found</title>
    <link rel="icon" type="image/svg" href="{{ asset('assets/images/czm/czm-favicon.svg') }}" sizes="any"/>
    <!-- Main styles for this application-->
    <link href="{{ asset("assets/css/notfound.css") }}" rel="stylesheet">

</head>
<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="clearfix">
                <h1 class="float-left number display-3 mr-4">404</h1>
                <h4 class="pt-3 text">Oops! You're lost.</h4>
                <p class="text-muted">The page you are looking for was not found.</p>
            </div>
            <a href="{{route('dashboard')}}" class="btn btn-info" type="button">Return to Dashboard</a>
        </div>
    </div>
</div>
</body>
</html>
