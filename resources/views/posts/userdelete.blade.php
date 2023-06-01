@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.deleteuser')</h1>  
    </div>
    <div class="box-white ms-3 me-3 shadow-sm">
        <div class="col-md-12"> 
            <h5 class="text-center"> @lang('admin.areyousure') </h5>     
            <h6 class="text-center"><strong>@lang('admin.user') : </strong>{{ $user->username }}</h6>
            <p class="lead text-center">@lang('admin.allcontents')</p>
        </div>
        <div class="row  mt-4">
            <div class="col-md-6">
                <form action="{{ url('/users/' . $user->id) }}" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger float-end">@lang('admin.delete')</button>
                </form>
            </div>
            <div class="col-md-6">
                <a href="{{ url('/users/') }}" class="btn btn-primary" role="button">@lang('admin.cancel')</a>      
            </div>
        </div>
    </div>
@endsection
