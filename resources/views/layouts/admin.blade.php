<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="{{ asset('../../favicon.ico') }}">
        <title>@lang('admin.adminpanel')</title>
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/admin.css') }}" rel="stylesheet">
        <link href="{{ asset('/instanticon/style.css') }}" rel="stylesheet">
        <link href="{{ asset('/quill/dist/quill.snow.css') }}" rel="stylesheet">
    </head>
    <body>
        @include('layouts.adminnav')
        <div class="container-fluid">
        @if ($flash = session('message'))
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ $flash }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </main>
        </div>
        @elseif ($flash = session('error'))
        <div class="row">
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-2">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ $flash }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </main>
        </div>
        @endif

        <div class="row">
            @include('layouts.adminsidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
          </div>
        </div>

        @include('layouts.adminfooter')
        
        @stack('scripts')
    </body>
</html>