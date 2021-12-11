@extends('admin.layout.app')
@section('module', 'Qablaşdırma')
@section('title', $package->name)
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-body border-top-0">
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Adı:</div>
                    <div class="mt-2 mt-sm-0">{{ $package->name }}</div>
                </div>

                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Yaradılma tarixi:</div>
                    <div class="mt-2 mt-sm-0">{{ $package->created_at }}</div>
                </div>

                <div class="d-sm-flex flex-sm-wrap">
                    <div class="font-weight-semibold width-100">Yenilənmə tarixi:</div>
                    <div class="mt-2 mt-sm-0">{{ $package->updated_at }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
