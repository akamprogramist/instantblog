@extends('layouts.admin')
@section('content')
    <div class="d-flex align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 flex-grow-1">@lang('admin.edituserprofile')</h1>
        <div class="p-2">
            @if (substr( $user->avatar, 0, 4 ) === "http")
                <img class="profile-card-photo" src=" {{ $user->avatar }} ">
                @else
                <img class="profile-card-photo" src="{{ url('/images/' . $user->avatar) }}">
                @endif
        </div>
        <h5 class="p-2">{{ $user->name }}</h5>  
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-9 col-12">
            <section class="box-white shadow-sm">
                @include('layouts.errors')
                <form method="POST" action="{{url('/users/' . $user->id)}}" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    @csrf
                    <div class="mb-3 row">
                        <label for="name" class="col-sm-4 col-form-label">@lang('admin.name')</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-4 col-form-label">@lang('admin.username')</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="rolechange" class="col-sm-4 col-form-label">@lang('admin.role')</label>
                        <div class="col-sm-7">
                            <select class="form-select" name="rolechange">
                                <option value="normal">user</option>
                                <option value="verified" {{ ( $user->role == 'verified') ? 'selected' : '' }}>verified</option>
                                <option value="editor" {{ ( $user->role == 'editor') ? 'selected' : '' }}>editor</option>
                                <option value="admin" {{ ( $user->role == 'admin') ? 'selected' : '' }}>admin</option>
                            </select>
                         </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="email"  class="col-sm-4 col-form-label">@lang('admin.email')</label>
                        <div class="col-sm-7">
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" >@lang('messages.new.cover_image')</label>
                        <div class="col-sm-6">     
                            <input type="file" class="form-control-file" id="cover" name="cover" aria-describedby="fileHelp">
                            <small id="fileHelp" class="form-text text-muted">@lang('messages.new.coverimg_help')</small>
                        </div>
                    </div>
                    <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label" >@lang('admin.image')</label>
                        <div class="col-sm-6">     
                            <input type="file" class="form-control-file" id="avatar" name="avatar" aria-describedby="fileHelp">
                            <small id="fileHelp" class="form-text text-muted">@lang('messages.new.img_sizehelp')</small>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="website" class="col-sm-4 col-form-label">@lang('admin.website')</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" id="website" name="website" value="{{ $user->website }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="facebook" class="col-sm-4 col-form-label">@lang('admin.facebook')</label>
                        <div class="col-sm-7">
                                <input type="text" class="form-control" id="facebook" name="facebook" value="{{ $user->facebook }}" placeholder="@lang('admin.username')">                         
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="twitter" class="col-sm-4 col-form-label">@lang('admin.twitter')</label>
                        <div class="col-sm-7">
                                <input type="text" class="form-control" id="twitter" name="twitter" value="{{ $user->twitter }}" placeholder="@lang('admin.username')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="instagram" class="col-sm-4 col-form-label">@lang('admin.instagram')</label>
                        <div class="col-sm-7">
                                <input type="text" class="form-control" id="instagram" name="instagram" value="{{ $user->instagram }}" placeholder="@lang('admin.username')">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="linkedin" class="col-sm-4 col-form-label">@lang('admin.linkedin')</label>
                        <div class="col-sm-7">
                                <input type="text" class="form-control" id="linkedin" name="linkedin" value="{{ $user->linkedin }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="status" class="col-sm-4 col-form-label text-danger">@lang('admin.banuser')</label>
                        <div class="col-sm-7">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" 
                                    @if ($user->status == '0')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="status" id="inlineRadio1" value="0"> @lang('admin.no')
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input"
                                    @if ($user->status == '1')
                                    checked="checked" 
                                    @endif
                                    type="radio" name="status" id="inlineRadio2" value="1">@lang('admin.yes')
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="offset-sm-4 col-sm-7">
                            <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
                            <a href="{{ url('/users') }}" class="btn btn-danger" role="button">@lang('admin.cancel')</a> 
                        </div>
                    </div>
                </form>
                 </section>
                <section class="box-white shadow-sm">
                <form method="POST" action="{{url('/users/' . $user->id)}}" enctype="multipart/form-data">
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
            </section>
        </div>        
    </div>
@endsection