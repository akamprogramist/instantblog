@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.editadminprofile')</h1>        
        <div class="btn-toolbar mb-2 mb-md-0">
            <span class="badge bg-light text-dark">@lang($admin->role)</span>
        </div>    
    </div>
    @can('admin-secret')
    <div class="box-white ms-3 me-3 shadow-sm">   
        @include('layouts.errors')
        <form method="POST" action="{{url('/adminprofile/' . $admin->id)}}" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @csrf
            <div class="mb-3 row">
                <label for="name" class="col-sm-4 col-form-label">@lang('admin.name')</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="name" name="name" value="{{ $admin->name }}" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="username" class="col-sm-4 col-form-label">@lang('admin.username')</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="username" name="username" value="{{ $admin->username }}" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email"  class="col-sm-4 col-form-label">@lang('admin.email')</label>
                <div class="col-sm-7">
                    <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}" required>
                </div>
            </div>
            <div class="mb-3 row">
            <label class="col-sm-4 col-form-label" >@lang('messages.new.cover_image')</label>
                <div class="col-sm-7">     
                    <input type="file" class="form-control-file" id="cover" name="cover" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">@lang('messages.new.coverimg_help')</small>
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label" >@lang('admin.image')</label>
                <div class="col-sm-7">     
                    <input type="file" class="form-control-file" id="avatar" name="avatar" aria-describedby="fileHelp">
                    <small id="fileHelp" class="form-text text-muted">@lang('messages.new.img_sizehelp')</small>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="website" class="col-sm-4 col-form-label">@lang('admin.website')</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="website" name="website" value="{{ $admin->website }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="facebook" class="col-sm-4 col-form-label">@lang('admin.facebook')</label>
                <div class="col-sm-7">
                        <input type="text" class="form-control" id="facebook" name="facebook" value="{{ $admin->facebook }}" placeholder="@lang('admin.username')">      
                </div>
            </div>
            <div class="mb-3 row">
                <label for="twitter" class="col-sm-4 col-form-label">@lang('admin.twitter')</label>
                <div class="col-sm-7">
                        <input type="text" class="form-control" id="twitter" name="twitter" value="{{ $admin->twitter }}" placeholder="@lang('admin.username')">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="instagram" class="col-sm-4 col-form-label">@lang('admin.instagram')</label>
                <div class="col-sm-7">
                        <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $admin->instagram }}" placeholder="@lang('admin.username')">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="linkedin" class="col-sm-4 col-form-label">@lang('admin.linkedin')</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{ $admin->linkedin }}">
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-7">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ url('/home/') }}" class="btn btn-danger" role="button">Cancel</a> 
                </div>
            </div>
        </form>
    </div>
    <div class="box-white ms-3 me-3 shadow-sm">
        <form method="POST" action="{{url('/adminprofile/' . $admin->id)}}" enctype="multipart/form-data">
            {{ method_field('PUT') }}
            @csrf
            <div class="mb-3 row">
                <label for="password"  class="col-sm-4 col-form-label">@lang('admin.password')</label>
                <div class="col-sm-7">
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password_confirmation"  class="col-sm-4 col-form-label">@lang('admin.passwordconf')</label>
                <div class="col-sm-7">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-7">
                    <button type="submit" class="btn btn-primary">@lang('admin.changepass')</button>
                </div>
            </div>
        </form>
    </div>
    @endcan
@endsection