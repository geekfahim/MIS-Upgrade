@extends('dashboard.layouts.master')

@section('title', 'View '.$gro->name.' | Jeebika')
@section("content")
    <main class="main">
        <div class="row no-gutters">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Jeebika</li>
                    <li class="breadcrumb-item"><a href="{{ route('jeebika.gro.view') }}">GROs</a></li>
                    <li class="breadcrumb-item active">{{ $gro->name }}</li>
                </ol>
            </div>
            <div class="col-md-6">
                @include('dashboard.jeebika.gro.right-menu')
            </div>
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                <div class="row">
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
                                        <div class="fs-6 fw-semibold text-info">{{getActiveGroFamilyCount()}}</div>
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
                        <a href="{{ route('jeebika.mustahiq_view.view__list') }}" target="_blank">
                            <div class="card overflow-hidden">
                                <div class="card-body p-0 d-flex align-items-center">
                                    <div class="bg-warning-gradient text-white p-4 me-3">
                                        <div class="icon icon-xl">
                                            <i class="icon-user"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-6 fw-semibold text-warning">{{getActiveGroMustahiqCount()}}</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Number of Population
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
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
                                        <div
                                            class="fs-6 fw-semibold text-danger">{{getActiveGroDisableMustahiqCount()}}</div>
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
                                        <div class="fs-6 fw-semibold text-info">{{getActiveGroBusinessCount()}}</div>
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
                                <div class="bg-primary-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon-wallet"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fs-6 fw-semibold text-primary tk">{{getOutstandingGroBalance()}}</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        Outstanding Balance of GRO's
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
                                    <div
                                        class="fs-6 fw-semibold text-primary tk">{{getInvestmentGroTotalAmount()}}</div>
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
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.gro.summary')
            </div>
        </div>
    </main>
@endsection
