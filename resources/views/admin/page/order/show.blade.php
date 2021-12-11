@extends('admin.layout.app')
@section('module', 'Sifarişlər')
@section('title', $order->id)
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-body border-top-0">
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Laboratoriyada nümunənin qeydiyyat nömrəsi:</div>
                    <div class="mt-2 mt-sm-0">{{ $order->number }}</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Nümunənin qəbul tarixi/vaxtı: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->date }}</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Nümunənin laboratoriyaya daxil olma zamanı temperaturu: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->temperature }} C</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Məktubun Nömrəsi, nümunənin növü: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->sample_type }}</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Sifariş №: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->order_number }}</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Ölkə: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->country->name ?? "" }}</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Qablaşdırma: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->package ? $order->package->name : '' }}</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Nümunənin miqdarı: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->weight }} qr</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Nümunənin istehsal tarixi: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->production_date }}</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Nümunənin son istifadə tarixi: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->expire_date }}</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Sınaq protokolunun çıxma tarixi: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->release_date }}</div>
                </div>
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Sifarişçi: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->customer }}</div>
                </div>
                @hasanyrole('Manager|Laboperator')
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Protokol: </div>
                    <div class="mt-2 mt-sm-0">{{ $order->protocol }}</div>
                </div>
                @endrole
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Barkod: </div>
                    <div class="mt-2 mt-sm-0">{!! DNS1D::getBarcodeHTML($order->id, 'UPCA') !!}</div>
                </div>

                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold width-100">Status </div>
                    <div class="mt-2 mt-sm-0">
                        @if($order->status == 0)
                            <span class="badge badge-success">Registrator</span>
                        @elseif($order->status == 1)
                            <span class="badge badge-success">Laboperator</span>
                        @elseif($order->status == 2)
                            <span class="badge badge-success">Manager</span>
                        @elseif($order->status == 3)
                            <span class="badge badge-success">Təsdiqləndi</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
