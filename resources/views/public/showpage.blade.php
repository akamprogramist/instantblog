@extends('layouts.master')
@section('bodyclass')
    <body class="d-flex flex-column h-100">
@endsection
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">     
            <div class="card">
                <div class="card-body">
                    <h1>{{ $page->page_title }}</h1>
                    {!! $page->page_content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extra')
<div class="container-fluid mt-auto">
<hr>
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