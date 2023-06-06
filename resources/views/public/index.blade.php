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
                    @include('public.weather')
                    @forelse($posts as $key => $post)
                        @include('public.post')
                        @if (!empty($setting->between_ads))
                            @if (($key + 1) % 9 == 0)
                                <div class="card border-one betads embed-responsive">
                                    {!! $setting->between_ads !!}
                                </div>
                            @endif
                        @endif
                    @empty
                        <div class="col-md-12">
                            <h5 class="text-mode">@lang('messages.nopost')</h5>
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
                    {{ $posts->links() }}
                </div>
            </div>
            <footer class="blog-footer">
                @if (count($pages) > 0)
                    <ul class="list-inline">
                        @foreach ($pages as $page)
                            <li class="list-inline-item">
                                <a class="text-mode"
                                    href="{{ url('/page/' . $page->page_slug) }}">{{ $page->page_title }}</a>
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
