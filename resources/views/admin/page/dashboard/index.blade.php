@extends('admin.layout.app')
@section('title', 'Əsas səhifə')
@section('content')
<!-- Content area -->
<div class="content">
    <div class="row">
        <div class="col-sm-6 col-xl-3">
            <div class="card card-body">
                <div class="media">
                    <div class="mr-3 align-self-center">
                        <i class="icon-bars-alt icon-3x text-success"></i>
                    </div>

                    <div class="media-body text-right">
                        <h3 class="font-weight-semibold mb-0">{{ $count['total'] }}</h3>
                        <span class="text-uppercase font-size-sm text-muted">toplam sifariş</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body">
                <div class="media">
                    <div class="mr-3 align-self-center">
                        <i class="icon-list icon-3x text-indigo"></i>
                    </div>

                    <div class="media-body text-right">
                        <h3 class="font-weight-semibold mb-0">{{ $count['yearly'] }}</h3>
                        <span class="text-uppercase font-size-sm text-muted">illik sifariş</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body">
                <div class="media">
                    <div class="media-body">
                        <h3 class="font-weight-semibold mb-0">{{ $count['monthly'] }}</h3>
                        <span class="text-uppercase font-size-sm text-muted">aylıq sifariş</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-list-numbered icon-3x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card card-body">
                <div class="media">
                    <div class="media-body">
                        <h3 class="font-weight-semibold mb-0">{{ $count['daily'] }}</h3>
                        <span class="text-uppercase font-size-sm text-muted">günlük sifariş</span>
                    </div>

                    <div class="ml-3 align-self-center">
                        <i class="icon-list-ordered icon-3x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /content area -->
@endsection
