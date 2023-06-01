<nav class="navbar navbar-expand-lg sticky-top p-0 navbar-light bg-white shadow-sm">
  <div class="container-fluid p-0">
   <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="{{ url('/admin') }}">Admin Panel</a>
   <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link me-3 dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                @if (substr( auth()->user()->avatar, 0, 4 ) === "http")
                <img class="avatar-xs img-fluid rounded-circle" src="{{ auth()->user()->avatar }}">
                @else
                <img class="avatar-xs img-fluid rounded-circle" src="{{ url('/images/' . auth()->user()->avatar) }}">
                @endif
                {{ auth()->user()->name }}
                </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{ url('/home') }}">@lang('messages.mpanel')</a>
              <a class="dropdown-item" href="{{ url('/profile/' . auth()->user()->username) }}">@lang('messages.mpro')</a>
              <a class="dropdown-item" href="{{ url('/logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              @lang('messages.logout')
              </a>
              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
