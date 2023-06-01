@extends('layouts.master')
@section('bodyclass')
    <body class="bg-userside">
@endsection
@section('jumbotron')
    <div class="jumbotron">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-9">
                    <h1 class="display-4">@lang('messages.home.title')</h1>
                    @isset(auth()->user()->role)
                    <h6>@lang('messages.home.youare') @lang(auth()->user()->role)</h6>
                    @endisset
                </div>
                <div class="col-md-3">
                    <div class="admin-item-img">
                        <a href="{{ url('/profile/' . auth()->user()->username) }}">
                            @if (substr( auth()->user()->avatar, 0, 4 ) === "http")
                            <img src="{{ auth()->user()->avatar }}" class="admin-image rounded-circle">
                            @else
                            <img src="{{ url('/images/' . auth()->user()->avatar) }}" class="admin-image rounded-circle">
                            @endif
                        </a>
                    </div>
                    <a href="{{ url('/profile/' . auth()->user()->username) }}">
                        <p class="member-item-user">{{ auth()->user()->name }}</p>
                    </a>
                    <p class="member-item-text">{{ auth()->user()->username }}</p>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('content')
    <div class="container pt-5 pb-5">
        @can('admin-area')
        <div class="row ms-3 me-3">
            <div class="col-12">
                <section class="admin admin-simple-sm p-3 card-shadow">
                    <h6> @lang('messages.home.logged') <a href="{{ url('/admin') }}">@lang('messages.home.admin')</a></h6>
                </section>
            </div>
        </div>
        @endcan
        <div class="row ms-3 me-3">
            <div class="col-12">
                <section class="admin admin-simple-sm p-3 card-shadow">                
                <form method="POST" action="{{url('/homepreference/' . auth()->user()->id)}}" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    @csrf
                    <span class="h6"> @lang('messages.new.homepreference') : </span>
                    <div class="form-check form-check-inline ms-4">
                        <label class="form-check-label" for="homepage1">
                        <input class="form-check-input" 
                            @if (auth()->user()->homepage == '0')
                            checked="checked" 
                            @endif
                            type="radio" name="homepage" id="homepage1" value="0"> <span class="h6"> @lang('messages.new.viewallposts') </span>
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label" for="homepage2">
                        <input class="form-check-input" 
                            @if (auth()->user()->homepage == '1')
                            checked="checked" 
                            @endif
                            type="radio" name="homepage" id="homepage2" value="1">
                        <span class="h6">@lang('messages.new.viewfollowingposts') </span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary">@lang('messages.save')</button>
                </form>
                </section>
            </div>
        </div>
        <div class="row m-3">
            @modorall
            <div class="col-md-3">
                <a  href="{{ url('/home/add') }}" role="button" class="btn btn-lg w-100 btnhome me-1 mb-2"> <i class="icon-plus-circle"></i> <br> @lang('messages.home.addpost')</a>
            </div>
            @endmodorall
            <div class="col-md-3">
                <a href="{{ url('/notifications') }}" role="button" class="btn btn-lg w-100 btnhome me-1 mb-2"><i class="icon-bell"></i> <br>@lang('messages.comments.notifications')
                    @if (count(auth()->user()->unreadNotifications) > 0)
                    <span class="badge bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/profile/' . auth()->user()->username) }}" role="button" class="btn btn-lg w-100 btnhome me-1 mb-2"><i class="icon-person"></i> <br>@lang('messages.home.profile')</a>
            </div>
            <div class="col-md-3">
                <a href="{{ url('/') }}" role="button" class="btn btn-lg w-100 btnhome me-1 mb-2"><i class="icon-house-door"></i> <br>@lang('messages.home.homepage')</a>
            </div>
        </div>
        @if (!empty($posts->items()))
        <div class="row ms-3 me-3">
            <div class="col-12">
                <section class="admin admin-simple-sm p-3 card-shadow">
                    <h6 class="text-secondary mb-4"> @lang('messages.home.unpublished') </h6>
                    <table class="table table-sm table-striped">
                      <form action="{{ url('/cnt/multiple/') }}" method="POST">
                        @csrf
                        {{ method_field('POST') }}
                        <tbody>
                            @forelse($posts as $post)
                            <tr>
                                <td>
                                    <a class="text-mode" href="{{url('/posts/' . $post->post_slug)}}" target="_blank">
                                        @if (! empty($post->post_title))
                                        {{ str_limit($post->post_title, 35) }}
                                        @else
                                        @lang('messages.home.notitle')
                                        @endif
                                    </a>
                                </td>
                                <td>
                                    @can('moderator-post')
                                    <a class="text-mode" href="{{ url('/profile/' . $post->user->username) }}" target="_blank">{{ str_limit($post->user->name, 10) }}</a>    
                                    @else
                                    <small class="font-italic text-muted">@lang('messages.home.awaiting')</small>
                                    @endcan
                                </td>
                                @can('moderator-post')
                                <td><a class="text-success" href="{{ url('/publishpost/' . $post->id) }}">@lang('messages.form.publish')</a></td>
                                @endcan
                                <td><a href="{{ url('/home/' . $post->id . '/edit') }}">@lang('messages.edit')</a></td>
                                <td><a class="color-delete" href="{{ url('/home/' . $post->id) }}">@lang('messages.delete')</a></td>
                            </tr>
                            @empty
                            <h5>
                                @lang('messages.nopost')
                            </h5>
                            @endforelse
                        </tbody>
                    </form>
                </table>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {{ $posts->links() }}
        </div>
    </div>
    @endif
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/form.js') }}"></script>
@endpush