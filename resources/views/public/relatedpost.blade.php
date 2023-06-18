    @if (!empty($relatedpost->post_video))
        <div class="card border-one bg-dark text-white">
            <div class="youtube border-one">
                <span class="play-btn"></span>
                <img class="card-img change-ratio"
                    src="https://i.ytimg.com/vi/{{ $relatedpost->post_video }}/hqdefault.jpg" alt="video">
            </div>
            <div class="card-img-overlay bg-over">
                <a class="link-over" href="{{ url('/posts/' . $relatedpost->post_slug) }}"></a>
                <h4 class="bottom-txt">
                    {{ str_limit($relatedpost->post_title, 60) }}
                </h4>
                <a class="author" href="{{ url('/profile/' . $relatedpost->user->username) }}">
                    @if (substr($relatedpost->user->avatar, 0, 4) === 'http')
                        <img class="avatar-sm img-fluid rounded-circle" src="{{ $relatedpost->user->avatar }}"
                            alt="{{ $relatedpost->user->username }}">
                    @else
                        <img class="avatar-sm img-fluid rounded-circle"
                            src="{{ url('/images/' . $relatedpost->user->avatar) }}"
                            alt="{{ $relatedpost->user->username }}">
                    @endif
                    <div>{{ $relatedpost->user->name }}</div>
                </a>
                <small class="text-muted card-date">{{ $relatedpost->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @elseif(!empty($relatedpost->post_media))
        <div class="card border-one bg-dark text-white">
            <img class="card-img border-one" src="{{ $relatedpost->post_media }}"
                alt="{{ $relatedpost->post_title }}">
            <div class="card-img-overlay bg-over">
                <a class="link-over" href="{{ url('/posts/' . $relatedpost->post_slug) }}"></a>
                <h4 class="bottom-txt">
                    {{ str_limit($relatedpost->post_title, 70) }}
                </h4>
                <a class="author" href="{{ url('/profile/' . $relatedpost->user->username) }}">
                    @if (substr($relatedpost->user->avatar, 0, 4) === 'http')
                        <img class="avatar-sm img-fluid rounded-circle" src="{{ $relatedpost->user->avatar }}"
                            alt="{{ $relatedpost->user->avatar }}">
                    @else
                        <img class="avatar-sm img-fluid rounded-circle"
                            src="{{ url('/images/' . $relatedpost->user->avatar) }}"
                            alt="{{ $relatedpost->user->avatar }}">
                    @endif
                    <div>{{ $relatedpost->user->name }}</div>
                </a>
                <small class="text-muted card-date">{{ $relatedpost->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @else
        <div class="card border-one text-white stripes {{ $relatedpost->post_color }}">
            <div class="card-txt-body bg-over">
                <a class="link-over" href="{{ url('/posts/' . $relatedpost->post_slug) }}"></a>
                <h4>{{ str_limit($relatedpost->post_title, 70) }}</h4>
                <p class="card-text">{{ str_limit($relatedpost->post_desc, 90) }}</p>
                <a class="author" href="{{ url('/profile/' . $relatedpost->user->username) }}">
                    @if (substr($relatedpost->user->avatar, 0, 4) === 'http')
                        <img class="avatar-sm img-fluid rounded-circle" src="{{ $relatedpost->user->avatar }}"
                            alt="{{ $relatedpost->user->avatar }}">
                    @else
                        <img class="avatar-sm img-fluid rounded-circle"
                            src="{{ url('/images/' . $relatedpost->user->avatar) }}"
                            alt="{{ $relatedpost->user->avatar }}">
                    @endif
                    <div>{{ $relatedpost->user->name }}</div>
                </a>
                <small class="text-muted card-date">{{ $relatedpost->created_at->diffForHumans() }}</small>
            </div>
        </div>
    @endif
