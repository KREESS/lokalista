<ul class="list-unstyled topbar-nav float-end mb-0">
    <li class="dropdown hide-phone">
        <a class="nav-link dropdown-toggle arrow-none nav-icon" data-bs-toggle="dropdown" href="#" role="button"
            aria-haspopup="false" aria-expanded="false">
            <i class="ti ti-search"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-lg p-0">
            <!-- Top Search Bar -->
            <div class="app-search-topbar">
                <form action="#" method="get">
                    <input type="search" name="search" class="from-control top-search mb-0"
                        placeholder="Type text...">
                    <button type="submit"><i class="ti ti-search"></i></button>
                </form>
            </div>
        </div>
    </li>

    <li class="dropdown">
        <a class="nav-link dropdown-toggle nav-user" data-bs-toggle="dropdown" href="#" role="button"
            aria-haspopup="false" aria-expanded="false">
            <div class="d-flex align-items-center">
                @if (!empty(Auth::user()->foto_profile))
                    <img src="/foto_profile/{{ Auth::user()->foto_profile }}" alt="profile-user"
                        class="rounded-circle me-0 me-md-2 thumb-sm" />
                @else
                    <img src="/dapuranita/default.jpg" alt="profile-user"
                        class="rounded-circle me-0 me-md-2 thumb-sm" />
                @endif
                <div class="user-name">
                    <small class="d-none d-lg-block font-11">{{ Str::upper(Auth::user()->type) }}</small>
                    <span class="d-none d-lg-block fw-semibold font-12">
                        @php
                            $nama = explode(' ', Auth::user()->name);
                            echo Str::title($nama[0]);
                        @endphp
                        <i class="mdi mdi-chevron-down"></i></span>
                </div>
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
            <a class="dropdown-item" href="{{ route('superadmin.profile') }}"><i
                    class="ti ti-user font-16 me-1 align-text-bottom"></i> Profile</a>
            {{-- <a class="dropdown-item" href="#"><i class="ti ti-settings font-16 me-1 align-text-bottom"></i>
                Settings</a> --}}
            <div class="dropdown-divider mb-0"></div>
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
    document.getElementById('logout-form').submit();"><i
                    class="ti ti-power font-16 me-1 align-text-bottom"></i> Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </li>
    <!--end topbar-profile-->
    <li class="menu-item">
        <!-- Mobile menu toggle-->
        <a class="navbar-toggle nav-link" id="mobileToggle" onclick="toggleMenu()" onclick="toggleMenu()">
            <div class="lines">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </a><!-- End mobile menu toggle-->
    </li>
    <!--end menu item-->
</ul>
<!--end topbar-nav-->

<div class="navbar-custom-menu">
    <div id="navigation">
        <!-- Navigation Menu-->
        <ul class="navigation-menu">
            <li class="nav-item dropdown parent-menu-item">
                <a class="nav-link" href="{{ route('superadmin.dashboard') }}">
                    <span><i class="ti ti-smart-home menu-icon"></i>Dashboard</span>
                </a>
            </li>
            <li class="nav-item dropdown parent-menu-item">
                <a class="nav-link" href="{{ route('superadmin.laporan') }}">
                    <span><i class="ti ti-file-report menu-icon"></i>Laporan</span>
                </a>
            </li>
            <li class="nav-item dropdown parent-menu-item">
                <a class="nav-link" href="{{ route('superadmin.users.index') }}">
                    <span><i class="ti ti-file-report menu-icon"></i>Manage User</span>
                </a>
            </li>
            <li class="nav-item dropdown parent-menu-item">
                <a class="nav-link" href="{{ route('superadmin.pengaturan.index') }}">
                    <span><i class="ti ti-file-report menu-icon"></i>Pengaturan</span>
                </a>
            </li>
            <!--end nav-item-->

        </ul><!-- End navigation menu -->
    </div> <!-- end navigation -->
</div>
<!-- Navbar -->
