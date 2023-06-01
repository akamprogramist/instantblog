@extends('layouts.admin')
@section('content')
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">@lang('admin.dashboard')</h1>        
        </div>
        <div class="row">
        <div class="col-md-4">
            <section class="admin admin-simple-sm pt-3 shadow-sm">
                <div class="admin-simple-sm-icon">
                    <i class="icon-file-earmark-text"></i>
                </div>
                <div class="admin-simple-sm-bottom"> @lang('admin.totalpost') :
                {{ $countPo }}
                </div>
                <div class="admin-simple-sm-bottom bottom-white">
                        <a href="{{ url('/contents/') }}" role="button" class="btn btn-secondary btn-sm">@lang('admin.posts')</a>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="admin admin-simple-sm pt-3 shadow-sm">
                <div class="admin-simple-sm-icon">
                    <i class="icon-file-earmark-x"></i>
                </div>
                <div class="admin-simple-sm-bottom">@lang('admin.unpublishedposts') :
                @if ($countUn > 0)                
                <span class="badge rounded-pill bg-danger">{{ $countUn }}</span>
                @else
                {{ $countUn }}
                @endif
                </div>
                <div class="admin-simple-sm-bottom bottom-white">
                        <a href="{{ url('/unpublished/') }}" role="button" class="btn btn-secondary btn-sm">@lang('admin.unpublishedposts')</a>
                </div>
            </section>
        </div>
        <div class="col-md-4">
            <section class="admin admin-simple-sm pt-3 shadow-sm">
                <div class="admin-simple-sm-icon">
                    <i class="icon-file-earmark-person"></i>
                </div>
                <div class="admin-simple-sm-bottom">@lang('admin.totalusers') :
                {{ $countUs }}
                </div>
                <div class="admin-simple-sm-bottom bottom-white">
                        <a href="{{ url('/users/') }}" role="button" class="btn btn-secondary btn-sm">@lang('admin.users')</a>
                </div>
            </section>
        </div>
        </div>
@endsection
