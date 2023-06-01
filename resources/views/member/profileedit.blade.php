@extends('layouts.master')
@section('bodyclass')
    <body>
@endsection
@section('jumbotron')
<div class="jumbotron jblight">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <h1 class="display-4">@lang('messages.user.edit_profile')</h1>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container pb-5">
    <div class="row">
        <div class="col-md-8">
            <section class="box-white mt-4 card-shadow">
                @include('layouts.errors')
                <form method="POST" action="{{url('/profile/' . $user->id)}}" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-3 col-form-label">@lang('messages.sign.name')</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-3 col-form-label">@lang('messages.sign.username')</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email"  class="col-sm-3 col-form-label">@lang('messages.sign.email')</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" >@lang('messages.new.cover_image')</label>
                        <div class="col-sm-6">     
                            <input type="file" class="form-control-file" id="cover" name="cover" aria-describedby="fileHelp">
                            <small id="fileHelp" class="form-text text-muted">@lang('messages.new.coverimg_help')</small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                    <label class="col-sm-3 col-form-label" >@lang('messages.sign.user_image')</label>
                        <div class="col-sm-6">     
                            <input type="file" class="form-control-file" id="avatar" name="avatar" aria-describedby="fileHelp">
                            <small id="fileHelp" class="form-text text-muted">@lang('messages.new.img_sizehelp')</small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="website" class="col-sm-3 col-form-label">@lang('messages.sign.website')</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="website" name="website" value="{{ $user->website }}">
                        </div>
                    </div>
                     <div class="mb-3 row">
                        <label for="facebook" class="col-sm-3 col-form-label">@lang('messages.new.facebook')</label>
                        <div class="col-sm-9">
                                <input type="text" class="form-control" id="facebook" name="facebook" value="{{ $user->facebook }}" placeholder="@lang('messages.login.username')">                         
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="twitter" class="col-sm-3 col-form-label">@lang('messages.new.twitter')</label>
                        <div class="col-sm-9">
                                <input type="text" class="form-control" id="twitter" name="twitter" value="{{ $user->twitter }}" placeholder="@lang('messages.login.username')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="instagram" class="col-sm-3 col-form-label">@lang('messages.new.instagram')</label>
                        <div class="col-sm-9">
                                <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $user->instagram }}" placeholder="@lang('messages.login.username')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="linkedin" class="col-sm-3 col-form-label">@lang('messages.new.linkedin')</label>
                        <div class="col-sm-9">
                                <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{ $user->linkedin }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="offset-sm-4 col-sm-7">
                            <button type="submit" class="btn btn-primary">@lang('messages.save')</button>
                            <a href="{{ url('/home/') }}" class="btn btn-danger" role="button">@lang('messages.cancel')</a> 
                        </div>
                    </div>
                </form>
            </section>
        </div>
            <div class="col-md-4">
            <section class="box-white mt-4 card-shadow">
                <form method="POST" action="{{url('/profile/' . $user->id)}}" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    @csrf
                    <div class="mb-3 row">
                        <label for="password"  class="col-sm-4 col-form-label">@lang('messages.sign.password')</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password_confirmation"  class="col-sm-4 col-form-label">@lang('messages.sign.cpassword')</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="offset-sm-4 col-sm-7">
                            <button type="submit" class="btn btn-primary">@lang('messages.changepass')</button>
                        </div>
                    </div>
                </form>
            </section>
            @cannot('admin-secret')
            <section class="box-white mt-4 text-center card-shadow">
                <a class="btn btn-danger" role="button" href="{{ url('/deleteaccount/') }}">@lang('messages.new.userdelete')</a>
            </section>
            @endcan
        </div>        
    </div>
</div>
@endsection