@extends('admin.layout.app')
@section('module', 'Sifarişlər')
@section('title', 'Yeni')
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body border-top-0">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible mb-1">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                            {{$error}}
                        </div>
                    @endforeach
                @endif
                <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Laboratoriyada nümunənin qeydiyyat nömrəsi:</label>
                            <div class="col-lg-10">
                                <input type="text" name="number" placeholder="Laboratoriyada nümunənin qeydiyyat nömrəsi" value="{{ old('number') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin qəbul tarixi/vaxtı:</label>
                            <div class="col-lg-10">
                                <input type="datetime-local" name="date" placeholder="Nümunənin qəbul tarixi/vaxtı" value="{{ old('date') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin laboratoriyaya daxil olma zamanı temperaturu:</label>
                            <div class="col-lg-10">
                                <input type="number" min="0" name="temperature" placeholder="Nümunənin laboratoriyaya daxil olma zamanı temperaturu" value="{{ old('temperature') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Məktubun Nömrəsi, nümunənin növü:</label>
                            <div class="col-lg-10">
                                <input type="text" name="sample_type" placeholder="Məktubun Nömrəsi, nümunənin növü" value="{{ old('sample_type') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Sifariş №:</label>
                            <div class="col-lg-10">
                                <input type="number" min="0" step="1" name="order_number" placeholder="Sifariş №" value="{{ old('order_number') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Ölkə:</label>
                            <div class="col-lg-10">
                                <select name="country" class="select-search">
                                    <option value="">Ölkə seçin</option>
                                    @foreach($countries as $country)
                                        <option @if(old('country_id') == $country->id) selected="selected" @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Qablaşdırma:</label>
                            <div class="col-lg-10">
                                <input type="text" name="package" placeholder="Qablaşdırma" value="{{ old('package') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin miqdarı:</label>
                            <div class="col-lg-10">
                                <input type="number" name="weight" placeholder="Nümunənin miqdarı" value="{{ old('weight') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin istehsal tarixi:</label>
                            <div class="col-lg-10">
                                <input type="date" name="production_date" value="{{ old('production_date') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin son istifadə tarixi:</label>
                            <div class="col-lg-10">
                                <input type="date" name="expire_date" value="{{ old('expire_date') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Sınaq protokolunun çıxma tarixi:</label>
                            <div class="col-lg-10">
                                <input type="date" name="release_date" value="{{ old('release_date') }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Sifarişçi:</label>
                            <div class="col-lg-10">
                                <input type="text" name="customer" value="{{ old('customer') }}" class="form-control">
                            </div>
                        </div>
                    </fieldset>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Yadda saxla</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
