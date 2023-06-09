<!DOCTYPE html>
<html class="{{ $theme }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ !empty($tag->desc) ? $tag->desc : $setting->site_desc }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>{{ $setting->site_name . ' - ' . $setting->site_title }}</title>
    <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
    @if (app()->getLocale() == 'ar' or app()->getLocale() == 'ku')
        <link href="{{ asset('/css/instant-rtl.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('/css/instant.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('/instanticon/style.css') }}" rel="stylesheet">
    @yield('css')
    @if (!empty($setting->site_analytic))
        {!! $setting->site_analytic !!}
    @endif
</head>
@yield('bodyclass')

@include('layouts.nav')

@yield('jumbotron')

@if ($flash = session('message'))
    <div class="container mt-3">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $flash }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@elseif ($flash = session('error'))
    <div class="container mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $flash }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@yield('content')

@yield('extra')

@if ($setting->cookie_option == '0')
    @include('layouts.cookie')
@endif

@include('layouts.footer')
<script src="{{ asset('/js/main.js') }}"></script>
@stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('se-pre-con').style.visibility = 'hidden';
        var element = document.getElementById('maincontent');
        element.classList.remove('d-none');
    }, false);
</script>
</body>

</html>
