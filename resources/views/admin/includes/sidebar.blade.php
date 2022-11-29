<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image">
          <img src="{{ asset('storage/admin.png') }}" class="img-circle">
        </div>
        <div class="info">
          @if(Auth::guard('web')->check())
            <p> Tenant </p>
          @else
            <p> {{ Auth::guard('admin')->user()->type === 1 ? 'Billing Officer' : 'Administrator'}} </p>
            <p>{{ Auth::guard('admin')->user()->type === 1 ? Auth::guard('admin')->user()->building->name : '' }}</p>
          @endif
          {{-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> --}}
        </div>
        <p style="padding-top: 5px">Dashboard</p>
      </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">

      {{-- Tenant Overview --}}
      @if(Auth::guard('web')->check())
      <li class="{{ $checker->areOnRoutes(['tenant.overview']) }}">
         <a href="{{ route('tenant.overview') }}">
            <img src="storage/splices/Icons/Web App/Dashboard.svg" width="13%"><span> Overview</span>
          </a>
      </li>
      <li class="{{ $checker->areOnRoutes(['document.index']) }}">
         <a href="{{ route('document.index') }}">
            <img src="storage/splices/Icons/Web App/applicants.svg" width="7%"><span> Documents</span>
          </a>
      </li>
      <li class="{{ $checker->areOnRoutes(['payments']) }}">
         <a href="{{ route('payments') }}">
            <img src="storage/splices/Icons/Web App/payment.svg" width="13%"> <span> Payment</span>
          </a>
      </li>
      <li class="{{ $checker->areOnRoutes(['tenant.profile']) }}">
         <a href="{{ route('tenant.profile') }}">
            <img src="storage/splices/Icons/Web App/man-user.svg" width="10%"> <span>Profile</span>
          </a>
      </li>

      @elseif(Auth::guard('admin')->check())
      <li class="{{ $checker->areOnRoutes(['overview']) }}">
         <a href="{{ route('overview') }}">
            <img src="storage/splices/Icons/Web App/Dashboard.svg" width="13%">  <span>Overview</span>
          </a>
      </li>
      <li class="{{ $checker->areOnRoutes(['buildings']) }} treeview">
        <a>
          <img src="storage/splices/Icons/Web App/building1.svg" width="13%"> <span>Buildings</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
            <li class="">
              <a href="{{ route('buildings') }}">Buildings</a>
            </li>
            <li class="">
              <a href="{{ route('buildings') }}">Rooms</a>
            </li>
            <li class="">
              <a href="{{ route('buildings') }}">Tenants</a>
            </li>
        </ul>
      </li>
      @if(Auth::guard('admin')->user()->type !== 1)
      <li class="{{ $checker->areOnRoutes(['pages.index','page-items.index','carousel.index','about.index','gallery.index']) }} treeview">
        <a>
          <i class="fas fa-puzzle-piece"></i> <span>CMS</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li class="{{ $checker->areOnRoutes(['pages.index']) }}">
              <a href="{{ route('pages.index') }}"><i class="fas fa-boxes"></i> Page</a>
            </li>
            <li class="{{ $checker->areOnRoutes(['page-items.index']) }}">
              <a href="{{ route('page-items.index') }}"><i class="fas fa-boxes"></i> Page Item</a>
            </li>
            <li class="{{ $checker->areOnRoutes(['carousel.index']) }}">
              <a href="{{ route('carousel.index') }}"><i class="fas fa-boxes"></i> Carousel</a>
            </li>
            <li class="{{ $checker->areOnRoutes(['about.index']) }}">
              <a href="{{ route('about.index') }}"><i class="fas fa-boxes"></i> About Us Content</a>
            </li>
            <li class="{{ $checker->areOnRoutes(['gallery.index']) }}">
              <a href="{{ route('gallery.index') }}"><i class="fas fa-boxes"></i> Gallery</a>
            </li>
        </ul>
      </li>
      @endif
      <li class="{{ $checker->areOnRoutes(['applicants']) }} menu-open">
         <a href="{{ route('applicants') }}">
            <img src="storage/splices/Icons/Web App/applicants.svg" width="7%"> <span>Applicants</span>
          </a>
      </li>
      <li class="{{ $checker->areOnRoutes(['contracts']) }}">
         <a href="{{ route('contracts') }}">
            <img src="storage/splices/Icons/Web App/payment.svg" width="13%"> <span>Tenant</span>
          </a>
      </li>
      <li class="{{ $checker->areOnRoutes(['billing']) }}">
         <a href="{{ route('billing') }}">
            <img src="storage/splices/Icons/Web App/Billing.svg" width="11%"> <span>Billing</span>
          </a>
      </li>
      @if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->type === 0)
      <li class="{{ $checker->areOnRoutes(['permissions']) }}">
        <a href="{{ route('permissions') }}">
            <img src="storage/splices/Icons/Web App/adminpermission.svg" width="11%"> <span>Permission</span>
          </a>
       {{--  <a>
         <img src="storage/splices/Icons/Web App/adminpermission.svg" width="13%"> <span></span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
            <li class="">
              <a><i class="fas fa-boxes"></i> Administrator</a>
            </li>
            <li class="">
              <a href="{{ route('permissions') }}"><i class="fas fa-boxes"></i>Permission</a>
            </li>
        </ul> --}}
      </li>
      @endif
      @endif
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>