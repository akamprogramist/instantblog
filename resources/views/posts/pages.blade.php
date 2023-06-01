@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.pages')</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-success fw-bold" href="{{ url('/pages/create') }}" role="button">@lang('admin.addnewpage')</a>
        </div>    
    </div>
    <div class="row box-white ms-3 me-3 shadow-sm">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>@lang('admin.id')</th>
                    <th>@lang('admin.title')</th>
                    <th>@lang('admin.edit')</th>
                    <th>@lang('admin.delete')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)      
                <tr> 
                    <th scope="row">{{ $page->id }}</th>
                    <td>
                        <a href="{{url('/page/' . $page->page_slug)}}">
                            {{ str_limit($page->page_title, 35) }}
                        </a>
                    </td>
                    <td><a href="{{ url('/pages/' . $page->id . '/edit') }}">@lang('admin.edit')</a></td>
                    <td><a class="color-delete" href="{{ url('/pages/' . $page->id) }}">@lang('admin.delete')</a></td>
                </tr>
                @empty
                @lang('admin.nopagefound')
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $pages->links() }}
        </div>
    </div>
@endsection