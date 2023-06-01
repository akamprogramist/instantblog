@extends('layouts.master')

@section('bodyclass')
    <body>
@endsection
@if ($setting->site_instant == 1)
@section('jumbotron')
<div class="jumbotron bg-none">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <h1 class="display-4">@lang('messages.login.title')</h1>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container pt-5 pb-4">
    <div class="d-md-flex flex-row">
        <div class="col-md-4">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3{{ $errors->has('username') ? ' has-error' : '' }}">
                    <label for="username" class="form-label">@lang('messages.login.username')</label>
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                        @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                        @endif
                </div>

                <div class="mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="form-label">@lang('messages.login.password')</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="mb-3">             
                <div class="checkbox">
                    <label class="form-label">
                    @lang('messages.login.dont')
                    <a href="{{ route('register') }}"><strong> @lang('messages.login.sign')</strong></a>
                    </label>
                </div>
                <div class="checkbox">
                    <label class="form-label">
                    @lang('messages.login.forgot')
                    <a href="{{ route('password.request') }}"><strong> @lang('messages.login.click')</strong></a>
                    </label>
                </div>
                </div>
                <div class="mb-3">                    
                    <button type="submit" class="btn btn-primary btnpoint">
                        @lang('messages.login.button')
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-1 pt-md-5">
            <div class="ordiv mt-3">
                <strong>OR</strong>
            </div>
        </div>
        <div class="col-md-3 mt-5">
             <div class="sociallogin mb-3">
                <a role="button" class="btn btn-face-login social" href="{{ url('/auth/facebook') }}" ><img src="{{ url('/images/facebook_logo.png') }}" class="me-2"> @lang('messages.login.facebook')</a>
            </div>
             <div class="sociallogin">
                <a role="button" class="btn btn-google-login social" href="{{ url('/auth/google') }}" ><img src="{{ url('/images/google_logo.png') }}" width="37" class="me-3"> @lang('messages.login.google')</a>
            </div>
        </div>
    </div>
</div>
@endsection
@else
@include('member.information')
@endif
