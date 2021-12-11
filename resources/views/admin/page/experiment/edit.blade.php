@extends('admin.layout.app')
@section('module', 'Nümunədə aparılacaq sınaqlar')
@section('title', $experiment->name)
@section('content')

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
            <form action="{{ route('experiment.update', $experiment->id) }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $experiment->id }}" name="id">
                {{ method_field('PUT') }}
                <fieldset>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Adı</label>
                        <div class="col-lg-10">
                            <input type="text" name="name" placeholder="Adı" value="{{ old('name', $experiment->name) }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Növü</label>
                        <div class="col-lg-10">
                            <select name="type" class="select-search" id="type">
                                <option value="">Seçin</option>
                                @foreach(config('app.experiment_type') as $key => $type)
                                    <option @if(old('type', $experiment->type) == $key) selected="selected" @endif value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </fieldset>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Yadda saxla</button>
                </div>
            </form>
        </div>
    </div>
@endsection
