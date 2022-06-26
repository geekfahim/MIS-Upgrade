@extends('dashboard.layouts.master')
{{-- Program Dashboard --}}
@section('title', 'Dashboard | Area Office')
@section('content')
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Area Office</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
                    <div class="col-6 col-lg-3">
                        <a href="{{ route('jeebika.project.view') }}" target="_blank">
                            <div class="card overflow-hidden">
                                <div class="card-body p-0 d-flex align-items-center">
                                    <div class="bg-primary-gradient text-white p-4 me-3">
                                        <div class="icon icon-xl">
                                            <i class="icon-list"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-6 fw-semibold text-primary">10</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Number of JUK Project
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- /.col-->
                    <div class="col-6 col-lg-3">
                        <a href="{{ route('jeebika.gro.view') }}" target="_blank">
                            <div class="card overflow-hidden">
                                <div class="card-body p-0 d-flex align-items-center">
                                    <div class="bg-info-gradient text-white p-4 me-3">
                                        <div class="icon icon-xl">
                                            <i class="icon-home"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-6 fw-semibold text-info">165</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Number of GRO
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- /.col-->
                    <div class="col-6 col-lg-3">
                        <a href="{{ route('jeebika.family.view') }}" target="_blank">
                            <div class="card overflow-hidden">
                                <div class="card-body p-0 d-flex align-items-center">
                                    <div class="bg-info-gradient text-white p-4 me-3">
                                        <div class="icon icon-xl">
                                            <i class="icon-home"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-6 fw-semibold text-info">926</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Number of Household Cover
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- /.col-->
                    <div class="col-6 col-lg-3">
                        <a href="{{ route('jeebika.mustahiq_view.view__list') }}" target="_blank"></a>
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-warning-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon-user"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fs-6 fw-semibold text-warning">2055</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        Number of Population
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>
                    </div>
                    <!-- /.col-->
                    <div class="col-6 col-lg-3">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-primary-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon-location-pin"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fs-6 fw-semibold text-primary">12</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        Number of District Cover
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <a href="{{ route('jeebika.mustahiq_view.view__list') }}" target="_blank">
                            <div class="card overflow-hidden">
                                <div class="card-body p-0 d-flex align-items-center">
                                    <div class="bg-danger-gradient text-white p-4 me-3">
                                        <div class="icon icon-xl">
                                            <i class="icon-social-steam"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-6 fw-semibold text-danger">213</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Number of Disable Population
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3">
                        <a href="{{ url('jeebika/gro/1/business-plan-approve') }}" target="_blank">
                            <div class="card overflow-hidden">
                                <div class="card-body p-0 d-flex align-items-center">
                                    <div class="bg-info-gradient text-white p-4 me-3">
                                        <div class="icon icon-xl">
                                            <i class="icon-briefcase"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-6 fw-semibold text-info">5</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Active Business
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-warning-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon-graduation"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fs-6 fw-semibold text-danger">4</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        Upcoming Training
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-primary-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon-wallet"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fs-6 fw-semibold text-primary tk">23424</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        Outstanding Balance
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card overflow-hidden">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-primary-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon-wallet"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fs-6 fw-semibold text-primary tk">34344</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        Amount on Investment
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-->
                </div>
            </div>
            <hr>
            <div class="row justify-content-center">
                <a href="{{ route('jeebika.mustahiq_family_create.view') }}" target="_blank"
                   class="btn btn-shortcuts btn-primary-gradient">
                    Add Mustahiq
                </a>
                <a href="{{ route('jeebika.family.view') }}" target="_blank"
                   class="btn btn-shortcuts btn-info-gradient">
                    GRO Account
                </a>
                <a href="{{ route('jeebika.family.view') }}" target="_blank"
                   class="btn btn-shortcuts btn-warning-gradient">
                    Create Business Plan
                </a>
                <a href="{{ route('reports.family.view') }}" target="_blank"
                   class="btn btn-shortcuts btn-primary-gradient">
                    Family Reports
                </a>
            </div>
        </div>
    </main>
@endsection
