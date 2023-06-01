@extends('layouts.mastershow')
@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8">
            @auth
            @can('moderator-post', $post)
            <div class="d-flex align-items-center card-info border-one less-pad card-shadow">
                <i class="icon-robot fs-4 me-2"></i>
                <small>
                    @lang('messages.loged')
                    <strong class="text-capitalize">{{ auth()->user()->role }}.</strong>
            @isset($editby) 
                @lang('messages.editby') {{ $editby->username }} - {{ $post->updated_at->diffForHumans() }}
            @endisset
                </small>
                <span class="ms-auto">
                    <a href="{{ url('/home/' . $post->id . '/edit') }}" class="text-primary me-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.edit')"><i class="icon-pencil-square"></i></a>
                    <a href="{{ url('/home/' . $post->id) }}" class="text-danger me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.delete')"><i class="icon-trash"></i></a>
                </span>
            </div>
            @elsecan('own-post', $post)
            <div class="d-flex align-items-center card-info border-one less-pad card-shadow">
                <i class="icon-robot fs-4 me-2"></i>
                <small>
                    <strong class="text-capitalize">{{ $post->user->name }} </strong>@lang('messages.yourpost')
                    @isset($editby)
                        @lang('messages.editby') {{ $editby->username }} - {{ $post->updated_at->diffForHumans() }}
                    @endisset
                </small>
                <span class="ms-auto">
                    <a href="{{ url('/home/' . $post->id . '/edit') }}" class="text-primary me-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.edit')"><i class="icon-pencil-square"></i></a>
                    <a href="{{ url('/home/' . $post->id) }}" class="text-danger me-2" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.delete')"><i class="icon-trash"></i></a>
                </span>
            </div>
            @endcan
            @endauth
            <div class="card border-one card-shadow">
                @if (!empty($post->post_video))
                    <div class="ratio ratio-16x9 mb-3 card-img-top border-youtube">
                        <iframe src="https://www.youtube.com/embed/{{ $post->post_video }}" allowfullscreen></iframe>
                    </div>
                @elseif(!empty($post->post_media))
                    <img class="card-img-top img-fluid border-two" src="{{ url('/uploads/' . $post->post_media) }}" alt="{{ $post->media_alt }}">
                @endif
                <div class="card-body">
                    <div class="list-item mb-3">
                        <div class="list-left">
                            <a href="{{ url('/profile/' .$post->user->username) }}">
                            @if (substr( $post->user->avatar, 0, 4 ) === "http")
                            <img class="avatar img-fluid rounded-circle" src="{{ $post->user->avatar }}" alt="{{ $post->user->username }}">
                            @else
                            <img class="avatar img-fluid rounded-circle" src="{{ url('/images/' . $post->user->avatar) }}" alt="{{ $post->user->username }}">
                            @endif
                            </a>
                        </div>         
                        <div class="list-body">
                            <div class="text-ellipsis">
                                <a class="nocolor" href="{{ url('/profile/' .$post->user->username) }}">{{ $post->user->name }}</a>
                                <small class="text-muted time"><i class="icon-clock"></i> {{ $post->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="text-ellipsis">
                                <small class="text-muted">
                                    {{ $post->user->username }}
                                </small>
                                @isset($post->user->role)
                                <i class="icon-patch-check-fill text-primary verficon" title="@lang('messages.new.verified')"></i>
                                @endisset
                                @if (count($post->tags))
                                @foreach ($post->tags as $tag)
                                <small class="text-muted time"><a href="{{ url('/category/' . $tag->name) }}">
                                    #{{ $tag->name }}
                                </a></small>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <h1>{{ $post->post_title }}</h1>
                    @if (!empty($post->post_desc))
                    <p>
                        {{ $post->post_desc }}
                    </p>
                    @endif
                    @if (!empty($setting->post_ads))
                    <p>
                        {!! $setting->post_ads !!}
                    </p>
                    @endif
                @if($post->contents)
                    @foreach ($post->contents as $content)
                    @if ($content->type == "header")
                        @if (!empty($content->extra))
                        <{{ $content->extra }}>{{ $content->body }}</{{ $content->extra }}>
                        @else
                        <h4>{{ $content->body }}</h4>
                        @endif
                    @endif

                    @if ($content->type == "text")
                    <p>{{ $content->body }}</p>
                    @endif

                    @if ($content->type == "txteditor")
                    {!! clean( $content->body ) !!}
                    @endif

                    @if ($content->type == "image")
                        @if (!empty($content->link))
                        <a href="{{ $content->link}}"  target="{{ $content->blank == '0' ? '_self' : '_blank' }}">
                            <img class="img-fluid border-one mb-3" src="{{ url('/uploads/' . $content->body) }}" alt="{{ $content->extra }}">
                        </a>
                        @else
                            <img class="img-fluid border-one mb-3" src="{{ url('/uploads/' . $content->body) }}" alt="{{ $content->extra }}">
                        @endif
                    @endif

                    @if ($content->type == "youtube")
                    <div class="ratio border-youtube-all ratio-16x9 mb-3 mb-3">
                      <iframe src="https://www.youtube.com/embed/{{ $content->body }}" allowfullscreen></iframe>
                    </div>
                    @endif

                    @if ($content->type == "tweet")
                    <div class="embedbox mx-auto mb-3">
                        {!! $content->embed->embedcode !!}
                    </div>
                    @endif

                    @if ($content->type == "facebook")
                    <div class="embedbox mx-auto mb-3">
                        <div class="fb-post" 
                        data-href="{{ $content->embed->url }}"
                        data-width="auto"></div>
                    </div>
                    @endif

                    @if ($content->type == "instagram")
                    <div class="embedbox mx-auto mb-3">
                        {!! $content->embed->embedcode !!}
                    </div>
                    @endif

                    @if ($content->type == "pinterest")
                    <div class="embedbox mx-auto mb-3">
                        <a data-pin-do="embedPin" data-pin-width="medium" href="{{ $content->embed->url }}"></a>
                    </div>
                    @endif

                    @if ($content->type == "tiktok")
                    <div class="embedbox-tiktok mx-auto mb-3">
                        {!! $content->embed->embedcode !!}
                    </div>
                    @endif
                    @endforeach
                @endif
                </div>
                <div class="card-body card-border">
                    <div class="row">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center ps-2 pe-2 me-4">
                                @if (auth()->check())
                                    @if ($post->isLiked)
                                        <div class="heart heartliked" onclick="ClickHeart(this)" id="heart{{ $post->id }}"></div>
                                    @else
                                        <div class="heart" onclick="ClickHeart(this)" id="heart{{ $post->id }}"></div>
                                    @endif
                                @else
                                <a class="d-flex align-items-center" href="{{url('/login/')}}" >
                                    <span class="heartguest"></span>
                                </a>
                                @endif
                                <div class="likenumber" id="likeCount{{ $post->id }}">{{ shortNumber($post->likes()->count()) }}</div>
                            </div>
                            <div class="ps-2 pe-2">
                                <span class="text-muted"><i class="icon-eye me-2"></i> {{ shortNumber($post->counter) }}</span>
                            </div>
                            <div class="ms-auto">
                                <ul class="profile-links-list d-flex justify-content-center">
                                    <li class="nowrap">
                                        <a class="btn btn-white-shadow" data-pin-do="buttonBookmark" data-pin-custom="true" href="https://www.pinterest.com/pin/create/button/">
                                            <i class="icon-pinterest"></i></a>
                                    </li>
                                    <li class="nowrap">
                                        <a class="btn btn-white-shadow" role="button" onclick="shareButton(this)" href="https://www.facebook.com/sharer/sharer.php?u={{ url('/posts/' . $post->post_slug) }}" target="_blank">
                                            <i class="icon-facebook"></i></a>
                                    </li>
                                    <li class="nowrap">
                                        <a class="btn btn-white-shadow" role="button" onclick="shareButton(this)" href="https://twitter.com/share?url={{ url('/posts/' . $post->post_slug)}}" target="_blank">
                                            <i class="icon-twitter"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>   
                </div>
                @if ($setting->allow_comments == '0')
                <div class="card-footer">
                    @if (auth()->check())
                    <form method="POST" action="{{ url('/comments') }}" id="comment_form">
                    <input type="hidden" name="post_id" value="{{ $post->id }}" />
                    <textarea id="com-area" name="body" class="form-control mb-3" placeholder="Write a comment..." rows="3"></textarea>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-3">
                      <div id="show-com-msg" class="align-self-center d-none"></div>
                      <button id="postcomment" onclick="SubmitComment()" class="btn btn-primary btn-sm border-one" type="button">@lang('messages.comments.postcomment')</button>
                    </div>
                    </form>
                    @else
                    <p class="text-center"><a class="btn btn-sm btn-arrow border-one mt-2" role="button" href="{{url('/login/')}}" > <span class="m-2"><i class="icon-chat-dots"></i> @lang('messages.comments.logincomment') </span></a></p>
                    @endif
                <h6 class="pb-3 mb-2">@lang('messages.comments.comments') <span id="comcount" class="badge bg-secondary">{{ ($post->allcomments->count()) }}</span>
                </h6>
                <div id="dynamic_com">
                @if($post->comments)
                    @foreach ($post->comments as $comments)
                    <div class="maincom">
                    <div class="d-flex pt-3">                    
                        @if (substr( $comments->user->avatar, 0, 4 ) === "http")
                        <img class="flex-shrink-0 me-3 avatar img-fluid rounded-circle" src="{{ $comments->user->avatar }}" alt="{{ $comments->user->username }}">
                        @else
                        <img class="flex-shrink-0 me-3 avatar img-fluid rounded-circle" src="{{ url('/images/' . $comments->user->avatar) }}" alt="{{ $comments->user->username }}">
                        @endif
                    <p class="pb-3 mb-0 small lh-sm border-comment w-100">
                        <input type="hidden" class="comment_id own_id" value="{{ $comments->id }}" />
                        <span class="d-block mb-2">
                            <strong>
                                <a href="{{ url('/profile/' .$comments->user->username) }}">{{ str_limit($comments->user->name, 10) }}</a>
                            </strong>
                            <span class="usrname text-muted">{{ "@" . $comments->user->username }}</span>
                            <small class="text-muted time">{{ $comments->created_at->diffForHumans() }}
                            </small>
                        </span>
                        <span class="combody">
                            {!! clean( $comments->body ) !!}
                        </span>
                        @auth
                        <span class="d-block mt-2">
                            <a class="link-secondary me-3" onclick="ReplyComment(this)" href="#">@lang('messages.comments.reply')</a>@canany(['own-comment', 'moderator-post'], $comments)
                            <a class="link-secondary me-3" onclick="EditComment(this)" href="#">@lang('messages.edit')</a>
                            <a class="link-secondary" onclick="DeleteComment(this)" href="#">@lang('messages.delete')</a>
                            @endcanany
                        </span>
                        @endauth
                        <span class="d-block mt-2 editcomment d-none">
                        </span>
                    </p>                      
                    </div>                    
                    @foreach ($comments->replies as $comments)
                    <div class="d-flex pt-3 ps-5">                    
                        @if (substr( $comments->user->avatar, 0, 4 ) === "http")
                        <img class="flex-shrink-0 me-3 avatar-sm img-fluid rounded-circle" src="{{ $comments->user->avatar }}" alt="{{ $comments->user->username }}">
                        @else
                        <img class="flex-shrink-0 me-3 avatar-sm img-fluid rounded-circle" src="{{ url('/images/' . $comments->user->avatar) }}" alt="{{ $comments->user->username }}">
                        @endif
                    <p class="pb-3 mb-0 small lh-sm border-comment w-100">
                        <input type="hidden" class="comment_id" value="{{ $comments->parent_id }}" />
                        <input type="hidden" class="own_id" value="{{ $comments->id }}" />
                        <span class="d-block mb-2">
                            <strong>
                                <a href="{{ url('/profile/' .$comments->user->username) }}">{{ str_limit($comments->user->name, 10) }}</a>
                            </strong>
                            <span class="usrname text-muted">{{ "@" . $comments->user->username }}</span>
                            <small class="text-muted time">{{ $comments->created_at->diffForHumans() }}
                            </small>
                        </span>
                        <span class="combody">
                            {!! clean( $comments->body ) !!}
                        </span>
                        @auth
                        <span class="d-block mt-2">
                            <a class="link-secondary me-3" onclick="ReplyComment(this)" href="#">@lang('messages.comments.reply')</a>
                            @canany(['own-comment', 'moderator-post'], $comments)
                            <a class="link-secondary me-3" onclick="EditComment(this)" href="#">@lang('messages.edit')</a>
                            <a class="link-secondary" onclick="DeleteComment(this)" href="#">@lang('messages.delete')</a>
                            @endcanany
                        </span>
                        @endauth
                        <span class="d-block mt-2 editcomment d-none">
                        </span>
                    </p>                      
                    </div>
                    @endforeach
                    </div>
                    @endforeach
                @endif
                </div>
            </div>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="row mb-5">
                <div class="col">
                @if($previous)
                <a role="button" class="btn w-100 btn-arrow border-one" href="{{url('/posts/' . $previous)}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.previous')">
                    <i class="icon-arrow-left"></i>
                </a>
                @endif
                </div>
                <div class="col">
                @if($random)
                <a role="button" class="btn w-100 btn-arrow border-one" href="{{url('/posts/' . $random)}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.random')">
                    <i class="icon-shuffle"></i>
                </a>
                @endif
                </div>
                <div class="col">
                @if($next)
                <a role="button" class="btn w-100 btn-arrow border-one" href="{{url('/posts/' . $next)}}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="@lang('messages.next')">
                    <i class="icon-arrow-right"></i>
                </a>
                @endif
                </div>
            </div>
            @if (!empty($setting->page_ads))
            <div class="card border-one embed-responsive mb-3">
                {!! $setting->page_ads !!}
            </div>
            @endif
            @forelse($related as $relatedpost)
            @include('public.relatedpost')
            @empty
            <h6 class="text-light text-center">@lang('messages.norelated')</h6>
            @endforelse
        </div>
    </div>
</div>
@endsection
@section('extra')
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
@endsection
