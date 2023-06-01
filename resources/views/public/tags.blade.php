@extends('layouts.master')
@section('bodyclass')
    <body class="d-flex flex-column h-100">
@endsection
@section('content')
<div id="se-pre-con" class="d-flex justify-content-center align-items-center">
    <div class="spinner-grow me-1 text-danger" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow me-1 text-warning" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="spinner-grow me-1 text-info" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div id="maincontent" class="container-fluid mt-5 d-none">
    <div class="row">
        <div class="grid" data-columns>
            @forelse($tags as $tag)
            <div class="card border-one bg-dark text-white">
                <img class="tag-img" src="{{ url('/uploads/' . $tag->tag_media) }}" alt="{{ $tag->name }}">
                <div class="card-img-overlay bg-over">
                    <a class="link-over" href="{{ url('/category/' . $tag->name) }}"></a>
                    <p class="card-text text-muted text-uppercase mb-0">{{ str_limit($tag->title, 70) }}</p>
                    <h2 class="text-uppercase"> {{ $tag->name }} </h2>   
                </div>
            </div>
            @empty
            <div class="col-md-12">
                <h5 class="text-mode">@lang('messages.nocat')</h5>
            </div>
            @endforelse
        </div>
    </div>  
</div>
@endsection
@section('extra')
<div class="container-fluid mt-auto">
    <hr>
    <div class="row">
        <div class="col-md-12">
            {{ $tags->links() }}
        </div>
    </div>
    <footer class="blog-footer">
    @if (count($pages) > 0)
        <ul class="list-inline">
        @foreach ($pages as $page)    
            <li class="list-inline-item">
                <a class="text-mode" href="{{url('/page/' . $page->page_slug)}}">{{ $page->page_title }}</a>
            </li>
        @endforeach
        </ul>
    @endif
    @if (!empty($setting->footer))
    <div class="text-muted">{!! clean($setting->footer) !!}</div>
    @endif
    </footer>
</div>
@endsection