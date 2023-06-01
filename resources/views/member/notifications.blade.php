@extends('layouts.master')
@section('bodyclass')
    <body class="bg-userside">
@endsection
@section('jumbotron')
<div class="jumbotron">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-9">
                <h1 class="display-4">@lang('messages.comments.notifications')</h1>
            </div>
            <div class="col-3 text-end">
                <a class="btn btn-sm btn-danger me-3" role="button" href="{{ url('/delnotifications') }}">@lang('messages.comments.deleteall')</a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container pt-5 pb-5">
    <div class="row">
        <div class="col-sm-12">
        <ul class="list-group list-group-flush">
            @forelse ($notifications as $notification)
            @if (empty($notification->read_at))
                <li class="list-group-item list-bg-unread d-flex justify-content-between align-items-center">
            @else
                <li class="list-group-item list-bg d-flex justify-content-between align-items-center">
            @endif
                <span>
                @isset($notification->data['type'])
                @if ($notification->data['type'] == "follow")
                <i class="icon-person-plus-fill me-2"></i>
                <a href="{{ url('/profile/' . $notification->data['user']) }}" target="_blank"> {{ $notification->data['user'] }}</a>
                @lang('messages.new.userfolowed')
                @endif
                @if ($notification->data['type'] == "like")
                <i class="icon-heart me-2"></i>
                <a href="{{ url('/profile/' . $notification->data['user']) }}" target="_blank"> {{ $notification->data['user'] }}</a> @lang('messages.new.userliked') <a href="{{ url('/posts/' . $notification->data['slug']) }}" target="_blank"> {{ str_limit($notification->data['title'], 30) }}</a>
                @endif
                @if ($notification->data['type'] == "comment")
                <i class="icon-chat-dots me-2"></i>
                <a href="{{ url('/profile/' . $notification->data['user']) }}" target="_blank"> {{ $notification->data['user'] }}</a> @lang('messages.new.mentioned') <a href="{{ url('/posts/' . $notification->data['slug']) }}" target="_blank"> {{ str_limit($notification->data['title'], 30) }}</a>
                @endif
                @if ($notification->data['type'] == "newcomment")
                <i class="icon-chat-dots me-2"></i>
                <a href="{{ url('/profile/' . $notification->data['user']) }}" target="_blank"> {{ $notification->data['user'] }}</a> @lang('messages.new.wrotecommt') <a href="{{ url('/posts/' . $notification->data['slug']) }}" target="_blank"> {{ str_limit($notification->data['title'], 30) }}</a>
                @endif
                @else
                <i class="icon-chat-dots me-2"></i> @lang('messages.comments.mentioned') <a href="{{ url('/posts/' . $notification->data['slug']) }}" target="_blank"> {{ str_limit($notification->data['title'], 30) }}</a>
                @endisset 
                </span>
                <span class="text-muted time">{{ $notification->created_at->diffForHumans() }}</span>
            </li>
            @empty
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>@lang('messages.comments.nonotification')</strong>
            </li>
            @endforelse
            </ul>         
        </div>
    </div>
</div>
@endsection