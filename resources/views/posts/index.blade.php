@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.posts')</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-success fw-bold" href="{{ url('/home/add/') }}" role="button">@lang('admin.addnewpost')</a>
        </div>    
    </div>
    <div class="row ms-3 me-3">
        <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="{{ url('/contents/') }}">@lang('admin.published')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/unpublished/') }}">@lang('admin.unpublished')</a>
            </li>
        </ul>
    </div>  
    <div class="row box-white ms-3 me-3 mt-2 shadow-sm">                    
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col"><input type="checkbox" name="CheckAll" onclick="checkAll(this)" /></th>
                    <th scope="col">@lang('admin.title')</th>
                    <th scope="col">@lang('admin.views')</th>
                    <th scope="col">@lang('admin.user')</th>
                    <th scope="col">@lang('admin.edit')</th>
                    <th scope="col">@lang('admin.delete')</th>
                </tr>
            </thead>
            <form action="{{ url('/cnt/multiple/') }}" method="POST">
                    @csrf
                    {{ method_field('POST') }}
            <tbody>
                @forelse($posts as $post)      
                @include('posts.post')
                @empty
                <h5>
                    @lang('admin.nopostfound')
                </h5>
                @endforelse
            </tbody>
        </table>
        <div class="d-grid gap-2 d-md-block ps-0">
                <button name="mulbtn"  type="submit" class="btn btn-danger btn-sm" value="Delete">@lang('admin.delete')</button>
                <button name="mulbtn"  type="submit" class="btn btn-secondary btn-sm ms-2" value="Unpublish">@lang('admin.unpublish')</button>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $posts->links() }}
        </div>
    </div> 
@endsection
