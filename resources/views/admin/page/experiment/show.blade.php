@extends('admin.layout.app')
@section('module', 'Nümunədə aparılacaq sınaqlar')
@section('title', $experiment->name)
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-body border-top-0">
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Adı:</div>
                    <div class="mt-2 mt-sm-0">{{ $experiment->name }}</div>
                </div>

                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Növü:</div>
                    <div class="mt-2 mt-sm-0">{{ config('app.experiment_type')[$experiment->type] ?? "Seçilməyib" }}</div>
                </div>

                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Yaradılma tarixi:</div>
                    <div class="mt-2 mt-sm-0">{{ $experiment->created_at }}</div>
                </div>

                <div class="d-sm-flex flex-sm-wrap">
                    <div class="font-weight-semibold width-100">Yenilənmə tarixi:</div>
                    <div class="mt-2 mt-sm-0">{{ $experiment->updated_at }}</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
