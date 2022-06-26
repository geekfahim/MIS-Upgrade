@extends('dashboard.layouts.master')
{{-- Program Dashboard --}}
@section('title', 'Dashboard | Admin')
@section('content')
    <main class="main">
        <h1 class="m-3">Livelihood Program Head Dashboard</h1>
        <!-- Breadcrumb
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active">Livelihood Program Head</li>
        </ol>-->
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
                                        <div class="fs-6 fw-semibold text-primary">
                                            {{getActiveProjectCount()}}
                                        </div>
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
                                        <div class="fs-6 fw-semibold text-info">
                                            {{getActiveGROCount()}}
                                        </div>
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
                                        <div class="fs-6 fw-semibold text-info">
                                            {{getActiveFamilyCount()}}
                                        </div>
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
                                        <div class="fs-6 fw-semibold text-warning">{{getActiveMustahiqCount()}}</div>
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
                                    <div class="fs-6 fw-semibold text-primary">{{getProjectDistrictCount()}}</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        Number of District Cover
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-lg-3">
                        <a href="{{ route('jeebika.mustahiq_view.view__list') }}?disability=all_disable"
                           target="_blank">
                            <div class="card overflow-hidden">
                                <div class="card-body p-0 d-flex align-items-center">
                                    <div class="bg-danger-gradient text-white p-4 me-3">
                                        <div class="icon icon-xl">
                                            <i class="icon-social-steam"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div
                                            class="fs-6 fw-semibold text-danger">{{getActiveDisableMustahiqCount()}}</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Number of Disable Population
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
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
                                        <div class="fs-6 fw-semibold text-info">
                                            {{getUnproductiveFamily($earnAbility=0)}}
                                        </div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Number of Unproductive Family
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
                                        <div class="fs-6 fw-semibold text-info">{{getActiveBusinessCount()}}</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Active Business
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-lg-3">
                        <a href="{{ route('jeebika.training.view') }}">
                            <div class="card overflow-hidden">
                                <div class="card-body p-0 d-flex align-items-center">
                                    <div class="bg-warning-gradient text-white p-4 me-3">
                                        <div class="icon icon-xl">
                                            <i class="icon-graduation"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-6 fw-semibold text-danger">{{getUpcomingTrainingCount()}}</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Upcoming Training
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
                                    <div
                                        class="fs-6 fw-semibold text-primary tk">{{getOutstandingBalanceGroTotalAmount()}}</div>
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
                                    <div class="fs-6 fw-semibold text-primary tk">{{getInvestmentTotalAmount()}}</div>
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
            <h5>Monthly Activities</h5>
            <div class="row">
                <div class="col-6 col-lg-3">
                    <div class="card overflow-hidden">
                        <a href="{{ route('jeebika.project.view') }}">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-warning-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon icon-list"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fs-6 fw-semibold text-warning">{{getActivitiesAllCount()}}</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        All Activities
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card overflow-hidden">
                        <a href="{{ route('jeebika.project.view') }}">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-primary-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon icon-heart"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="fs-6 fw-semibold text-primary">{{getActivitiesMonthlyCount()}}</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        This Month Activities
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card overflow-hidden">
                        <a href="{{ route('jeebika.project.view') }}">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-primary-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon icon-list"></i>
                                    </div>
                                </div>
                                <div>
                                    <div
                                        class="fs-6 fw-semibold text-primary">{{getActivitiesMonthlyCount(\App\Enums\JImplementationPlanStatus::Pending)}}</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        This Month Pending Activities
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="card overflow-hidden">
                        <a href="{{ route('jeebika.project.view') }}">
                            <div class="card-body p-0 d-flex align-items-center">
                                <div class="bg-warning-gradient text-white p-4 me-3">
                                    <div class="icon icon-xl">
                                        <i class="icon icon-list"></i>
                                    </div>
                                </div>
                                <div>
                                    <div
                                        class="fs-6 fw-semibold text-warning">{{getActivitiesMonthlyCount(\App\Enums\JImplementationPlanStatus::Implemented)}}</div>
                                    <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                        This Month Completed Activities
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <a href="{{ route('jeebika.project.view') }}" target="_blank"
                   class="btn btn-shortcuts btn-primary-gradient">
                    Add Project
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
