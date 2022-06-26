@extends('dashboard.layouts.master')

@section('title','Upazila')

@push('scripts')
<script>
    window.appHelper={
        routes:{!! json_encode(
            [
            'one' => route('settings.upazila.view'),
            'list' => route('settings.upazila.view__list'),
            'districtSearch' => route('search.district.view'),
            ]
        ) !!}
    }

</script>
@endpush

@section("content")
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">Setting</li>
        <li class="breadcrumb-item active">Upazila</li>
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="card card-accent-info" id="upazila-app">
                <Upazila></Upazila>
            </div>
        </div>
    </div>
</main>

@endsection
@push("footer")
    <script src="{{ asset("assets/js/dashboard/base/settings/upazila.js") }}"></script>
@endpush
