<!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        {{-- Get permissions for the logged-in user's role --}}
        @php
            $role = Auth::user()->role_id;
        @endphp
      <li class="nav-item">
        <a class="nav-link @if(Request::segment(2) != 'dashboard') collapsed @endif " href="{{ url('/dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->


      @if (isset($role) && $role ==1)
      <li class="nav-item">
        <a class="nav-link @if(Request::segment(2) != 'vendor') collapsed @endif " href="{{ url('panel/admin/vendor') }}">
          <i class="bi bi-person"></i>
          <span>Vendors</span>
        </a>
      </li><!-- End Category Nav -->
      @endif

      @if (isset($role) && $role == 2)

      <li class="nav-item">
        <a class="nav-link @if(Request::segment(2) != 'profile') collapsed @endif " href="{{ url('panel/vendor/profile') }}">
          <i class="bi bi-person"></i>
          <span>Business Profile</span>
        </a>
      </li><!-- End Sub Category Nav -->
      @endif

      @if (isset($role) && $role == 2)

      <li class="nav-item">
        <a class="nav-link @if(Request::segment(2) != 'venue') collapsed @endif " href="{{ url('panel/vendor/venue') }}">
          <i class="bi bi-person"></i>
          <span>Venues</span>
        </a>
      </li><!-- End Product Nav -->
      @endif


    </ul>

  </aside>
  <!-- End Sidebar-->
