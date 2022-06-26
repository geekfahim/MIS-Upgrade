@extends('dashboard.layouts.master')
{{-- Program Dashboard --}}
@section('title', 'Dashboard | Admin')
@section('content')
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Admin</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-info-gradient">
                            <div class="card-body pb-0">
                                <div class="text-value">
                                    120
                                </div>
                                <div>Number of Program</div>
                            </div>
                            <div style="height:25px;">
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-primary-gradient">
                            <div class="card-body pb-0">
                                <div class="text-value">
                                    1500
                                </div>
                                <div>Number of Household Cover</div>
                            </div>
                            <div style="height:25px;">
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-warning-gradient">
                            <div class="card-body pb-0">
                                <div class="text-value">
                                    7678
                                </div>
                                <div>Number of Population Cover</div>
                            </div>
                            <div style="height:25px;">
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-primary-gradient">
                            <div class="card-body pb-0">
                                <div class="text-value">
                                    12
                                </div>
                                <div>Number of District Cover</div>
                            </div>
                            <div style="height:25px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card text-white bg-danger-gradient">
                            <div class="card-body pb-0">
                                <div class="text-value">
                                    175
                                </div>
                                <div>Total Disable</div>
                            </div>
                            <div style="height:25px;">
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-lg-3">
                        <a href="">
                            <div class="card text-white bg-primary-gradient">
                                <div class="card-body pb-0">
                                    <div class="text-value">
                                        21
                                    </div>
                                    <div>Active Bussiness Plan</div>
                                </div>
                                <div style="height:25px;">
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-lg-3">
                        <a href="">
                            <div class="card text-white bg-primary-gradient">
                                <div class="card-body pb-0">
                                    <div class="text-value">
                                        21
                                    </div>
                                    <div>Upcoming Training</div>
                                </div>
                                <div style="height:25px;">
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6 col-lg-3">
                        <a href="">
                            <div class="card text-white bg-primary-gradient">
                                <div class="card-body pb-0">
                                    <div class="text-value">
                                        21
                                    </div>
                                    <div>Outstanding Balance</div>
                                </div>
                                <div style="height:25px;">
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- /.col-->
                </div>
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                        <a href="">
                            <div class="card text-white bg-primary-gradient">
                                <div class="card-body pb-0">
                                    <div class="text-value">
                                        21
                                    </div>
                                    <div>Amount on Investment</div>
                                </div>
                                <div style="height:25px;">
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
