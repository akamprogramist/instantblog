<!DOCTYPE html>
<html lang="en" class="{{ $theme }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="{{ !empty($post->post_desc) ? $post->post_desc : $setting->site_desc }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link rel="amphtml" href="{{ url('posts/' . $post->post_slug) }}/amp">
        <title>{{ !empty($post->post_title) ? $setting->site_name . ' - ' .$post->post_title : $setting->site_name . ' - ' . $setting->site_title }}</title>
        <!-- Facebook og-->
        <meta property="fb:app_id" content="{!! env('FACEBOOK_API_ID') !!}" />
        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="{{ !empty($post->post_title) ? $post->post_title : $setting->site_name . '-' . $setting->site_title }}" />
        <meta property="og:description" content="{{ !empty($post->post_desc) ? $post->post_desc : $setting->site_desc }}" />
        @if (!empty($post->post_media))
        <meta property="og:image" content="{{ url('/uploads/' . $post->post_media) }}" />
        @elseif (!empty($post->post_video))
        <meta property="og:image" content="https://i.ytimg.com/vi/{{ $post->post_video }}/hqdefault.jpg"/>
        @else
        <meta property="og:image" content="{{ url('/images/social.png') }}" />
        @endif        
        <!-- Twitter card-->
        <meta name="twitter:card" content="summary_large_image" />
        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:title" content="{{ !empty($post->post_title) ? $post->post_title : $setting->site_name . '-' . $setting->site_title }}" />
        <meta property="og:description" content="{{ !empty($post->post_desc) ? $post->post_desc : $setting->site_desc }}" />
        @if (!empty($post->post_media))
        <meta name="og:image" content="{{ url('/uploads/' . $post->post_media) }}" />
        @elseif (!empty($post->post_video))
        <meta name="og:image" content="https://i.ytimg.com/vi/{{ $post->post_video }}/hqdefault.jpg"/>
        @else
        <meta name="og:image" content="{{ url('/images/social.png') }}" />
        @endif

        <!-- Css styles-->
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/instant.css') }}" rel="stylesheet">  
        <link href="{{ asset('/instanticon/style.css') }}" rel="stylesheet">
        @if (!empty($setting->site_analytic))
            {!! $setting->site_analytic !!}
        @endif
    </head>
    <body>
        @include('layouts.nav')

        @yield('content')

        <div id="fb-root"></div>

        @yield('extra')

        @if ($setting->cookie_option == '0')
            @include('layouts.cookie')
        @endif
        
        @include('layouts.footer')
        <script>            
            var processing = "@lang('messages.form.processing')";
            var successCom = "@lang('messages.comments.success')";
            var now = "@lang('messages.comments.new')";
            var MsgEdit = "@lang('messages.edit')";
            var MsgCancel = "@lang('messages.cancel')";
            var MsgDelete = "@lang('messages.delete')";
            var MsgReply = "@lang('messages.comments.reply')";
            var MsgSure = "@lang('messages.comments.sure')";
            var siteURL = "{{ url('/') }}";
            var postID = "{{ $post->id }}";
        </script>
        <script src="{{ asset('/js/main.js') }}"></script>
        <script src="{{ asset('/js/comment.js') }}"></script>
        <script async src="https://platform.twitter.com/widgets.js"></script>
        <script async defer src="//platform.instagram.com/en_US/embeds.js"></script>
        <script async defer src="//assets.pinterest.com/js/pinit.js"></script>
        <script>
            window.fbAsyncInit = function() {
                FB.init({
                  appId            : '{{ env("FACEBOOK_API_ID") }}',
                  autoLogAppEvents : true,
                  xfbml            : true,
                  version          : 'v12.0'
                });
            };

            (function(d, s, id){
                   var js, fjs = d.getElementsByTagName(s)[0];
                   if (d.getElementById(id)) {return;}
                   js = d.createElement(s); js.id = id;
                   js.src = "https://connect.facebook.net/en_US/sdk.js";
                   fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    </body>
</html>