@extends('admin.layout.app')
@section('module', 'Rollar')
@section('title', $role->title)
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
            <form action="{{ route('role.update', $role->id) }}" method="POST">
                @csrf
                <input type="hidden" value="{{ $role->id }}" name="id">
                {{ method_field('PUT') }}
                <fieldset>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Adı</label>
                        <div class="col-lg-10">
                            <input type="text" name="name" placeholder="Adı" value="{{ old('name', $role->name) }}" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">İcazələr</label>
                        <div class="col-lg-10">
                            @if(!$permissions->isEmpty())
                                @foreach($permissions as $permission)
                                    <input type="checkbox" name="permissions" value="{{ $permission->id }}"> {{ $permission->name }}
                                @endforeach
                            @endif
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
