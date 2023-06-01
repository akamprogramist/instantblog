@extends('layouts.admin')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('admin.categories')</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a class="btn btn-success fw-bold" href="{{ url('/cats/create') }}" role="button">@lang('admin.addnewcat')</a>
        </div>    
    </div>
    <div class="row box-white ms-3 me-3">
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                   <th>@lang('admin.id')</th>
                    <th>@lang('admin.title')</th>
                    <th>@lang('admin.name')</th>
                    <th>@lang('admin.edit')</th>
                    <th>@lang('admin.delete')</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tags as $tag)      
                <tr> 
                    <th scope="row">{{ $tag->id }}</th>
                    <td>
                        <a href="{{url('/category/' . $tag->name)}}">
                            {{ str_limit($tag->title, 35) }}
                        </a>
                    </td>
                    <td><div class="cat-bx {{ $tag->color}}"></div> {{ $tag->name}}</td>
                    <td><a href="{{ url('/cats/' . $tag->id . '/edit') }}">@lang('admin.edit')</a></td>
                    <td><a class="color-delete" href="{{ url('/cats/' . $tag->id) }}">@lang('admin.delete')</a></td>
                </tr>
                @empty
                @lang('admin.nocatfound')                
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $tags->links() }}
        </div>
    </div>
@endsection