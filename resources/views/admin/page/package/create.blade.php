@extends('admin.layout.app')
@section('module', 'Qablaşdırma')
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
            <form action="{{ route('package.store') }}" method="POST">
                @csrf
                <fieldset>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Adı</label>
                        <div class="col-lg-10">
                            <input type="text" name="name" placeholder="Adı" value="{{ old('name') }}" class="form-control" required>
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
@endsection
