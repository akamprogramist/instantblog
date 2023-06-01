@extends('layouts.master')
@section('bodyclass')
    <body>
@endsection
@section('jumbotron')
<div class="jumbotron bg-none">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <h1 class="display-4">@lang('messages.new.userdelete')</h1>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container">
    <div class="box-white m-3 ms-3 me-3">
        <div class="col-md-12"> 
            <h2 class="text-center">@lang('admin.areyousure')</h2>
            <h6 class="lead text-center">@lang('messages.login.username') : {{ $user->username }}</h6>   
            <h6 class="lead text-center">@lang('admin.allcontents')</h6>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-6">
                <form action="{{ url('/profile/' . $user->id) }}" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger float-end">@lang('messages.delete')</button>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ url('/profile/' . $user->username) }}" class="btn btn-primary" role="button">@lang('messages.cancel')</a>      
            </div>
        </div>
    </div>
</div>
@endsection
