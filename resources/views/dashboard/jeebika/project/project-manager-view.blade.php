@extends('dashboard.layouts.master')
@section('title', 'View '.$project->name.' | Jeebika')
@php($projectId= Session::get('s_j_project_id'))
@section("content")
    <main class="main">
        <div class="row no-gutters">
            <div class="col-md-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Jeebika</li>
                    <li class="breadcrumb-item"><a href="{{ route('jeebika.project.view') }}">Projects</a></li>
                    <li class="breadcrumb-item active">{{ $project->name }}</li>
                </ol>
            </div>
            <div class="col-md-6">
                @include('dashboard.jeebika.project.right-menu')
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
                                            <i class="icon-list"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fs-6 fw-semibold text-info">{{getProjectGroCount()}}</div>
                                        <div class="text-medium-emphasis text-uppercase fw-semibold small">
                                            Number of GRO's
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
                                        <div class="fs-6 fw-semibold text-info">{{getProjectFamilyCount()}}</div>
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
                                        <div
                                            class="fs-6 fw-semibold text-warning">{{getProjectFamilyMemberCount()}}</div>
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
                                            class="fs-6 fw-semibold text-danger">{{getTotalMemberCount($projectId,$disability=1)}}</div>
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
                                        <div
                                            class="fs-6 fw-semibold text-info">{{getActiveProjectBusinessCount()}}</div>
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
                                    <div class="fs-6 fw-semibold text-danger">{{getUpcomingTrainingCount()}}</div>
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
                                    <div
                                        class="fs-6 fw-semibold text-primary tk">{{getProjectOutstandingBalance()}}</div>
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
                                        class="fs-6 fw-semibold text-primary tk">{{getProjectInvestmentTotalAmount()}}</div>
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
            <h5>Monthly Activities</h5>
            <div class="row">
                <div class="col-6 col-lg-3">
                    <div class="card overflow-hidden">
                        <a href="{{ url('jeebika/project/1/ip-feedback') }}">
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
                        <a href="{{ url('jeebika/project/1/ip-feedback') }}">
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
                        <a href="{{ url('jeebika/project/1/ip-feedback') }}">
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
                        <a href="{{ url('jeebika/project/1/ip-feedback') }}">
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
        </div>
        <div class="container-fluid">
            <div class="animated fadeIn">
                @include('dashboard.jeebika.project.summary')
            </div>
        </div>
    </main>
@endsection


