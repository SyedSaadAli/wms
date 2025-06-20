<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        {{-- Get permissions for the logged-in user's role --}}
        @php
            $role = Auth::user()->role_id;
        @endphp

        @if (isset($role) && $role == 1)
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(1) != 'dashboard') collapsed @endif " href="{{ url('/dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(3) != 'vendor') collapsed @endif "
                    href="{{ url('panel/admin/vendor') }}">
                    <i class="bi bi-person"></i>
                    <span>Vendors</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(4) != 'approved-vendors') collapsed @endif "
                    href="{{ url('panel/admin/vendor/approved-vendors') }}">
                    <i class="bi bi-people"></i>
                    <span>Approved Vendors</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(4) == 'bookings') active @endif"
                    href="{{ route('admin.bookings') }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>All Bookings</span>
                </a>
            </li>
        @endif

        @if (isset($role) && $role == 2)
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(3) != 'profile') collapsed @endif "
                    href="{{ url('panel/vendor/profile') }}">
                    <i class="bi bi-person"></i>
                    <span>Business Profile</span>
                </a>
            </li>
        @endif

        @if (isset($role) && $role == 2)
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(3) != 'venue') collapsed @endif "
                    href="{{ url('panel/vendor/venue') }}">
                    <i class="bi bi-building"></i>
                    <span>Venues</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(3) != 'service') collapsed @endif "
                    href="{{ url('panel/vendor/service') }}">
                    <i class="bi bi-hand-thumbs-up"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if (Request::segment(1) != 'chat') collapsed @endif"
                    href="{{ route('vendor.chat.users') }}">
                    <i class="bi bi-chat"></i> Chat
                </a>
            </li>
        @endif


    </ul>

</aside>
<!-- End Sidebar-->
