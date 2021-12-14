@extends('admin.layout.app')
@section('module', 'İstifadəçilər')
@section('title', $user->name)
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
                <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{ $user->id }}" name="id">
                    {{ method_field('PUT') }}
                    <fieldset>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Adı</label>
                            <div class="col-lg-10">
                                <input type="text" name="name" placeholder="Adı" value="{{ old('name', $user->name) }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">İstifadəçi adı</label>
                            <div class="col-lg-10">
                                <input type="text" name="username" placeholder="İstifadəçi adı" value="{{ old('username', $user->username) }}" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Rol</label>
                            <div class="col-lg-10">
                                <select name="roles[]" class="select-search" multiple="multiple">
                                    @foreach($roles as $role)
                                        <option @if(in_array($role->id, old('roles', $user->roles->pluck('id')->toArray()))) selected="selected" @endif value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Şifrə</label>
                            <div class="col-lg-10">
                                <input type="password" name="password" placeholder="Şifrə" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Şifrənin təkrarı</label>
                            <div class="col-lg-10">
                                <input type="password" name="password_confirmation" placeholder="Şifrənin təkrarı" value="" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Şəkil</label>
                            <div class="col-lg-5">
                                <input type="file" name="photo" placeholder="Şəkil" class="form-control">
                            </div>
                            <div class="col-lg-5">
                                {!! $user->thumbnail !!}
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
