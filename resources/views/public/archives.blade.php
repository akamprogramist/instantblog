@extends('layouts.master')
@section('bodyclass')
    <body class="d-flex flex-column h-100">
@endsection
@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @foreach($archives as $stats)
        @php
        $month = Carbon\Carbon::parse($stats['month']);
        @endphp   
        <div class="col-md-2 mb-4">
            <a href="{{url('/archiveposts/?month=' . $stats['month'] . '&year=' . $stats['year']) }}" class="btn btn-secondary w-100" role="button">{{ $month->monthName . ' ' . $stats['year'] }}</a>
        </div>
        @endforeach
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