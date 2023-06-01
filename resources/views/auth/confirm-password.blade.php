@extends('layouts.master')
@section('bodyclass')
    <body>
@endsection
@section('jumbotron')
<div class="jumbotron bg-none">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <h1 class="display-4">@lang('messages.login.secure')</h1>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container pt-5 pb-4">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.confirm') }}">
                        @csrf

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
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('messages.login.button')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
