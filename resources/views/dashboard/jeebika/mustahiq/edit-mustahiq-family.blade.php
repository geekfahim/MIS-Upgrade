@extends('dashboard.layouts.master')

@section('title', $family->name.' | Edit Mustahiq Family')
@push('header')
    <link href="{{ asset("assets/vendors/bootstrap-datepicker/css/bootstrap-datepicker.min.css") }}" rel="stylesheet">
@endpush
@push('scripts')
    <script>
        window.appHelper = {
            routes: {
                one: "{!! route('jeebika.mustahiq_family_edit.view') !!}",
                init: "{!! route('request.jeebika.init') !!}",
                viewAll: "{!! route('jeebika.mustahiq_family_edit.view',['fid'=>$family->id]) !!}",
                upazilaSearch: "{!! route('search.upazila.view') !!}",
                unionSearch: "{!! route('search.union.view') !!}",
                info: "{!! route('jeebika.mustahiq_family_info_edit.update',['fid'=>$family->id]) !!}",
                asset: "{!! route('jeebika.mustahiq_family_asset_edit.view',['fid'=>$family->id]) !!}",
                loan: "{!! route('jeebika.mustahiq_family_loan_edit.view',['fid'=>$family->id]) !!}",
                saving: "{!! route('jeebika.mustahiq_family_saving_edit.view',['fid'=>$family->id]) !!}",
                expense: "{!! route('jeebika.mustahiq_family_expense_edit.view',['fid'=>$family->id]) !!}",
                income: "{!! route('jeebika.mustahiq_family_income_edit.view',['fid'=>$family->id]) !!}",
                ngo: "{!! route('jeebika.mustahiq_family_ngo_edit.view',['fid'=>$family->id]) !!}",
                disaster: "{!! route('jeebika.mustahiq_family_disaster_edit.view',['fid'=>$family->id]) !!}",
                safety: "{!! route('jeebika.mustahiq_family_safety_edit.view',['fid'=>$family->id]) !!}",
                neighbour: "{!! route('jeebika.mustahiq_family_neighbour_edit.view',['fid'=>$family->id]) !!}",
                rich: "{!! route('jeebika.mustahiq_family_rich_edit.view',['fid'=>$family->id]) !!}",
                conflict: "{!! route('jeebika.mustahiq_family_conflict_edit.view',['fid'=>$family->id]) !!}",
            }
        };
    </script>
@endpush

@section("content")
    <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb mb-1">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">Jeebika</li>
            <li class="breadcrumb-item">Mustahiq Family Edit</li>
            <li class="breadcrumb-item active">{{ $family->name }}</li>
        </ol>
        <div class="container-fluid">
            <div class="animated fadeIn" id="mustahiq-family-edit-app">
                <mustahiq-family-edit :family="{{ $family }}"></mustahiq-family-edit>
            </div>
        </div>
    </main>
@endsection


@push("footer")
    <script src="{{ asset("assets/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js") }}"></script>
    <script src="{{ asset("assets/js/dashboard/jeebika/mustahiq/mustahiq-family-edit.js") }}"></script>
@endpush
