@extends('layouts.master')
@section('bodyclass')
    <body class="d-flex flex-column h-100">
@endsection
@section('jumbotron')
<div class="header">
    <img class="header-img-top" src="{{  $user->cover }}" alt="{{ $user->name }}">
    <div class="container-fluid">
        <div class="header-body mt-n6">
            @include('public.profilehead')
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-justified">
                      <li class="nav-item nav-pro">
                        <a class="nav-link active" aria-current="page" href="{{ url('/profile/' . $user->username) }}">@lang('messages.new.posts')</a>
                      </li>
                      <li class="nav-item nav-pro">
                        <a class="nav-link" href="{{ url('/followers/' . $user->username) }}">@lang('messages.new.followers') <span class="badge bg-secondary">{{ shortNumber($user->followers()->count()) }}</span></a>
                      </li>
                      <li class="nav-item nav-pro">
                        <a class="nav-link" href="{{ url('/following/' . $user->username) }}">@lang('messages.new.following') <span class="badge bg-secondary">{{ shortNumber($user->follows()->count()) }}</span></a>
                      </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
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
    <div class="row mt-2">
        <div class="grid" data-columns>
            @forelse($posts as $key => $post)      
            @include('public.post')
            @empty
            <div class="col-md-12">
                <h5>@lang('messages.nopost')</h5>
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
@push('scripts')
<script>
    var followURL = "{{ url('/follow') }}";
    var followtxt = "@lang('messages.new.follow')";
    var unfollowtxt = "@lang('messages.new.unfollow')";
</script>
@endpush