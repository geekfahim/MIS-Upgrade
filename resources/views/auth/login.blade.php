<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | {{ env('APP_NAME') ?? 'MIS' }}</title>
    <link rel="icon" type="image/svg" href="{{ asset('assets/images/czm/czm-favicon.svg') }}" sizes="any"/>
    <link href="{{ asset("assets/vendors/@coreui/icons/css/coreui-icons.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/flag-icon-css/css/flag-icon.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/font-awesome/css/font-awesome.min.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/simple-line-icons/css/simple-line-icons.css") }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ asset("assets/css/style.css") }}" rel="stylesheet">
    <link href="{{ asset("assets/vendors/pace-progress/css/pace.min.css") }}" rel="stylesheet">

    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o), m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-118965717-1', 'auto');
        ga('send', 'pageview');
    </script>
    <style>
        .login-form-logo {
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 120px;
            height: 120px;
            background-color: #fff;
            margin: 0 auto;
        }

        .login-form-logo-image {
            height: 100px;
            width: 200px;
        }
    </style>
</head>
<body class="app flex-row align-items-center">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-6 col-lg-5 col-xl-4">
            <div class="card-group">
                <div class="card p-2">
                    <span class="login-form-logo">
                        <img class="login-form-logo-image" alt="center for zakat management czm"
                             src="{{ asset('assets/images/czm/czm-login-logo.png') }}">
                    </span>
                    <div class="card-body">
                        <div class="text-center">
                            <h1>Login</h1>
                            <p class="text-muted">CZM Information Management System</p>
                        </div>
                        {{ Form::open() }}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="icon-user"></i>
                                </span>
                            </div>
                            <input value="{{ old("email") ? old("email") :"ict@czm-bd.org"}}" name="email"
                                   class="form-control @error('email') is-invalid @enderror" type="text"
                                   placeholder="User Email" maxlength="30">
                            {{-- <input value="{{ old("email") }}" name="email"
                                   class="form-control @error('email') is-invalid @enderror" type="text"
                                   placeholder="Office ID" maxlength="30"> --}}
                            @if ($errors->any() && $errors->has('email'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="input-group mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="icon-lock"></i>
                                </span>
                            </div>
                            {{-- remove the value in production --}}
                            <input name="password" class="form-control @error('password') is-invalid @enderror"
                                   type="password" placeholder="Password" value="999999"
                                   maxlength="30">
                            @if ($errors->any() && $errors->has('password'))
                                <div class="invalid-feedback d-block">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-czm-blue px-4" type="submit">Login</button>
                            </div>
                            <div class="col-6 text-right">
                                <a href="#" class="btn btn-czm-link px-0">Forgot password?</a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset("assets/vendors/jquery/js/jquery.min.js") }}"></script>
{{--<script src="{{ asset("assets/vendors/popper.js/js/popper.min.js") }}"></script>--}}
<script src="{{ asset("assets/vendors/bootstrap/js/bootstrap.min.js") }}"></script>
<script src="{{ asset("assets/vendors/pace-progress/js/pace.min.js") }}"></script>
<script src="{{ asset("assets/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js") }}"></script>
<script src="{{ asset("assets/vendors/@coreui/coreui/js/coreui.min.js") }}"></script>
<script>
    $('#ui-view').ajaxLoad();
    $(document).ajaxComplete(function () {
        Pace.restart()
    });
</script>
</body>
</html>
