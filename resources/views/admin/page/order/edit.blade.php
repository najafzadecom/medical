@extends('admin.layout.app')
@section('module', 'Sifarişlər')
@section('title', $order->id)
@section('content')
    <!-- Content area -->
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Redaktə et</h6>
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
                <form action="{{ route('order.update', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $order->id }}" name="id">
                    {{ method_field('PUT') }}
                    <fieldset>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Laboratoriyada nümunənin qeydiyyat nömrəsi:</label>
                            <div class="col-lg-10">
                                <input type="text" name="number" placeholder="Laboratoriyada nümunənin qeydiyyat nömrəsi" value="{{ old('number', $order->number) }}" class="form-control" @hasrole('Laboperator') readonly="readonly" @endrole>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin qəbul tarixi/vaxtı:</label>
                            <div class="col-lg-10">
                                <input type="datetime-local" name="date" placeholder="Nümunənin qəbul tarixi/vaxtı" value="{{ old('date', $order->date) }}" class="form-control" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin laboratoriyaya daxil olma zamanı temperaturu:</label>
                            <div class="col-lg-10">
                                <input type="number" min="0" name="temperature" placeholder="Nümunənin laboratoriyaya daxil olma zamanı temperaturu" value="{{ old('temperature', $order->temperature) }}" class="form-control" @hasrole('Laboperator') readonly="readonly" @endrole>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Məktubun Nömrəsi, nümunənin növü:</label>
                            <div class="col-lg-10">
                                <input type="text" name="sample_type" placeholder="Məktubun Nömrəsi, nümunənin növü" value="{{ old('sample_type', $order->sample_type) }}" class="form-control" @hasrole('Laboperator') readonly="readonly" @endrole>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Sifariş №:</label>
                            <div class="col-lg-10">
                                <input type="number" min="0" step="1" name="order_number" placeholder="Sifariş №" value="{{ old('order_number', $order->order_number) }}" class="form-control" @hasrole('Laboperator') readonly="readonly" @endrole>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Ölkə:</label>
                            <div class="col-lg-10">
                                <select name="country_id" class="select-search" @hasrole('Laboperator') readonly="readonly" @endrole >
                                    <option value="">Ölkə seçin</option>
                                    @foreach($countries as $country)
                                        <option @if(old('country_id', $order->country_id) == $country->id) selected="selected" @endif value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Qablaşdırma:</label>
                            <div class="col-lg-10">
                                <select name="package_id" class="select-search" @hasrole('Laboperator') readonly="readonly" @endrole >
                                    <option value="">Qablaşdırma seçin</option>
                                    @foreach($packages as $package)
                                        <option @if(old('package_id', $order->package_id) == $package->id) selected="selected" @endif value="{{ $package->id }}">{{ $package->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin miqdarı:</label>
                            <div class="col-lg-10">
                                <input type="number" name="weight" placeholder="Nümunənin miqdarı" value="{{ old('weight', $order->weight) }}" class="form-control" @hasrole('Laboperator') readonly="readonly" @endrole>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin istehsal tarixi:</label>
                            <div class="col-lg-10">
                                <input type="date" name="production_date" value="{{ old('production_date', $order->production_date) }}" class="form-control" @hasrole('Laboperator') readonly="readonly" @endrole>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nümunənin son istifadə tarixi:</label>
                            <div class="col-lg-10">
                                <input type="date" name="expire_date" value="{{ old('expire_date', $order->expire_date) }}" class="form-control" @hasrole('Laboperator') readonly="readonly" @endrole>
                            </div>
                        </div>

                        @hasrole('Manager')
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Sınaq protokolunun çıxma tarixi:</label>
                            <div class="col-lg-10">
                                <input type="date" name="release_date" value="{{ old('release_date', $order->release_date) }}" class="form-control">
                            </div>
                        </div>
                        @endrole

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Sifarişçi:</label>
                            <div class="col-lg-10">
                                <input type="text" name="customer" value="{{ old('customer', $order->customer) }}" class="form-control" @hasrole('Laboperator') readonly="readonly" @endrole>
                            </div>
                        </div>
                        @hasanyrole('Manager|Laboperator')
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Prokotol:</label>
                            <div class="col-lg-10">
                                <input type="text" name="protocol" value="{{ old('protocol', $order->protocol) }}" class="form-control">
                            </div>
                        </div>
                        @endrole

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Barkod:</label>
                            <div class="col-lg-10">
                                {!! DNS1D::getBarcodeHTML($order->id, 'UPCA') !!}
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="row">
                            @foreach($experiments as $key => $experiment)
                                @if(!$experiment->isEmpty())
                                    <div class="col-2">
                                        <h4>{{ config('app.experiment_type')[$key] }}</h4>
                                        @foreach($experiment as $exp)
                                            <input type="checkbox" name="experiments[]" value="{{ $exp->id }}" class="styled" @if(in_array($exp->id, old('experiments', $order->experiments))) checked="checked" @endif> {{ $exp->name }} <br/>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Yadda saxla</button>

                        @hasrole('Registrator')
                            <button type="submit" name="status" value="1" class="btn btn-primary">Laboperatora ötür</button>
                        @endrole

                        @hasrole('Laboperator')
                            <button type="submit" name="status" value="2" class="btn btn-primary">Managerə ötür</button>
                        @endrole

                        @role('Manager')
                            <button type="submit" name="status" value="3" class="btn btn-success"><i class="icon-check2"></i>Təsdiqlə</button>
                            <button type="submit" name="status" value="0" class="btn btn-danger"><i class="icon-arrow-left5"></i> Registratora geri göndər</button>
                            <button type="submit" name="status" value="1" class="btn btn-danger"><i class="icon-arrow-left5"></i> Laboperatora geri göndər</button>
                        @endrole
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /content area -->
@endsection
