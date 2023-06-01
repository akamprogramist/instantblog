<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-sidebar sidebar collapse" style="">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}" href="{{ url('/admin') }}"><i class="icon-house-door feather"></i>@lang('admin.dashboard')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('contents') ? 'active' : '' }}" href="{{ url('/contents') }}"><i class="icon-layers feather"></i>@lang('admin.posts')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('pages') ? 'active' : '' }}" href="{{ url('/pages') }}"><i class="icon-file-earmark feather"></i>@lang('admin.pages')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('cats') ? 'active' : '' }}" href="{{ url('/cats') }}"><i class="icon-grid feather"></i>@lang('admin.categories')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('settings') ? 'active' : '' }}" href="{{ url('/settings') }}"><i class="icon-gear feather"></i>@lang('admin.settings')</a>
        </li>
        @can('admin-secret')
        <li class="nav-item">
            <a class="nav-link {{ Request::is('adminprofile') ? 'active' : '' }}" href="{{ url('/adminprofile') }}"><i class="icon-person feather"></i>@lang('admin.profile')</a>
        </li>
        @endcan
        <li class="nav-item">
            <a class="nav-link {{ Request::is('users') ? 'active' : '' }}" href="{{ url('/users') }}"><i class="icon-people feather"></i>@lang('admin.users')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" target="_blank" href="{{ url('/') }}"><i class="icon-display feather"></i>@lang('admin.viewwebsite')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="icon-box-arrow-left feather"></i>@lang('admin.logout')</a>
        </li>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-5 mb-1 text-muted">
      <span>Instant Blog V.3.2</span>
    </h6>
    
  </div>
</nav>