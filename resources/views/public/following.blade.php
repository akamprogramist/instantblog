@extends('layouts.master')
@section('bodyclass')
    <body class="d-flex flex-column h-100">
@endsection
@section('jumbotron')
<div class="header">
    <img class="header-img-top" src="{{ url('/uploads/'. $user->cover) }}" alt="{{ $user->name }}">
    <div class="container-fluid">
        <div class="header-body mt-n6">
            @include('public.profilehead')
            <div class="row align-items-center">
                <div class="col">
                    <ul class="nav nav-justified">
                      <li class="nav-item nav-pro">
                        <a class="nav-link" aria-current="page" href="{{ url('/profile/' . $user->username) }}">@lang('messages.new.posts')</a>
                      </li>
                      <li class="nav-item nav-pro">
                        <a class="nav-link" href="{{ url('/followers/' . $user->username) }}">@lang('messages.new.followers') <span class="badge bg-secondary">{{ shortNumber($user->followers()->count()) }}</span></a>
                      </li>
                      <li class="nav-item nav-pro">
                        <a class="nav-link active" href="{{ url('/following/' . $user->username) }}">@lang('messages.new.following') <span class="badge bg-secondary">{{ shortNumber($user->follows()->count()) }}</span></a>
                      </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid mt-2">
    <div class="row">
        @forelse ($follows as $follower)
        <div class="col-lg-4">
            <div class="d-flex alert follow-card border-one">
                @if (substr( $follower->avatar, 0, 4 ) === "http")
                <img class="avatar-sm img-fluid rounded-circle" src="{{ $follower->avatar }}">
                @else
                <img class="avatar-sm img-fluid rounded-circle" src="{{ url('/images/' . $follower->avatar) }}">
                @endif
            <div class="ps-2 mb-0 small lh-sm w-100">
                <div class="flwid d-flex justify-content-between">
                    <div>
                      <strong class="text-gray-dark"><a href="{{ url('/profile/' . $follower->username) }}">{{ $follower->name }}</a></strong>
                      <span class="d-block">{{ $follower->username }}</span>
                    </div>
                    <input type="hidden" name="follow_id" value="{{ $follower->id }}">
                    @if (auth()->check())
                        @unless (auth()->id() == $follower->id)
                            @if (auth()->user()->following($follower))
                            <button type="button" class="btn btn-sm btn-secondary border-one" onclick="follow(this)">@lang('messages.new.unfollow')</button>
                            @else
                            <button type="button" class="btn btn-sm btn-dark border-one" onclick="follow(this)">@lang('messages.new.follow')</button>
                            @endif
                        @endunless
                    @endif
                </div>                
              </div>
            </div>
        </div>
        @empty
        <div class="col-md-12">
            <h5>@lang('messages.new.nofollowing')</h5>
        </div>
        @endforelse
    </div> 
</div>
@endsection
@section('extra')
<div class="container-fluid mt-auto">
    <hr>
    <div class="row">
        <div class="col-md-12">
        {{ $follows->links() }}
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