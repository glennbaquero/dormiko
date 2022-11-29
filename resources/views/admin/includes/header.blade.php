<header class="main-header" style="border-bottom:5px solid #f00">
  <!-- Logo -->

  <a href="" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini">D<b>R</b>M</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg admin-logo-lg">
      @include('includes.svg_logo')
    </span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="fas fa-align-justify"></span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        @if(\Auth::guard('admin')->user())
          <li>
            {{-- <a href="#">{{ \Auth::guard('admin')->user()->renderFullname() }}</a> --}}
          </li>
          <li>
            <a href="{{ route('admin.logout') }}">Logout</a>
          </li>
          @else
          <li>
            <a href="{{ route('tenant.logout') }}">Logout</a>
          </li>
        @endif
      </ul>
    </div>
  </nav>

</header>