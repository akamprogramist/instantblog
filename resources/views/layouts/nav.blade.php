<nav id="mainnav" class="navbar navbar-expand-md navbar-{{ $theme }} bg-nav">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img class="theme-btn light" src="{{ url('/images/' . $setting->site_logo) }}" alt="logo">
        <img class="theme-btn dark" src="{{ url('/images/' . $setting->site_logo_light) }}" alt="logo">
    </a>
    <div class="ms-auto me-4 me-md-0 order-md-2 navbar-nav">
        <button class="nav-link theme-btn light" onclick="setTheme('light')"><i class="icon-sun nav-icon"></i></button>
        <button class="nav-link theme-btn dark" onclick="setTheme('dark')"><i class="icon-moon nav-icon"></i></button>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsDefault"
        aria-controls="navbarsDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsDefault">
        <ul class="navbar-nav ">
            <li class="nav-item">
                <a class="nav-link me-3 d-none d-md-block {{ Request::is('/') ? 'active' : '' }}"
                    href="{{ url('/') }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="@lang('messages.hometxt')"><i class="icon-house-door nav-icon"></i></a>
                <a class="nav-link d-md-none" href="{{ url('/') }}"><i class="icon-house-door"></i>
                    @lang('messages.hometxt')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link me-3 d-none d-md-block {{ Request::is('popular') ? 'active' : '' }}"
                    href="{{ url('popular') }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="@lang('messages.populartxt')"><i class="icon-heart nav-icon"></i></a>
                <a class="nav-link d-md-none" href="{{ url('popular') }}"><i class="icon-heart"></i>
                    @lang('messages.populartxt')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link me-3 d-none d-md-block {{ Request::is('categories') ? 'active' : '' }}"
                    href="{{ url('categories') }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="@lang('messages.categoriestxt')"><i class="icon-grid nav-icon"></i></a>
                <a class="nav-link d-md-none" href="{{ url('categories') }}"><i class="icon-grid"></i>
                    @lang('messages.categoriestxt')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link me-3 d-none d-md-block {{ Request::is('archives') ? 'active' : '' }}"
                    href="{{ url('/archives') }}" data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="@lang('messages.archivestxt')"><i class="icon-clock nav-icon"></i></a>
                <a class="nav-link d-md-none" href="{{ url('archives') }}"><i class="icon-clock"></i>
                    @lang('messages.archivestxt')</a>
            </li>
            <li class="nav-item">
                <span data-bs-toggle="modal" data-bs-target="#searchModal">
                    <a class="nav-link me-3 d-none d-md-block" href="#" data-bs-toggle="tooltip"
                        data-bs-placement="bottom" title="@lang('messages.searchtxt')"><i class="icon-search nav-icon"></i></a>
                    <a class="nav-link d-md-none" href="#"><i class="icon-search"></i> @lang('messages.searchtxt')</a>
                </span>
            </li>

            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ app()->getLocale() }}
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="en">en</a>
                    </li>
                    <li><a class="dropdown-item" href="ar">ar</a>
                    </li>
                    <li><a class="dropdown-item" href="ku">ku</a>
                    </li>
                </ul>
            </div>
            @unless (auth()->check())
                <li class="nav-item">
                    <a class="nav-link me-3 d-none d-md-block {{ Request::is('login') ? 'active' : '' }}"
                        href="{{ url('/login') }}" data-bs-togg e="tooltip" data-bs-placement="bottom"
                        title="@lang('messages.logintxt')"><i class="icon-person-circle nav-icon"></i></a>
                    <a class="nav-link d-md-none" href="{{ url('/login') }}"><i class="icon-person-circle"></i>
                        @lang('messages.logintxt')</a>
                </li>
            @else
                @can('admin-area')
                    <li class="nav-item d-flex align-items-center">
                        <a href="{{ url('/home/add') }}" class="me-3 btn btn-secondary border-one btn-grad"
                            role="button">@lang('messages.addpost')</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link me-3 dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (substr(auth()->user()->avatar, 0, 4) === 'http')
                                <img class="avatar-xs img-fluid rounded-circle" src="{{ auth()->user()->avatar }}"
                                    alt="{{ auth()->user()->username }}">
                            @else
                                <img class="avatar-xs img-fluid rounded-circle"
                                    src="{{ url('/images/' . auth()->user()->avatar) }}"
                                    alt="{{ auth()->user()->username }}">
                            @endif
                            {{ auth()->user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ url('/admin') }}">@lang('messages.home.admin')</a>
                            <a class="dropdown-item" href="{{ url('/home') }}">@lang('messages.mpanel')</a>
                            <a class="dropdown-item"
                                href="{{ url('/profile/' . auth()->user()->username) }}">@lang('messages.mpro')</a>
                            <a class="dropdown-item" href="{{ url('/logout') }}"
                                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                @lang('messages.logout')
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @else
                    @if (auth()->user()->can('edit-post') or
                            $setting->allow_users == '0')
                        <li class="nav-item d-flex align-items-center">
                            <a href="{{ url('/home/add') }}" class="me-3 btn btn-secondary border-one btn-grad"
                                role="button">@lang('messages.addpost')</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link me-3 dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if (substr(auth()->user()->avatar, 0, 4) === 'http')
                                <img class="avatar-xs img-fluid rounded-circle" src="{{ auth()->user()->avatar }}">
                            @else
                                <img class="avatar-xs img-fluid rounded-circle"
                                    src="{{ url('/images/' . auth()->user()->avatar) }}">
                            @endif
                            {{ auth()->user()->name }}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ url('/home') }}">@lang('messages.mpanel')</a>
                            <a class="dropdown-item"
                                href="{{ url('/profile/' . auth()->user()->username) }}">@lang('messages.mpro')</a>
                            <a class="dropdown-item" href="{{ url('/logout') }}"
                                onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                                @lang('messages.logout')
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endcan
            @endunless
        </ul>
    </div>
</nav>
<!-- Modal -->
<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-body p-5">
                <div class="row">
                    <div class="col-10">
                        <form class="form-inline" action="{{ url('/search') }}" method="get">
                            <div class="input-group mb-3">
                                <input name="s" type="text" class="form-control form-control-lg"
                                    id="lgFormGroupInput" placeholder="@lang('messages.searchtxt')"
                                    aria-describedby="button-addon2" required>
                                <button type="submit" id="button-addon2" class="btn btn-outline-secondary"><i
                                        class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-lg btn-dark" data-bs-dismiss="modal"
                            aria-label="Close"><i class="icon-x-circle"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
